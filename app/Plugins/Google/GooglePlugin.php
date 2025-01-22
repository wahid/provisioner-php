<?php

namespace App\Plugins\Google;

use App\Events\{MemberChanged, GroupChanged, UserChanged};
use App\Plugins\PluginBase;
use App\Models\Plugin as PluginModel;
use App\Types\ChangeEventType;
use App\Types\Plugin as PluginType;
use App\Plugins\Google\Config;


class GooglePlugin implements PluginBase
{
    private const NAME = 'Google';

    private PluginModel $model;

    public function __construct()
    {
        $this->model = self::defaultModel();
    }

    public function handleGroupChangeEvent(GroupChanged $event): void {
        switch($event->type) {
            case ChangeEventType::CREATED:
                break;
            case ChangeEventType::UPDATED:
                break;
            case ChangeEventType::REMOVED:
                break;
        }
    }

    public function handleUserEvent(UserChanged $event): void {
        switch($event->type) {
            case ChangeEventType::CREATED:
                break;
            case ChangeEventType::UPDATED:
                break;
            case ChangeEventType::REMOVED:
                break;
        }
    }
    
    public function handleMemberEvent(MemberChanged $event): void {
      switch($event->type) {
            case ChangeEventType::CREATED:
                break;
            case ChangeEventType::UPDATED:
                break;
            case ChangeEventType::REMOVED:
                break;
        }
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
            'description' => 'Google plugin',
            'is_auto_activated' => true,
            'is_enabled' => true,
            'type' => PluginType::Identity,
            'config' => (array) new GoogleConfig(),
        ]);
    }

    public static function getName(): string
    {
        return self::NAME;
    }
}
