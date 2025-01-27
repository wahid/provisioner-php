<?php

use App\Plugins\Afas\{AfasPlugin, AfasConfig, AfasUserConverter};
use App\Plugins\PluginManager;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};

class AfasUserConverterTest extends Tests\TestCase
{
    use RefreshDatabase, WithFaker;

    private AfasPlugin $plugin;
    private AfasConfig $config;

    private AfasUserConverter $converter;
    public function setUp(): void
    {
        parent::setUp();
        $pluginManager = $this->app->make(PluginManager::class);
        $this->plugin = $pluginManager->getPlugin(AfasPlugin::getName());
        $this->config = $this->plugin->getConfig();
        $this->plugin = new AfasPlugin();
        $this->config = new AfasConfig();
        $this->converter = new AfasUserConverter($this->config, $this->plugin);
    }

    public function getContract()
    {
        return [
            "description" => $this->faker->jobTitle,
            "code" => $this->faker->unique()->bothify('GRP-####'),
            "function_title" => $this->faker->jobTitle,
            "function_code" => $this->faker->unique()->numerify('FUN-#####'),
            "end_date" => $this->faker->dateTimeBetween('+10 year', '+30 year')->format('Y-m-d'),
            "start_date" => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            "employment_number" => $this->faker->unique()->numerify('EMP-#####'),
        ];
    }

    public function getUser()
    {
        return [
            "upn" => $this->faker->unique()->safeEmail,
            "full_user_id" => $this->faker->unique()->userName,
            "person_id" => $this->faker->unique()->numerify('PER-#####'),
            "last_name" => $this->faker->lastName,
            "user_id" => $this->faker->unique()->numerify('USR-#####'),
            "middle_name" => $this->faker->lastName,
            "first_name" => $this->faker->firstName,
            "employment_start_date" => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            "employment_end_date" => $this->faker->dateTimeBetween('+1 year', '+5 year')->format('Y-m-d'),
            "employer_code" => $this->faker->unique()->numerify('EMP-#####'),
            "external_email" => $this->faker->unique()->safeEmail,
        ];
    }

    public function testImportUserAndContractsWithValidContract()
    {
        $user = $this->getUser();

        $contract = $this->getContract();

        $provisionedUser = $this->converter->importUserAndContracts($user, [$contract]);

        $this->assertNotNull($provisionedUser);

        // Check if the user is correctly imported
        $this->assertEquals($user['upn'], $provisionedUser->upn);
        $this->assertEquals($user['full_user_id'], $provisionedUser->full_user_id);
        $this->assertEquals($user['person_id'], $provisionedUser->person_id);
        $this->assertEquals($user['last_name'], $provisionedUser->last_name);
        $this->assertEquals($user['user_id'], $provisionedUser->user_id);
        $this->assertEquals($user['middle_name'], $provisionedUser->middle_name);
        $this->assertEquals($user['first_name'], $provisionedUser->first_name);
        $this->assertEquals(
            $this->converter->parseAfasDatetime($user['employment_start_date']),
            $provisionedUser->employment_start_date
        );
        $this->assertEquals(
            $this->converter->parseAfasDatetime($user['employment_end_date'], true),
            $provisionedUser->employment_end_date
        );
        $this->assertEquals($user['employer_code'], $provisionedUser->employer_code);
        $this->assertEquals($user['external_email'], $provisionedUser->external_email);

        // Check if the membership is correctly imported
        $this->assertCount(1, $provisionedUser->memberships);
        $this->assertEquals(
            $this->converter->parseAfasDatetime($contract['start_date']),
            $provisionedUser->memberships->first()->start_date
        );
        $this->assertEquals(
            $this->converter->parseAfasDatetime($contract['end_date'], true),
            $provisionedUser->memberships->first()->end_date
        );
        $this->assertEquals($contract['employment_number'], $provisionedUser->memberships->first()->employment_number);

        // Check if the group is correctly imported
        $group = $provisionedUser->memberships->first()->group;
        $this->assertEquals($contract['description'], $group->description);
        $this->assertEquals($contract['code'], $group->group_code);
        $this->assertEquals($contract['description'], $group->name);
        $this->assertEquals($this->config->createMailboxForGroups, $group->should_have_mailbox);
    }
}