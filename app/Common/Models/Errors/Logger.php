<?php

namespace App\Common\Models\Errors;

use App\Common\Models\Ips;
use Illuminate\Support\Str;
use App\Common\Models\User\UserWeb;
use App\Common\Models\User\UserApp;
use App\Common\Models\User\UserRest;

class Logger
{
    public const EMERGENCY = 'emergency';
    public const ALERT = 'alert';
    public const CRITICAL = 'critical';
    public const ERROR = 'error';
    public const WARNING = 'warning';
    public const NOTICE = 'notice';
    public const INFO = 'info';
    public const DEBUG = 'debug';

    public const CHANNEL_ERROR = 'error';
    public const CHANNEL_EXCEPTION = 'exception';
    public const CHANNEL_HISTORY = 'history';

    private static self $_instance;
    private string $uuid;
    private string $channel;

    public function __construct($channel = 'error')
    {
        $this->uuid = Str::uuid();
        if (defined(strtoupper(self::class . '::channel_' . $channel))) {
            $this->channel = $channel;
        } else {
            $this->channel = 'error';
        }
    }

    public static function model($channel = 'error'): self
    {
        if (empty(self::$_instance)) {
            self::$_instance = new self($channel);
        }
        return self::$_instance;
    }

    public function channel($channel = null): self
    {
        if ($channel && defined(strtoupper('channel_' . $channel))) {
            $this->channel = $channel;
        } else {
            $this->channel = 'error';
        }
        return $this;
    }

    public function emergency($message, array $context = []): self
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    public function alert($message, array $context = []): self
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    public function critical($message, array $context = []): self
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    public function error($message, array $context = []): self
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    public function warning($message, array $context = []): self
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    public function notice($message, array $context = []): self
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    public function info($message, array $context = []): self
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    public function debug($message, array $context = []): self
    {
        return $this->log(__FUNCTION__, $message, $context);
    }

    public function log($level, $message, array $context = []): self
    {
        $this->writeLog($level, $message, $context);
        return $this;
    }

    private function getUser()
    {
        if (UserWeb::auth()) {
            $user = UserWeb::auth();
        } else if (UserRest::auth()) {
            $user = UserRest::auth();
        } else if (UserApp::auth()) {
            $user = UserApp::auth();
        }
        return $user ?? null;
    }

    private function writeLog($level, $message, $context): void
    {
        $ips = Ips::createOrUpdate(['ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1']);
        $ipsId = $ips->id ?? null;
        MainLogger::createOrUpdate([
            'user_id' => $this->getUser()->id ?? null,
            'ips_id' => $ipsId,
            'uuid' => $this->uuid,
            'channel' => $this->channel,
            'level' => $level,
            'title' => $message,
            'body' => $context,
        ]);
    }
}