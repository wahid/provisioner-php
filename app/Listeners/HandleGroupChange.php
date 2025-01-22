<?php

namespace App\Listeners;

use App\Events\{GroupChanged, GroupCreated, GroupRemoved, GroupUpdated};
use App\Plugins\PluginManager;

class HandleGroupChange
{
    /**
     * Handle the event.
     * @param GroupChanged $event
     * @return void
     */
    public function handle(GroupChanged $event): void
    {
        $plugins = PluginManager::getInstance()->getEnabledPlugins();

        foreach ($plugins as $plugin) {
            $plugin->handleGroupChangeEvent($event);
        }
    }
}
