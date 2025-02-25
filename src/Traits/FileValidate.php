<?php

namespace Board3r\MistralSdk\Traits;

use Board3r\MistralSdk\Enums\RoleEnum;
use InvalidArgumentException;
use JsonException;
use Rs\JsonLines\Exception\File\NonReadable;
use Rs\JsonLines\JsonLines;
use stdClass;

trait FileValidate
{
    protected const ALLOWED_LINE_KEYS = ['messages', 'tools'];
    protected const ALLOWED_MESSAGE_KEYS = ['role', 'content', 'tool_calls', 'tool_call_id', 'name', 'prefix'];
    protected const MAX_FILE_SIZE = 524288000; // 500MB

    /**
     * Simple validation, check the good structure and level 1 and 2 keys
     *
     * @param  string  $filepath
     * @return bool
     * @throws JsonException
     * @throws NonReadable
     */
    public function validateFile(string $filepath): bool
    {
        if (!is_file($filepath)) {
            throw new InvalidArgumentException('File '.$filepath.' does not exist.');
        }
        // extension must be a jsonl
        if (pathinfo($filepath, PATHINFO_EXTENSION) !== 'jsonl') {
            throw new InvalidArgumentException('File extension must be jsonl');
        }
        if (filesize($filepath) > self::MAX_FILE_SIZE) {
            throw new InvalidArgumentException('File is too large. The limit is '.(int) (self::MAX_FILE_SIZE / (1024 * 1000)). ' MB');
        }
        $jsonLines = (new JsonLines())->delineEachLineFromFile($filepath);
        foreach ($jsonLines as $line => $jsonLine) {
            if (!($json = json_decode($jsonLine))) {
                throw new JsonException('Line '.$line.' : cannot parse JSON');
            }
            foreach ($json as $key => $value) {
                if (!in_array($key, self::ALLOWED_LINE_KEYS)) {
                    throw new JsonException('Line '.$line.' : Only "'.implode('", "', self::ALLOWED_LINE_KEYS).'" are allowed, "'.$key.'" is provided');
                }
            }
            // must contain message
            if (!isset($json->messages)) {
                throw new JsonException('Line '.$line.' :  File must contain "messages"');
            }
            $this->validateMessages($json, $line);
        }
        return true;
    }

    /**
     * Validate the messages within a JSON line
     *
     * @param  stdClass  $json
     * @param  int  $line
     * @throws JsonException
     */
    protected function validateMessages(stdClass $json, int $line): void
    {
        $assistantSet = false;
        foreach ($json->messages as $i => $message) {
            $messageKeys = array_keys(get_object_vars($message));
            foreach ($messageKeys as $key) {
                if (!in_array($key, self::ALLOWED_MESSAGE_KEYS)) {
                    throw new JsonException('Line '.$line.', Message '.$i.' : Only "'.implode('", "', self::ALLOWED_MESSAGE_KEYS).'" are allowed.');
                }
            }

            if (!isset($message->role)) {
                throw new JsonException('Line '.$line.', Message '.$i.' : Role missing');
            }

            if (!RoleEnum::tryFrom($message->role)) {
                throw new JsonException('Line '.$line.', Message '.$i.' : Role '.$message->role.' is not allowed.');
            }
            if ($message->role == RoleEnum::assistant->value) {
                $assistantSet = true;
            }

            if (!isset($message->tool_calls) && !isset($message->content)) {
                throw new JsonException('Line '.$line.', Message '.$i.' : "tool_calls" or "content" required.');
            }
        }
        if (!$assistantSet) {
            throw new JsonException('Line '.$line.' : Assistant must be used once in a message');
        }
    }
}
