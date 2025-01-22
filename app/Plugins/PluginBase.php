<?php

namespace App\Plugins;

use App\Events\{GroupChanged, MemberChanged, UserChanged};
use App\Models\{Plugin, ProvisionedUser};
use App\Types\PluginType;


trait IdentityPlugin {
    abstract public function getEmailBuilder(): object;
    abstract public function getConfig(): array;
    abstract public function getDomains(): array;

    public function emailBuilder(): object {
        return $this->getEmailBuilder();
    }

    public function config(): array {
        return $this->getConfig();
    }

    public function domains(): array {
        return $this->getDomains();
    }
}

trait DataPlugin {

    /**
     * @return array<ProvisionedUser>
     */
    public function employees(): array {
        return $this->getEmployees();
    }

    abstract public function getEmployees(): array;
}

interface PluginBase
{
    public function handleGroupChangeEvent(GroupChanged $event): void;
    public function handleUserEvent(UserChanged $event): void;
    public function handleMemberEvent(MemberChanged $event): void;
    public function getModel(): Plugin;
    public function setModel(Plugin $model): void;
    public function getType(): PluginType;
    public function isEnabled(): bool;
    public function save(): void;
    public static function defaultModel(): Plugin;
    public static function getName(): string;
}
