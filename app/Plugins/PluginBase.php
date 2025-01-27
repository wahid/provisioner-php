<?php

namespace App\Plugins;

use App\Events\{GroupChanged, MemberChanged, UserChanged};
use App\Models\Plugin;
use App\Types\PluginType;

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
