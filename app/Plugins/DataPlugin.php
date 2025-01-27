<?php

namespace App\Plugins;

use App\Models\ProvisionedUser;

trait DataPlugin {
    /**
     * @return array<ProvisionedUser>
     */
    public function employees(): array {
        return $this->getEmployees();
    }

    abstract public function getEmployees(): array;
}