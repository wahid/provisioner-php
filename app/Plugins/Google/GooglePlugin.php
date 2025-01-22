<?php

namespace App\Plugins\Google;

use App\Events\{MemberChanged, GroupChanged, UserChanged};
use App\Plugins\IdentityPlugin;
use App\Plugins\PluginBase;
use App\Models\Plugin;
use App\Types\PluginType;
use App\Types\ChangeEventType;


class GooglePlugin implements PluginBase
{
    use IdentityPlugin;

    private const NAME = 'Google';

    private Plugin $model;

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

    public function getEmailBuilder(): object {
        throw new \Exception('Not implemented');
    }

    public function getConfig(): array {
        return $this->model->config ?? [];
    }

    public function getDomains(): array {
        return $this->model->config['domains'];
    }
}
