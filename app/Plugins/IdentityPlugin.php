<?php

namespace App\Plugins;

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