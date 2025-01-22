<?php

namespace App\Types;

enum Access: string
{
    case Default = 'default';
    case Manual = 'manual';
    case Public = 'public';
    case Private = 'private';
}
