<?php

namespace App\Common\Models\Errors;

use Str;
use RuntimeException;

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
    private string $userId;
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

    public function setUser($uuid): self
    {
        $this->userId = $uuid;
        return $this;
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

    private function writeLog($level, $message, $context): void
    {
        MainLogger::createOrUpdate([
            'uuid' => $this->uuid,
            'channel' => $this->channel,
            'user_uuid' => $this->userId ?? null,
            'level' => $level,
            'message' => $message,
            'body' => $context,
        ]);
    }
}