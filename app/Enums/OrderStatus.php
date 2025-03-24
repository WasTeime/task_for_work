<?php

namespace App\Enums;

enum OrderStatus: string
{
    case NEW = 'new';
    case DELIVERED = 'delivered';
}
