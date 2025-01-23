<?php

namespace App\Plugins\Afas;

class AfasConfig
{
    /* Connection details */
    public string $urlEndpoint = 'https://id.rest.afas.online/ProfitRestServices/connectors/';
    public string $organizationID = '';
    public string $base64Token = '';
    public string $integrationID = '';

    /* Endpoints key mapping */
    public array $contractEndpointsMapping = [
        "endpoint" => "IAM_Medewerker",
        "mappings" => [
            "OE" => "description",
            "OEcode" => "code",
            "Functie2" => "fuction_title",
            "Functiecode" => "function_code",
            "Einddatum_functie" => "end_date",
            "Begindatum_functie" => "start_date",
            "Volgnummer_dienstverband" => "employment_number"
        ]
    ];

    public array $userEndpointsMapping = [
        "endpoint" => "IAM_Gebruiker",
        "mappings" => [
            "UPN" => "upn",
            "Gebruiker" => "full_user_id",
            "Nummer" => "person_id",
            "Achternaam" => "last_name",
            "Medewerker" => "user_id",
            "Voorvoegsel" => "middle_name",
            "Voornaam" => "first_name",
            "Datum_in_dienst" => "employment_start_date",
            "Datum_uit_dienst" => "employment_end_date",
            "Werkgever_Code" => "employer_code",
            "E-mail_werk" => "external_email",
        ]
    ];

    /**
     * @var string[]
     */
    public array $requiredFieldsForContract = [];

    public string $userIDKey = "MedewerkerID";

    public string $userEndPoints = "KnUser";

    public string $personEndPoints = "KnPerson";

    public int $skipEmployeesWithEndDateAgeDays = 0;

    public int $keepContractAfterExpirationDays = 0;

    /* Customer-specific settings */
    public int $preStartCreationDays = 0;

    public int $postEndDeletionDays = 0;

    /**
     * @var string[]
     */
    public array $contractCodesToSkip = [];

    public array $functionCodesToSkip = [];

    public string $nonSalariedEmployerCode = '';

    public bool $disableLicenseForNonSalaried = false;

    public array $disableLicenseForFunctionCodes = [];

    public bool $createMailboxForGroups = false;

    /* Sync Back */
    public bool $syncPersonEmail = true;
    public int $syncPersonEmailDaysPreStart = 0;
    public bool $syncPersonEmailOnDelete = true;
    public bool $syncUserEmail = true;
    public int $syncUserEmailDaysPreStart = 0;
    public bool $syncUserEmailOnDelete = true;

    /* Other */
    public bool $eventsEnabled = false;
}