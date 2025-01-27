<?php

namespace App\Plugins;

trait IdentityPlugin {
    abstract public function getEmailBuilder(): object;
    abstract public function getConfig(): array;
    abstract public function getDomains(): array;
}