<?php

namespace App\Plugins;

use App\Models\Plugin as PluginModel;
use Illuminate\Support\Facades\Log;
use App\Types\Plugin as PluginType;
use App\Plugins\Google\GooglePlugin;
use App\Plugins\Afas\AfasPlugin;
use Exception;

class PluginManager
{
    /** @var array<PluginBase> */
    private array $plugins = [];

    /** @var PluginManager|null */
    private static ?PluginManager $instance = null;

    /**
     * Get the singleton instance of the Manager.
     *
     * @return PluginManager
     */
    public static function getInstance(): PluginManager
    {
        if (self::$instance === null) {
            self::$instance = new PluginManager();
            self::$instance->register(GooglePlugin::class);
            self::$instance->register(AfasPlugin::class);
        }

        return self::$instance;
    }

    /**
     * Register a plugin.
     *
     * @param string $plugin
     * @return void
     * @throws Exception
     */
    public function register(string $plugin): void
    {
        /** @var PluginBase $pluginInstance */
        $pluginInstance = new $plugin();
        $name = $pluginInstance->getName();

        if (isset($this->plugins[$name])) {
            throw new Exception("Plugin $name already registered");
        }

        $model = PluginModel::where('name', $name)->first();

        if ($model === null) {
            $pluginInstance->getModel()->save();
        } else {
            $pluginInstance->setModel($model);
        }

        $this->plugins[$name] = $pluginInstance;

        Log::info("Registered plugin $name");
    }

    /**
     * Get all registered plugins.
     *
     * @return array<PluginBase>
     */
    public function getPlugins(): array
    {
        return $this->plugins;
    }

    /**
     * Get a registered plugin by name.
     *
     * @param string $name
     * @return PluginBase
     * @throws Exception
     */
    public function getPlugin(string $name): PluginBase
    {
        if (!isset($this->plugins[$name])) {
            throw new Exception("Plugin $name not found");
        }

        return $this->plugins[$name];
    }

    /**
     * Get all registered plugins by type.
     *
     * @param PluginType $type
     * @return array<PluginBase>
     */
    public function getPluginsByType(PluginType $type): array
    {
        return array_filter($this->plugins, fn(PluginBase $plugin) => $plugin->getType() === $type);
    }

    /**
     * Get all enabled plugins.
     *
     * @return array<PluginBase>
     */
    public function getEnabledPlugins(): array
    {
        return array_filter($this->plugins, fn(PluginBase $plugin) => $plugin->isEnabled());
    }

    /**
     * Get all enabled plugins by type.
     *
     * @param PluginType $type
     * @return array<PluginBase>
     */
    public function getEnabledPluginsByType(PluginType $type): array
    {
        return array_filter($this->getEnabledPlugins(), fn(PluginBase $plugin) => $plugin->getType() === $type);
    }
}
