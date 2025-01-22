<?php

namespace App\State;

class Group implements StateBase
{
    public function toJson(): string
    {
        return json_encode($this);
    }

    public function getDiff(StateBase $other): array
    {
        return [];
    }

    static function fromArray(array $group): StateBase
    {
        $group = new Group();
        return $group;
    }

    static public function fromJson(string $json): void
    {
        $data = json_decode($json, true);
    }
}