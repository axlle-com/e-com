<?php

namespace App\Common\Http;

use App\Common\Models\Wallet\WalletCurrency;
use App\Common\Models\Wallet\WalletTransactionReason;
use App\Common\Models\Wallet\WalletTransactionType;

class Route
{
    public static function login()
    {
        return [
            'title' => 'Метод для авторизации',
            'route' => 'login',
            'comments' => 'Метод выдает токен для `Bearer authentication`',
            'version' => '1',
            'method' => 'post',
            'middleware' => null,
            'rule' => [
                'email' => 'required|email',
                'password' => 'required',
            ],
        ];
    }

    public static function registration()
    {
        return [
            'title' => 'Метод для регистрации',
            'route' => 'registration',
            'comments' => null,
            'version' => '1',
            'method' => 'post',
            'middleware' => null,
            'rule' => [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6'
            ],
        ];
    }

    public static function setWallet()
    {
        return [
            'title' => 'Метод для создания кошелька',
            'route' => 'set-wallet',
            'comments' => 'Метод закрыт Guard-ом, доступ по `Bearer authentication`',
            'version' => '1',
            'method' => 'post',
            'middleware' => null,
            'rule' => [
                'currency' => 'required|string|' . WalletCurrency::getCurrencyNameRule(),
                'deposit' => 'required|numeric',
            ],
        ];
    }

    public static function getWallet()
    {
        return [
            'title' => 'Получить данные кошелька',
            'route' => 'get-wallet',
            'comments' => 'Метод закрыт Guard-ом, доступ по `Bearer authentication`',
            'version' => '1',
            'method' => 'post',
            'middleware' => null,
            'rule' => [],
        ];
    }

    public static function getTransaction()
    {
        return [
            'title' => 'Получить список транзакций',
            'route' => 'get-transaction',
            'comments' => 'Метод закрыт Guard-ом, доступ по `Bearer authentication`',
            'version' => '1',
            'method' => 'post',
            'middleware' => null,
            'rule' => [
                'transaction_id' => 'nullable|integer',
                'transaction_value' => 'nullable|numeric',
                'wallet_id' => 'nullable|integer',
                'currency_id' => 'nullable|integer',
                'currency_name' => 'nullable|string|' . WalletCurrency::getCurrencyNameRule(),
                'currency_title' => 'nullable|string',
                'reason_id' => 'nullable|integer',
                'reason_name' => 'nullable|string|' . WalletTransactionReason::getReasonRule(),
                'reason_title' => 'nullable|string',
                'type_id' => 'nullable|integer',
                'type_name' => 'nullable|string|' . WalletTransactionType::getTypeRule(),
                'type_title' => 'nullable|string',
            ],
        ];
    }

    public static function setTransaction()
    {
        return [
            'title' => 'Создать транзакцию',
            'route' => 'set-transaction',
            'comments' => 'Метод закрыт Guard-ом, доступ по `Bearer authentication`',
            'version' => '1',
            'method' => 'post',
            'middleware' => null,
            'rule' => [
                'value' => 'required|numeric',
                'currency' => 'required|string|' . WalletCurrency::getCurrencyNameRule(),
                'reason' => 'required|string|' . WalletTransactionReason::getReasonRule(),
                'type' => 'required|string|' . WalletTransactionType::getTypeRule(),
            ],
        ];
    }

    public static function all()
    {
        return get_class_methods(new self());
    }
}
