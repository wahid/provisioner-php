<?php

namespace App\Types;

enum AccessType: string
{
    case Default = 'default';
    case Manual = 'manual';
    case Public = 'public';
    case Private = 'private';
}
