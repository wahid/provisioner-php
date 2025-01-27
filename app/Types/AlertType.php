<?php

namespace App\Types;

enum AlertType: string
{
    case Created = 'created';
    case CreationFailed = 'creation_failed';
    case Updated = 'updated';
    case UpdateFailed = 'update_failed';
    case Deleted = 'deleted';
    case DeletionFailed = 'deletion_failed';
}

