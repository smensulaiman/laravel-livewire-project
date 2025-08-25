<?php

namespace App\Enum;

enum Toaster: string
{
    case SUCCESS = 'success';
    case WARNING = 'warning';
    case FAILED = 'failed';
}
