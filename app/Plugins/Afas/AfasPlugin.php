<?php

namespace App\Plugins\Afas;

use App\Plugins\PluginBase;
use App\Models\Plugin as PluginModel;
use App\Types\Plugin as PluginType;

class AfasPlugin implements PluginBase
{
    private const NAME = 'Afas';

    private PluginModel $model;

    public function __construct()
    {
        $this->model = self::defaultModel();
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
        return $this->model->type;
    }

    public function isEnabled(): bool
    {
        return $this->model->is_enabled;
    }

    public function save(): void
    {
        $this->model->save();
    }

    public static function defaultModel(): PluginModel
    {
        return new PluginModel([
            'name' => self::NAME,
            'description' => 'Afas plugin',
            'is_auto_activated' => true,
            'is_enabled' => true,
            'type' => PluginType::Identity,
            'config' => (array) new AfasConfig(),
        ]);
    }

    public static function getName(): string
    {
        return self::NAME;
    }
}
