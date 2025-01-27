<?php

namespace App\Console\Commands;

use App\Plugins\PluginManager;
use App\Types\PluginType;
use Illuminate\Console\Command;

class RunProvisioner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-provisioner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the provisioner to provision the data';

    protected array $actions = [
        'create',
        'update',
        'delete',
        'sync',
    ];

    /**
     * Execute the console command.
     */
    public function handle(PluginManager $manager): void
    {
        $dataProviders = collect($manager->getEnabledPluginsByType(PluginType::Data));

        if($dataProviders->count() === 0) {
            $this->error('No data providers found');
            return;
        }

        $identityProviders = collect($manager->getEnabledPluginsByType(PluginType::Identity));

        if($identityProviders->count() === 0) {
            $this->error('No identity providers found');
            return;
        }

        /** @var \App\Plugins\DataPlugin $dataProvider */
        $dataProvider = $dataProviders->first();
        $dataProvider->getUsers();

        /** @var \App\Plugins\IdentityPlugin $identityProvider */
        $identityProvider = $identityProviders->first();

        foreach($this->actions as $action) {
            $this->info("Running {$action} action");
            
            try {
                $identityProvider->{$action}();

                $this->info("{$action} action ran successfully");
            } catch(\Exception $e) {
                $this->error("Failed to run {$action} action: {$e->getMessage()}");
            }
        }
    }
}
