<?php

namespace App\Plugins\Afas;

use App\Events\{GroupChanged, MemberChanged, UserChanged};
use App\Plugins\{PluginBase, DataPlugin};
use App\Models\Plugin;
use App\Types\ChangeEventType;
use App\Types\PluginType;

class AfasPlugin implements PluginBase
{
    use DataPlugin;

    private const NAME = 'Afas';

    private Plugin $model;

    public function __construct()
    {
        $this->model = self::defaultModel();
    }

    public function handleGroupChangeEvent(GroupChanged $event): void {

    }

    public function handleUserEvent(UserChanged $event): void {

    }

    public function handleMemberEvent(MemberChanged $event): void {

    }

    public function getModel(): Plugin
    {
        return $this->model;
    }

    public function setModel(Plugin $model): void
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

    public static function defaultModel(): Plugin
    {
        return new Plugin([
            'name' => self::NAME,
            'description' => 'Afas plugin',
            'is_auto_activated' => true,
            'is_enabled' => true,
            'type' => PluginType::Data,
            'config' => (array) new AfasConfig(),
        ]);
    }

    public static function getName(): string
    {
        return self::NAME;
    }

    public function getEmployees(): array
    {
        return [];
    }
}
