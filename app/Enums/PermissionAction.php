<?php

namespace App\Enums;

enum PermissionAction: string
{
    case Create = 'create';
    case Read = 'read';
    case Update = 'update';
    case Delete = 'delete';
    case Approve = 'approve';
    case Reject = 'reject';
    case Export = 'export';
    case Import = 'import';
    case Restore = 'restore';
}
