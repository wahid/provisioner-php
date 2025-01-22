<?php

namespace App\State;

class User implements StateBase
{
    public function toJson(): string
    {
        return json_encode($this);
    }

    public function getDiff(StateBase $other): array
    {
        return [];
    }

    static function fromArray(array $user): StateBase
    {
        $user = new User();
        return $user;
    }

    static public function fromJson(string $json): void
    {
        $data = json_decode($json, true);
    }
}