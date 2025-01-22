<?php

namespace App\Types;

enum Alert: string
{
    case Created = 'created';
    case CreationFailed = 'creation_failed';
    case Updated = 'updated';
    case UpdateFailed = 'update_failed';
    case Deleted = 'deleted';
    case DeletionFailed = 'deletion_failed';
}

