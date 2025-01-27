<?php

namespace App\Plugins;

trait IdentityTask {
    abstract public function create(): void;
    abstract public function update(): void;
    abstract public function delete(): void;
    abstract public function sync(): void;
}