<?php

namespace App\Enums;

enum AuditAction: string
{
    case Login = 'LOGIN';
    case Logout = 'LOGOUT';
    case LoginFailed = 'LOGIN_FAILED';
    case Create = 'CREATE';
    case Update = 'UPDATE';
    case Delete = 'DELETE';
    case Restore = 'RESTORE';
    case Approve = 'APPROVE';
    case Reject = 'REJECT';
    case Import = 'IMPORT';
    case Export = 'EXPORT';
    case Backup = 'BACKUP';
    case Print = 'PRINT';
}
