<?php

namespace App\Console\Commands;

use App\Plugins\DataPlugin;
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

        /** @var DataPlugin $dataProvider */
        $dataProvider = $dataProviders->first();

        $dataProvider->employees();
    }
}
