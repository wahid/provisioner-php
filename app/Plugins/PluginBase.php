<?php

namespace App\Plugins;

use App\Models\Plugin as PluginModel;
use App\Types\Plugin as PluginType;
use App\Plugins\Event;



interface PluginBase
{
    /**
     * Returns an array mapping an Event to a function.
     *
     * @return array An associative array where the keys are of type \App\Plugins\Event and the values are the corresponding functions.
     */
    public function getEventsMapping(): array;
    public function getModel(): PluginModel;
    public function setModel(PluginModel $model): void;
    public function getType(): PluginType;
    public function isEnabled(): bool;
    public function save(): void;
    public static function defaultModel(): PluginModel;
    public static function getName(): string;
}
