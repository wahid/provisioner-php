<?php

namespace App\Types;

enum PluginType: string
{
    case Generic = 'generic';
    case Data = 'data';
    case Identity = 'identity';
}
