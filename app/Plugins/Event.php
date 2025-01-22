<?php

namespace App\Plugins;

enum Event: string
{
    case UserCreated = 'user.created';
    case UserUpdated = 'user.updated';
    case UserDeleted = 'user.deleted';
    case GroupCreated = 'group.created';
    case GroupUpdated = 'group.updated';
    case GroupDeleted = 'group.deleted';
    case MemberCreated = 'member.created';
    case MemberUpdated = 'member.updated';
    case MemberDeleted = 'member.deleted';
}
