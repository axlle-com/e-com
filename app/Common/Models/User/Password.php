<?php

namespace App\Common\Models\User;

use Exception;
use Illuminate\Support\Str;
use InvalidArgumentException;

trait Password
{
    private $_useLibreSSL;
    private $_randomFile;

    public int $passwordHashCost = 13;

    private function isWindows()
    {
        return DIRECTORY_SEPARATOR !== '/';
    }

    private function shouldUseLibreSSL(): bool
    {
        if ($this->_useLibreSSL === null) {
            $this->_useLibreSSL = defined('OPENSSL_VERSION_TEXT')
                && preg_match('{^LibreSSL (\d\d?)\.(\d\d?)\.(\d\d?)$}', OPENSSL_VERSION_TEXT, $matches)
                && (10000 * $matches[1]) + (100 * $matches[2]) + $matches[3] >= 20105;
        }

        return $this->_useLibreSSL;
    }

    private function generateRandomKey($length = 32): string
    {
        if (!is_int($length)) {
            throw new InvalidArgumentException('First parameter ($length) must be an integer');
        }

        if ($length < 1) {
            throw new InvalidArgumentException('First parameter ($length) must be greater than 0');
        }

        if (function_exists('random_bytes')) {
            return random_bytes($length);
        }

        if (function_exists('openssl_random_pseudo_bytes')
            && ($this->shouldUseLibreSSL() || $this->isWindows())
        ) {
            $key = openssl_random_pseudo_bytes($length, $cryptoStrong);
            if ($cryptoStrong === false) {
                throw new Exception(
                    'openssl_random_pseudo_bytes() set $crypto_strong false. Your PHP setup is insecure.'
                );
            }
            if ($key !== false && mb_strlen($key, '8bit') === $length) {
                return $key;
            }
        }

        if (function_exists('mcrypt_create_iv')) {
            $key = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
            if (mb_strlen($key, '8bit') === $length) {
                return $key;
            }
        }


        if ($this->_randomFile === null && !$this->isWindows()) {
            $device = PHP_OS === 'FreeBSD' ? '/dev/random' : '/dev/urandom';
            $lstat = @lstat($device);
            if ($lstat !== false && ($lstat['mode'] & 0170000) === 020000) {
                $this->_randomFile = fopen($device, 'rb') ?: null;

                if (is_resource($this->_randomFile)) {
                    $bufferSize = 8;

                    if (function_exists('stream_set_read_buffer')) {
                        stream_set_read_buffer($this->_randomFile, $bufferSize);
                    }
                    if (function_exists('stream_set_chunk_size')) {
                        stream_set_chunk_size($this->_randomFile, $bufferSize);
                    }
                }
            }
        }

        if (is_resource($this->_randomFile)) {
            $buffer = '';
            $stillNeed = $length;
            while ($stillNeed > 0) {
                $someBytes = fread($this->_randomFile, $stillNeed);
                if ($someBytes === false) {
                    break;
                }
                $buffer .= $someBytes;
                $stillNeed -= mb_strlen($someBytes, '8bit');
                if ($stillNeed === 0) {
                    return $buffer;
                }
            }
            fclose($this->_randomFile);
            $this->_randomFile = null;
        }

        throw new Exception('Unable to generate a random key');
    }

    private function generateSalt($cost = 13): string
    {
        $cost = (int)$cost;
        if ($cost < 4 || $cost > 31) {
            throw new InvalidArgumentException('Cost must be between 4 and 31.');
        }

        $rand = $this->generateRandomKey(20);
        $salt = sprintf('$2y$%02d$', $cost);
        $salt .= str_replace('+', '.', substr(base64_encode($rand), 0, 22));

        return $salt;
    }

    private function compareString($expected, $actual): bool
    {
        if (!is_string($expected)) {
            throw new InvalidArgumentException('Expected expected value to be a string, ' . gettype($expected) . ' given.');
        }

        if (!is_string($actual)) {
            throw new InvalidArgumentException('Expected actual value to be a string, ' . gettype($actual) . ' given.');
        }

        if (function_exists('hash_equals')) {
            return hash_equals($expected, $actual);
        }

        $expected .= "\0";
        $actual .= "\0";
        $expectedLength = mb_strlen($expected, '8bit');
        $actualLength = mb_strlen($actual, '8bit');
        $diff = $expectedLength - $actualLength;
        for ($i = 0; $i < $actualLength; $i++) {
            $diff |= (ord($actual[$i]) ^ ord($expected[$i % $expectedLength]));
        }

        return $diff === 0;
    }

    public function generatePasswordHash($password, $cost = null)
    {
        if ($cost === null) {
            $cost = $this->passwordHashCost;
        }

        if (function_exists('password_hash')) {
            return password_hash($password, PASSWORD_DEFAULT, ['cost' => $cost]);
        }

        $salt = $this->generateSalt($cost);
        $hash = crypt($password, $salt);
        if (!is_string($hash) || strlen($hash) !== 60) {
            throw new Exception('Unknown error occurred while generating hash.');
        }

        return $hash;
    }

    public function validatePassword($password, $hash = null): bool
    {
        if ($hash === null) {
            $hash = $this->password_hash ?? null;
            if (!$hash) {
                return false;
            }
        }
        if (!is_string($password) || $password === '') {
            throw new InvalidArgumentException('Password must be a string and cannot be empty.');
        }

        if (!preg_match('/^\$2[axy]\$(\d\d)\$[\.\/0-9A-Za-z]{22}/', $hash, $matches)
            || $matches[1] < 4
            || $matches[1] > 30
        ) {
            throw new InvalidArgumentException('Hash is invalid.');
        }

        if (function_exists('password_verify')) {
            return password_verify($password, $hash);
        }

        $test = crypt($password, $hash);
        $n = strlen($test);
        if ($n !== 60) {
            return false;
        }

        return $this->compareString($test, $hash);
    }

    public function generatePassword(bool $int = true): string
    {
        return $int ? sprintf("%06d", random_int(100000, 999999)) : Str::random(6);
    }
}
