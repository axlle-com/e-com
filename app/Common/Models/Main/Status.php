<?php

namespace App\Common\Models\Main;

interface Status
{
    public const STATUS_POST = 1;
    public const STATUS_NEW = 2;
    public const STATUS_DRAFT = 3;
    public const STATUSES = [
        self::STATUS_POST => 'Проведен',
        self::STATUS_NEW => 'Новый',
        self::STATUS_DRAFT => 'Черновик',
    ];
}
