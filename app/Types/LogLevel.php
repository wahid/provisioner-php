<?php

namespace App\Types;

enum LogLevel: string
{
    case Info = 'info';
    case Warning = 'warning';
    case Error = 'error';
    case Debug = 'debug';
}

