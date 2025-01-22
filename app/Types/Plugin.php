<?php

namespace App\Types;

enum Plugin: string
{
    case Generic = 'generic';
    case Data = 'data';
    case Identity = 'identity';
}
