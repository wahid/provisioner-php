<?php

namespace App\Types;

enum ChangeEventType {
    case CREATED;
    case UPDATED;
    case REMOVED;
}