<?php

namespace App\Listeners;

use App\Events\{MemberChanged, MemberCreated, MemberRemoved, MemberUpdated};
use App\Plugins\PluginManager;


class HandleMemberChange
{
    /**
     * Handle the event.
     * @param MemberChanged $event
     * @return void
     */
    public function handle(MemberChanged $event): void
    {
        $plugins = PluginManager::getInstance()->getEnabledPlugins();

        foreach ($plugins as $plugin) {
            $plugin->handleMemberEvent($event);
        }
    }
}
