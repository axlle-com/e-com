<?php

namespace App\Common\Models\Telegram;

use App\Common\Models\Main\BaseModel;

class TelegramMessage extends BaseModel
{
    public $incrementing = false;
    protected $table = 'ax_telegram_message';
}