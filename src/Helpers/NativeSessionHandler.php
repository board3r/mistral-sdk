<?php

namespace Board3r\MistralSdk\Helpers;


class NativeSessionHandler implements SessionHandlerInterface
{

    public function get(string $key): ?string
    {
        return $_SESSION[$key]??null;
    }

    public function write(string $key, string $value = null): void
    {
        $_SESSION[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function unset(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function id(): string
    {
        return session_id();
    }
}
