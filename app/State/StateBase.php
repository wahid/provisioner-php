<?php

namespace App\State;

interface StateBase
{
    function toJson(): string;
    function getDiff(StateBase $other): array;

    static function fromArray(array $model): StateBase;
    static function fromJson(string $json): void;

}
