<?php

namespace App\Plugins;

use App\Events\{GroupChanged, MemberChanged, UserChanged};
use App\Models\Plugin as PluginModel;
use App\Types\Plugin as PluginType;

interface PluginBase
{
    public function handleGroupChangeEvent(GroupChanged $event): void;
    public function handleUserEvent(UserChanged $event): void;
    public function handleMemberEvent(MemberChanged $event): void;
    public function getModel(): PluginModel;
    public function setModel(PluginModel $model): void;
    public function getType(): PluginType;
    public function isEnabled(): bool;
    public function save(): void;
    public static function defaultModel(): PluginModel;
    public static function getName(): string;
}
