<?php

namespace App\Listeners;

use App\Events\{UserChanged, UserCreated, UserRemoved, UserUpdated};
use App\Plugins\PluginManager;

class HandleUserChange
{

    /**
     * Handle the event.
     * @param UserChanged $event
     * @return void
     */
    public function handle(UserChanged $event): void
    {
        $plugins = PluginManager::getInstance()->getEnabledPlugins();

        foreach ($plugins as $plugin) {
            $plugin->handleUserEvent($event);
        }
    }
}
