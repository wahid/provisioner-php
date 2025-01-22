<?php

namespace App\Plugins\Alert;

use App\Plugins\PluginBase;
use App\Models\Plugin as PluginModel;
use App\Types\Plugin as PluginType;


class Plugin implements PluginBase
{
    private const NAME = 'Alert';

    private PluginModel $model;

    public function __construct()
    {
        $this->model = Plugin::defaultModel();
    }

    public function getEventsMapping(): array
    {
        return [];
    }

    public function getModel(): PluginModel
    {
        return $this->model;
    }

    public function setModel(PluginModel $model): void
    {
        $this->model = $model;
    }

    public function getType(): PluginType
    {
        return PluginType::Generic;
    }

    public function isEnabled(): bool
    {
        return true;
    }

    public function save(): void
    {
        $this->model->save();
    }

    public static function defaultModel(): PluginModel
    {
        return new PluginModel([
            'name' => self::NAME,
            'description' => 'Alert plugin',
            'is_auto_activated' => true,
            'is_enabled' => true,
            'type' => PluginType::Generic,
            'config' => (array) new Config(),
        ]);
    }

    public static function getName(): string
    {
        return self::NAME;
    }
}
