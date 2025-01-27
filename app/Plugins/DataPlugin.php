<?php

namespace App\Plugins;

use App\Models\ProvisionedUser;

trait DataPlugin {
    /**
     * @return array<ProvisionedUser>
     */
    abstract public function getUsers(): array;
}