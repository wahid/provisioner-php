<?php

class EmployerDomain
{
    public string $employerCode;
    public string $emailDomain;

    public function __construct(string $employerCode, string $emailDomain)
    {
        $this->employerCode = $employerCode;
        $this->emailDomain = $emailDomain;
    }
}

class EmployerOrgUnitPath
{
    public string $employerCode;
    public string $orgUnitPath;

    public function __construct(string $employerCode, string $orgUnitPath)
    {
        $this->employerCode = $employerCode;
        $this->orgUnitPath = $orgUnitPath;
    }
}

class ServiceAccount
{
    public string $type = 'service_account';
    public string $privateKeyID = '1234567890';
    public string $privateKey = '1234567890';
    public string $clientEmail = 'test@test.com';
    public string $clientID = '1234567890';
    public string $authURI = 'https://accounts.google.com/o/oauth2/auth';
    public string $tokenURI = 'https://oauth2.googleapis.com/token';
}

class ConnectionDetails
{
    public ServiceAccount $serviceAccount;
    public string $serviceAccountBase64 = '';
    public string $subject = '';
    public string $customer = '';

    public function __construct()
    {
        $this->serviceAccount = new ServiceAccount();
    }
}

class EmploymentDatesConfig
{
    public bool $setUserDates = false;
    public string $customSchema = '';
    public string $startDateField = '';
    public string $endDateField = '';
    public string $unknownEndDateValue = '';
}

class EmailConfig
{
    public string $seperator = '';
    public string $groupSeparator = '';
    public string $indexSeparator = '';
    public int $indexStart = 0;
    public bool $includeFirstName = false;
    public bool $useFullFirstName = false;
    public bool $useSeperatorAfterFirstName = false;
    public bool $includeMiddleName = false;
    public bool $useFullMiddleName = false;
    public bool $useSeperatorAfterMiddleName = false;
    public bool $includeLastName = false;
    public bool $useSeperatorGroup = false;
    public string $mailboxPrefix = '';
}

class Config
{
    public ConnectionDetails $connectionDetails;

    // Domains
    /** @var string[] */
    public array $domains = [];

    /** @var EmployerDomain[] */
    public array $employerDomains = [];

    // Org Unit Paths
    public string $orgUnitPath = '';

    public string $orgUnitPathNonSalaried = '';

    public string $orgUnitPathMailboxes = '';

    /** @var string[] */
    public array $additionalOrgUnitPaths = [];

    /** @var EmployerOrgUnitPath[] */
    public array $employerOrgUnitPaths = [];

    // User Password
    public string $defaultUserPassword = '';
    public bool $forceUserPasswordChange = false;

    // Additional User Fields
    public bool $setUserExternalID = false;
    public bool $setUserOrganisation = false;
    public bool $setUserOrganisationCostCenter = false;
    public EmploymentDatesConfig $employmentDatesConfig;

    // Email address Formatting
    public EmailConfig $emailConfig;

    // Dryrun and deletion toggles
    public bool $dryRun = false;
    public bool $deleteUsers = false;
    public bool $deleteGroups = false;
    public bool $deleteMembers = false;
    public bool $updateGroupSettings = false;

    // Licensing and activation
    public string $skuID = '';
    public int $preStartActivationDays = 0;
    public bool $activateUsers = false;
    public bool $revokeLicenses = false;

    // Other
    public string $groupSpamLevel = '';
    public string $recoveryNumberCountryCode = '';
    public bool $eventsEnabled = false;

    public function __construct()
    {
        $this->connectionDetails = new ConnectionDetails();
        $this->employmentDatesConfig = new EmploymentDatesConfig();
        $this->emailConfig = new EmailConfig();
    }
}

$config = new Config();


echo json_encode($config);
