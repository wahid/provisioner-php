<?php

namespace App\Plugins\Afas;

use App\Models\ProvisionedUser;

class AfasProvider
{
    private AfasConfig $config;
    private AfasClient $client;
    private AfasPlugin $plugin;
    private AfasUserConverter $converter;

    public function __construct(
        AfasConfig $config,
        AfasClient $client,
        AfasPlugin $plugin,
        AfasUserConverter $converter
    ) {
        $this->config = $config;
        $this->client = $client;
        $this->plugin = $plugin;
        $this->converter = $converter;
    }

    /**
     * Renames the fields of the given object based on the provided mappings.
     *
     * @param array $obj The object whose fields need to be renamed.
     * @param array $mappings An associative array where the keys are the original field names and the values are the new field names.
     * @return array The object with renamed fields.
     */
    public function renameFields(array $obj, array $mappings): array
    {
        $renamedObj = [];

        foreach ($obj as $key => $value) {
            $newKey = $mappings[$key] ?? $key;
            $renamedObj[$newKey] = $value;
        }

        return $renamedObj;
    }

    public function convertToProvisionedUser(array $data): ?ProvisionedUser
    {
        if (!isset($data['user']) || !isset($data['contacts'])) {
            return null;
        }
        return $this->converter->importUserAndContracts($data['user'], $data['contacts']);
    }

    /**
     * Fetches and returns provisioned users.
     *
     * @return array<ProvisionedUser>|null
     */
    public function getProvisionedUsers(): ?array
    {
        $users = [];

        // use literal to transform userEndpointsMapping
        $userEndpointsMapping = literal(...$this->config->userEndpointsMapping);
        $userResults = $this->fetchDataFromEndpoint($userEndpointsMapping->endpoint);
        if ($userResults === null) {
            return null;
        }

        foreach ($userResults as $user) {
            $remappedUser = $this->renameFields($user, $userEndpointsMapping->mappings);
            $userID = $remappedUser[$this->config->userIDKey];
            $users[$userID] = ['user' => $remappedUser, 'contacts' => []];
        }

        $contractEndpointsMapping = literal(...$this->config->contractEndpointsMapping);
        $contactResults = $this->fetchDataFromEndpoint($contractEndpointsMapping->endpoint);
        if ($contactResults === null) {
            return null;
        }

        foreach ($contactResults as $contact) {
            $remappedContact = $this->renameFields($contact, $contractEndpointsMapping->mappings);
            $userID = $remappedContact[$this->config->userIDKey];
            if (isset($users[$userID])) {
                $users[$userID]['contacts'][] = $remappedContact;
            }
        }

        return array_reduce($users, [$this, 'reduceUsers'], []);
    }

    /**
     * Reducer function for the array_reduce call in getProvisionedUsers.
     *
     * @param array $carry The accumulator array.
     * @param array $user The user data to process.
     * @return array The accumulator array with the processed user data appended.
     */
    private function reduceUsers(array $carry, array $user): array
    {
        $provisionedUser = $this->convertToProvisionedUser($user);
        if ($provisionedUser !== null) {
            $carry[] = $provisionedUser;
        }
        return $carry;
    }

    /**
     * Fetches data from the given endpoint.
     * This method sends a GET request to the specified endpoint using the AfasClient.
     * It expects the response to be an array containing a 'rows' key, which holds the actual data.
     *
     * @param string $endpoint The endpoint URL to fetch data from.
     * @return array|null Returns an array of rows if the request is successful and the response contains 'rows', null otherwise.
     *
     */
    private function fetchDataFromEndpoint(string $endpoint): ?array
    {
        $results = $this->client->get($endpoint);

        if (is_array($results) && array_key_exists('rows', $results)) {
            return $results['rows'];
        }
        return null;
    }
}