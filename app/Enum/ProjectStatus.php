<?php

namespace App\Enum;

enum ProjectStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in-progress';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
}
