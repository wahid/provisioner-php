<?php

namespace App\Plugins;

use App\Models\Plugin as PluginModel;
use Illuminate\Support\Facades\Log;

use App\Types\Plugin as PluginType;
use App\Plugins\Google\GooglePlugin;
use App\Plugins\Afas\AfasPlugin;

class Manager
{
    /** @var array<PluginBase> */
    private array $plugins = [];

    public static function getInstance(): Manager
    {
        $manager = new Manager();
        $manager->register(GooglePlugin::class);
        $manager->register(AfasPlugin::class);
        return $manager;
    }

    public function register(string $plugin): void
    {
        /** @var PluginBase $plugin */
        $plugin = new $plugin();
        $name = $plugin->getName();
        if (isset($this->plugins[$name])) {
            throw new \Exception("Plugin $name already registered");
        }

        $model = PluginModel::where('name', $name)->first();

        if ($model === null) {
            $plugin->getModel()->save();
        } else {
            $plugin->setModel($model);
        }

        $this->plugins[$name] = $plugin;

        Log::info("Registered plugin $name");
    }

    /** @return array<PluginBase> */
    public function getPlugins(): array
    {
        return $this->plugins;
    }

    public function getPlugin(string $name): PluginBase
    {
        return $this->plugins[$name];
    }

    /** @return array<PluginBase> */
    public function getPluginsByType(PluginType $type): array
    {
        return array_filter($this->plugins, fn(PluginBase $plugin) => $plugin->getType() === $type);
    }

    public function getEnabledPlugins(): array
    {
        return array_filter($this->plugins, fn(PluginBase $plugin) => $plugin->isEnabled());
    }

    public function getEnabledPluginsByType(PluginType $type): array
    {
        return array_filter($this->getEnabledPlugins(), fn(PluginBase $plugin) => $plugin->getType() === $type);
    }
}
