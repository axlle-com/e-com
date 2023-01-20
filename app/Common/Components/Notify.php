<?php

namespace App\Common\Components;

use App\Common\Models\Main\BaseComponent;
use JsonException;
use NotificationChannels\Telegram\Exceptions\CouldNotSendNotification;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Telegram\TelegramUpdates;

# https://api.telegram.org:443/bot[токен телеграм бота]/setWebhook?url=[адрес по которому находится ваш php файл]

class Notify extends BaseComponent
{
    /**
     * @throws CouldNotSendNotification
     * @throws JsonException
     */
    public function send()
    {
        $updates = TelegramUpdates::create()->options(['timeout' => 0,])->get();

        if ($updates['ok']) {
            _dd_($updates);
            $chatId = $updates['result'][0]['message']['chat']['id'];
        }
        return TelegramMessage::create()
                              ->to(1270961441)
                              ->content('')
                              ->line('Привет')
                              ->line('Заказ оплачен')
                              ->line('Спасибо')
                              ->button('Посмотреть чек', 'https://fursie.ru/catalog/abrikos-set')
                              ->button('Скачать чек', 'https://fursie.ru/catalog/abrikos-set')
                              ->buttonWithCallback('Confirm', 'confirm_invoice ')
                              ->send();
    }
}