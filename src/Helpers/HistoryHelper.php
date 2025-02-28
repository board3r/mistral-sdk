<?php

namespace Board3r\MistralSdk\Helpers;

use Board3r\MistralSdk\Enums\RoleEnum;
use InvalidArgumentException;

class HistoryHelper
{
    protected static SessionHandlerInterface $session;

    protected static bool $enabled;
    protected static int $history;

    protected const PREFIX_SESSION_KEY = 'mistral.messages.';
    protected const PREFIX_SESSION_KEY_SENT = 'mistral.messages.sent.';

    /**
     * Set session Handler, must be a interface of Board3r\MistralSdk\Helpers\SessionHandlerInterface
     * @param  string  $handler
     * @return bool
     */
    public static function setSessionHandler(string $handler): bool
    {
        if (in_array(SessionHandlerInterface::class, class_implements($handler))) {
            self::$session = new $handler;
            return true;
        }
        return false;
    }

    /**
     * Get the session object
     * @return SessionHandlerInterface
     */
    protected static function session(): SessionHandlerInterface
    {
        if (!isset(self::$session)) {
            self::setSessionHandler(NativeSessionHandler::class);
        }
        return self::$session;
    }

    /**
     * Get messages stored in session
     * @param  string  $type
     * @return array
     */
    public static function getMessagesHistory(string $type = 'chat'): array
    {
        $messages = self::session()->get(self::PREFIX_SESSION_KEY.$type);
        return $messages ? json_decode($messages, true) : [];
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
    public static function enable(): void
    {
        self::$enabled = true;
    }

    /**
     * Disable session for messages history
     */
    public static function disable(): void
    {
        self::$enabled = false;
    }

    /**
     * Get the number of messages to keep in history
     * @return int
     */
    public static function getParamHistory(): int
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
    public static function setParamHistory(int $history): void
    {
        self::$history = $history;
    }

    /**
     * Add an array of message in history for a type
     * @param  array  $messages
     * @param  string  $type
     * @return void
     */
    static public function addMessages(array $messages, string $type = 'chat'): void
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
    static public function addMessage(array $message, string $type = 'chat'): void
    {
        if (!isset($message['role']) || !RoleEnum::tryFrom($message['role'])) {
            throw  new InvalidArgumentException('The role is not set correctly to save the message in session.');
        }
        // check old messages
        $messages = self::getMessagesHistory($type);
        $promptMessage = self::extractPromptMessage($messages);
        $messages = self::trimMessages($messages, $promptMessage);
        $messages = array_merge($promptMessage, $messages, self::getSentMessages($type), [$message]);
        self::$session->write(self::PREFIX_SESSION_KEY.$type, json_encode($messages));
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
                if ($history > self::getParamHistory()) {
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
    public static function resetMessages(string $type = 'chat'): void
    {
        self::session()->unset(self::PREFIX_SESSION_KEY.$type);
    }

    /**
     * Define the last sent messages without history
     * @param  array  $messages
     * @param  string  $type
     * @return void
     */
    public static function addSentMessages(array $messages, string $type = 'chat'): void
    {
        self::session()->write(self::PREFIX_SESSION_KEY_SENT.$type, json_encode($messages));
    }

    /**
     * Get the last sent messages without history
     * @param  string  $type
     * @return array
     */
    public static function getSentMessages(string $type = 'chat'): array
    {
        if (self::session()->has(self::PREFIX_SESSION_KEY_SENT.$type)) {
            return json_decode(self::session()->get(self::PREFIX_SESSION_KEY_SENT.$type));
        }
        return [];
    }

    /**
     * Reset the last sent messages without history
     * @param  string  $type
     * @return void
     */
    public static function resetSentMessages(string $type = 'chat'): void
    {
        self::$session->unset(self::PREFIX_SESSION_KEY_SENT.$type);
    }
}
