<?php

namespace App\Types;

enum UserActivation: string
{
    case Default = 'default';
    case ForcedEnabled = 'forced_enabled';
    case ForcedDisabled = 'forced_disabled';
}
