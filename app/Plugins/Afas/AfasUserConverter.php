<?php

namespace App\Plugins\Afas;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\ProvisionedUser;
use App\Models\Group;
use App\Models\Member;
use App\Models\MemberFunction;
use Exception;

class AfasUserConverter
{
    private AfasConfig $config;
    private AfasPlugin $plugin;

    public function __construct(AfasConfig $config, AfasPlugin $plugin)
    {
        $this->config = $config;
        $this->plugin = $plugin;
    }

    /**
     * Parses the given AFAS datetime as a local datetime and returns it in the timezone Laravel is running in.
     * If it's an end date, it adjusts the time to the end of the day (23:59:59).
     *
     * @param string $afasDatetime
     * @param bool $endDate
     * @return Carbon
     */
    public function parseAfasDatetime(string $afasDatetime, bool $endDate = false): Carbon
    {
        // Parse the AFAS datetime
        $parsed = Carbon::parse($afasDatetime);

        // Adjust the datetime to the timezone Laravel is running in
        $adjusted = $parsed->setTimezone(config('app.timezone'));

        // If it's an end date, adjust the time to the end of the day
        if ($endDate) {
            $adjusted->setTime(23, 59, 59);
        }

        return $adjusted;
    }

    /**
     * Imports user and contracts data.
     *
     * @param array $user
     * @param array $contracts
     * @return ProvisionedUser|null
     */
    public function importUserAndContracts(array $user, array $contracts): ?ProvisionedUser
    {
        $provisionedUser = $this->getOrCreateUser($user);

        if ($provisionedUser && !$provisionedUser->should_ignore_contracts) {
            foreach ($contracts as $contract) {
                $this->processContract($provisionedUser, $contract);
            }
        }

        return $provisionedUser;
    }

    /**
     * Gets or creates a provisioned user.
     *
     * @param array $user
     * @return ProvisionedUser
     */
    public function getOrCreateUser(array $user): ?ProvisionedUser
    {
        try {
            $provisionedUser = ProvisionedUser::firstOrNew([
                'user_id' => $user['user_id'],
            ]);

            array_walk($user, function (&$value, $key) use ($provisionedUser) {
                if (($key === 'employment_start_date' || $key === 'employment_end_date') && $value) {
                    $value = $this->parseAfasDatetime($value, $key === 'employment_end_date');
                }
                $provisionedUser->$key = $value;
            });

            $provisionedUser->save();

            return $provisionedUser;
        } catch (Exception $e) {
            dd($e);
            Log::error('Error creating or updating provisioned user', ['user' => $user, 'error' => $e->getMessage()]);
        }

        return null;
    }

    /**
     * Processes a contract for a provisioned user.
     *
     * @param ProvisionedUser $provisionedUser
     * @param array $contract
     * @return void
     */
    private function processContract(ProvisionedUser $provisionedUser, array $contract): void
    {
        if (!empty($contract['start_date'])) {
            $contract['start_date'] = $this->parseAfasDatetime($contract['start_date']);
        }

        if (!empty($contract['end_date'])) {
            $contract['end_date'] = $this->parseAfasDatetime($contract['end_date'], true);
        }

        if ($this->shouldKeepContract($contract)) {
            $group = $this->getOrCreateGroup($contract);
            $this->createOrUpdateMembership($provisionedUser, $group, $contract);
        }
    }

    /**
     * Determines if a new contract should be kept.
     *
     * @param array $contract
     * @return bool
     */
    private function shouldKeepContract(array $contract): bool
    {
        if (in_array($contract['code'], $this->config->contractCodesToSkip)) {
            return false;
        }
        if (in_array($contract['function_code'], $this->config->functionCodesToSkip)) {
            return false;
        }
        if (!empty($contract['end_date']) && $contract['end_date']->lt(Carbon::now()->subDays($this->config->keepContractAfterExpirationDays))) {
            return false;
        }
        return true;
    }

    /**
     * Gets or creates a group for a contract if it doesn't exist.
     *
     * @param array $contract
     * @return Group
     */
    private function getOrCreateGroup(array $contract): Group
    {
        $group = Group::firstOrCreate(
            ['group_code' => $contract['code']],
            [
                'name' => $contract['description'],
                'description' => $contract['description'],
                'should_have_mailbox' => $this->config->createMailboxForGroups,
            ]
        );

        if ($group->wasRecentlyCreated) {
            Log::info('Group created', ['group_code' => $group->group_code, 'name' => $group->name]);
        }

        return $group;
    }

    /**
     * Creates or updates a membership for a provisioned user in a group.
     *
     * @param ProvisionedUser $provisionedUser
     * @param Group $group
     * @param array $contract
     * @return void
     */
    private function createOrUpdateMembership(ProvisionedUser $provisionedUser, Group $group, array $contract): void
    {
        $memberFunction = MemberFunction::firstOrCreate(
            ['code' => $contract['function_code']],
            ['title' => $contract['function_title']]
        );

        $member = Member::firstOrCreate(
            [
                'provisioned_user_id' => $provisionedUser->id,
                'group_id' => $group->id,
                'member_function_id' => $memberFunction->id,
            ],
            [
                'start_date' => $contract['start_date'],
                'end_date' => $contract['end_date'],
                'employment_number' => $contract['employment_number'],
            ]
        );

        if ($member->wasRecentlyCreated) {
            Log::info('Member created', [
                'user_id' => $provisionedUser->user_id,
                'group_code' => $group->group_code,
                'function_code' => $memberFunction->code
            ]);
        } else if ($member->start_date->ne($contract['start_date']) || $member->end_date->ne($contract['end_date'])) {
            $member->update([
                'start_date' => $contract['start_date'],
                'end_date' => $contract['end_date'],
            ]);

            Log::info('Member updated', [
                'user_id' => $provisionedUser->user_id,
                'group_code' => $group->group_code,
                'function_code' => $memberFunction->code
            ]);
        }

    }
}