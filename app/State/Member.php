<?php

namespace App\State;

class Member implements StateBase
{
    public function getDiff(StateBase $other): array
    {
        return [];
    }

    public function toJson(): string
    {
        return json_encode($this);
    }

    static function fromArray(array $member): StateBase
    {
        $member = new Member();
        return $member;
    }

    static public function fromJson(string $json): void
    {
        $data = json_decode($json, true);

    }
}