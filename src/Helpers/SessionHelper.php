<?php

namespace Board3r\MistralSdk\Helpers;

use Board3r\MistralSdk\Enums\RoleEnum;
use InvalidArgumentException;

class SessionHelper
{
    static protected bool $enabled;
    static protected int $history;

    protected const PREFIX_SESSION_KEY = 'mistral.messages.';
    protected const PREFIX_SESSION_KEY_SENT = 'mistral.messages.sent.';

    /**
     * Get messages stored in session
     * @param $type
     * @return array
     */
    static protected function getSession($type): array
    {
        $messages = $_SESSION[self::PREFIX_SESSION_KEY.$type] ?? null;
        return $messages ? json_decode($messages, true) : [];
    }

    /**
     * Set the messages in session
     * @param  string  $type
     * @param  array  $value
     * @return void
     */
    static protected function setSession(string $type, array $value): void
    {
        $_SESSION[self::PREFIX_SESSION_KEY.$type] = json_encode($value);
    }

    /**
     * Session state
     * @return bool
     */
    static public function isEnabled(): bool
    {
        if (!isset(self::$enabled)) {
            self::$enabled = getenv("MISTRAL_SESSION_ENABLED") ?: false;
        }
        return self::$enabled;
    }

    /**
     * Enable session for messages history
     * @return void
     */
    static public function enable(): void
    {
        self::$enabled = true;
    }

    /**
     * Disable session for messages history
     */
    static public function disable(): void
    {
        self::$enabled = false;
    }

    /**
     * Get the number of messages to keep in history
     * @return int
     */
    static public function getHistory(): int
    {
        if (!isset(self::$history)) {
            self::$history = getenv("MISTRAL_SESSION_HISTORY") ?: 10;
        }
        return self::$history;
    }

    /**
     * Define the number of messages to keep in history
     * @param  int  $history
     * @return void
     */
    static public function setHistory(int $history): void
    {
        self::$history = $history;
    }

    /**
     * Get a message history for a type
     * @param  string  $type
     * @return array|false
     */
    public static function getMessages(string $type): array|false
    {
        return self::getSession($type);
    }

    /**
     * Add an array of message in history for a type
     * @param  array  $messages
     * @param  string  $type
     * @return void
     */
    public static function addMessages(array $messages, string $type): void
    {
        foreach ($messages as $message) {
            self::addMessage($message, $type);
        }
    }

    /**
     * Add a message in history for a type
     * @param  array  $message
     * @param  string  $type
     * @throws InvalidArgumentException
     */
    public static function addMessage(array $message, string $type): void
    {
        if (!isset($message['role']) || !RoleEnum::tryFrom($message['role'])) {
            throw  new InvalidArgumentException('The role is not set correctly to save the message in session.');
        }
        if (($messages = self::getMessages($type)) !== false) {
            // check old messages
            $promptMessage = self::extractPromptMessage($messages);
            $messages = self::trimMessages($messages, $promptMessage);
            $messages = array_merge($promptMessage, $messages, self::getSentMessages($type) ,[$message]);
            self::setSession($type, $messages);
        }
    }

    /**
     * Extract the prompt message from the messages array
     * @param  array  $messages
     * @return array
     */
    protected static function extractPromptMessage(array &$messages): array
    {
        $promptMessage = [];
        if (isset($messages[0]['role']) && $messages[0]['role'] == RoleEnum::system->value) {
            $promptMessage = [$messages[0]];
            unset($messages[0]);
        }
        return $promptMessage;
    }

    /**
     * Trim the messages array to the specified history length
     * @param  array  $messages
     * @param  array  $promptMessage
     * @return array
     */
    protected static function trimMessages(array $messages, array $promptMessage): array
    {
        $history = 0;
        $messagesReverse = array_reverse($messages, true);
        foreach ($messagesReverse as $index => $messageReverse) {
            if (isset($messageReverse['role']) && $messageReverse['role'] == RoleEnum::user->value) {
                $history++;
                if ($history > self::getHistory()) {
                    $messages = array_slice($messages, $promptMessage ? $index + 1 : $index);
                    break;
                }
            }
        }
        return $messages;
    }

    /**
     * Reset all message in history for a type
     * @param  string  $type
     * @return void
     */
    public static function resetMessages(string $type): void
    {
        unset($_SESSION[self::PREFIX_SESSION_KEY.$type]);
    }

    /**
     * Define the last sent messages without history
     * @param  array  $messages
     * @param  string  $type
     * @return void
     */
    public static function addSentMessages(array $messages, string $type): void
    {
        $_SESSION[self::PREFIX_SESSION_KEY_SENT.$type] = json_encode($messages);
    }

    /**
     * Get the last sent messages without history
     * @param  string  $type
     * @return array
     */
    public static function getSentMessages(string $type): array
    {
        return isset($_SESSION[self::PREFIX_SESSION_KEY_SENT.$type]) ? json_decode($_SESSION[self::PREFIX_SESSION_KEY_SENT.$type]) : [];
    }

    /**
     * Reset the last sent messages without history
     * @param  string  $type
     * @return void
     */
    public static function resetSentMessages(string $type): void
    {
        unset($_SESSION[self::PREFIX_SESSION_KEY_SENT.$type]);
    }
}
