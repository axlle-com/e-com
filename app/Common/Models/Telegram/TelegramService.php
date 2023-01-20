<?php

namespace App\Common\Models\Telegram;

use App\Common\Models\Main\BaseComponent;
use App\Common\Models\Setting\Setting;
use Exception;
use JsonException;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Telegram\TelegramUpdates;

# https://api.telegram.org:443/bot[токен телеграм бота]/setWebhook?url=[адрес по которому находится ваш php файл]

/**
 * @property string $token
 */
class TelegramService extends BaseComponent
{
    public int $timeout = 60;

    /**
     * @throws Exception
     */
    public function init(): static
    {
        $this->load([
            'token' => Setting::get('telegram_bot_token')['bd'],
        ]);
        return $this;
    }

    /**
     * @throws CouldNotSendNotification
     * @throws JsonException
     */
    public function send()
    {
        return TelegramMessage::create()
                              ->to(1270961441)
                              ->token($this->token)
                              ->content('')
                              ->line('Привет')
                              ->line('Заказ оплачен')
                              ->line('Спасибо')
                              ->button('Посмотреть чек', 'https://fursie.ru/catalog/abrikos-set')
                              ->button('Скачать чек', 'https://fursie.ru/catalog/abrikos-set')
                              ->buttonWithCallback('Confirm', 'confirm_invoice ')
                              ->send();
    }

    /**
     * @throws JsonException
     */
    public function update()
    {
        $updates = TelegramUpdates::create()->options(['timeout' => $this->timeout])->get();
        if ($updates['ok']) {
            _dd_($updates);
        }
    }
}