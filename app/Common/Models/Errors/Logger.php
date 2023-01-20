<?php

namespace App\Common\Models\Errors;

use App\Common\Models\Ips;
use App\Common\Models\User\UserApp;
use App\Common\Models\User\UserRest;
use App\Common\Models\User\UserWeb;
use Illuminate\Support\Str;

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

    public const CHANNEL_DATABASE = 'database';

    public const GROUP_ERROR = 'error';
    public const GROUP_EXCEPTION = 'exception';
    public const GROUP_HISTORY = 'history';
    public static array $levels = [
        self::EMERGENCY => 0,
        self::ALERT => 1,
        self::CRITICAL => 2,
        self::ERROR => 3,
        self::WARNING => 4,
        self::NOTICE => 5,
        self::INFO => 6,
        self::DEBUG => 7,
    ];
    private static array $_instance;
    private string $uuid;
    private string $channel;
    private string $group;

    public function __construct($group = 'error')
    {
        $this->channel = self::CHANNEL_DATABASE;
        $this->uuid = Str::uuid();
        if (defined(strtoupper(self::class . '::group_' . $group))) {
            $this->group = $group;
        } else {
            $this->group = 'error';
        }
    }

    public static function model($group = 'error'): self
    {
        $class = static::class;
        if (empty(self::$_instance[$class])) {
            self::$_instance[$class] = new static($group);
        }
        return self::$_instance[$class];
    }

    public function group($group = null): self
    {
        if ($group && defined(strtoupper(self::class . '::group_' . $group))) {
            $this->group = $group;
        } else {
            $this->group = 'error';
        }
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

    public function log($level, $message, array $context = []): self
    {
        $this->writeLog($level, $message, $context);
        return $this;
    }

    private function writeLog($level, $message, $context): void
    {
        $level = array_key_exists($level, self::$levels) ? $level : 'debug';
        $ips = Ips::createOrUpdate(['ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1']);
        $ipsId = $ips->id ?? null;
        if ($this->channel === self::CHANNEL_DATABASE) {
            MainLogger::createOrUpdate([
                'user_id' => $this->getUser()->id ?? null,
                'ips_id' => $ipsId,
                'uuid' => $this->uuid,
                'channel' => $this->group,
                'level' => $level,
                'title' => $message,
                'body' => $context,
            ]);
        }
    }

    private function getUser()
    {
        $user = UserWeb::auth() ?: (UserRest::auth() ?: UserApp::auth());
        return $user ?? null;
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
}