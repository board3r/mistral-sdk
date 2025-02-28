<?php

namespace Board3r\MistralSdk\Dto\Traits;

use Board3r\MistralSdk\Dto\Objects\Message\MessageAssistant;
use Board3r\MistralSdk\Dto\Objects\Message\MessageCollection;
use Board3r\MistralSdk\Dto\Objects\Message\MessageSystem;
use Board3r\MistralSdk\Dto\Objects\Message\MessageTool;
use Board3r\MistralSdk\Dto\Objects\Message\MessageUser;
use Board3r\MistralSdk\Dto\Objects\Message\ToolCallCollection;
use Board3r\MistralSdk\Enums\ContentTypeEnum;
use Board3r\MistralSdk\Enums\RoleEnum;
use InvalidArgumentException;

/**
 * @property string $_messageFieldName;
 */
trait withMessageBase
{
    /**
     * @param  string|array  $message
     * @param  string|null  $type
     * @return MessageCollection|false
     * @thows InvalidArgumentException
     */
    public function addUserMessage(string|array $message, ?string $type = null): MessageCollection|false
    {
        $content = $this->formatContentMessage($message, $type);
        if ($content) {
            $message = ['content' => $content, 'role' => RoleEnum::user->value];
            if (isset($this->{$this->_messageFieldName})) {
                $this->{$this->_messageFieldName}->append($message);
            } else {
                $this->{'set'.$this->_messageFieldName}([$message]);
            }
            return $this->{'get'.$this->_messageFieldName}();
        }
        return false;
    }

    /**
     * @param  string|array  $message
     * @param  string|null  $type  > ContentTypeEnum
     * @param  array|ToolCallCollection|null  $toolCall
     * @param  bool|null  $prefix
     * @return MessageCollection|false
     * @thows InvalidArgumentException
     */
    public function addAssistantMessage(string|array $message, ?string $type = null, ToolCallCollection|array|null $toolCall = null, ?bool $prefix = null): MessageCollection|false
    {
        $content = $this->formatContentMessage($message, $type);
        if ($content) {
            $message = ['content' => $content, 'role' => RoleEnum::assistant->value];
            if ($toolCall) {
                if (is_array($toolCall)) {
                    $toolCall = new ToolCallCollection($toolCall);
                }
                $message['tool_calls'] = $toolCall->toArray();
            }
            if (isset($prefix)) {
                $message['prefix'] = $prefix;
            }
            if (isset($this->{$this->_messageFieldName})) {
                $this->{$this->_messageFieldName}->append($message);
            } else {
                $this->{'set'.$this->_messageFieldName}([$message]);
            }
            return $this->{'get'.$this->_messageFieldName}();
        }
        return false;
    }

    /**
     * @param  string|array  $message
     * @return MessageCollection|false
     * @thows InvalidArgumentException
     */
    public function addSystemMessage(string|array $message): MessageCollection|false
    {
        $content = $this->formatContentMessage($message);
        if ($content) {
            $message = ['content' => $content, 'role' => RoleEnum::system->value];
            if (isset($this->{$this->_messageFieldName})) {
                $this->{$this->_messageFieldName}->append($message);
            } else {
                $this->{'set'.$this->_messageFieldName}([$message]);
            }
        }
        return false;
    }

    /**
     * @param  string|array  $message
     * @param  string|null  $type  > ContentTypeEnum
     * @param  string|null  $name
     * @param  string|null  $toolCallID
     * @return MessageCollection|false
     * @thows InvalidArgumentException
     */
    public function addToolMessage(string|array $message, ?string $type = null, ?string $name = null, ?string $toolCallID = null): MessageCollection|false
    {
        $content = $this->formatContentMessage($message, $type);
        if ($content) {
            $message = ['content' => $content, 'role' => RoleEnum::tool->value];
            if (isset($name)) {
                $message['name'] = $name;
            }
            if (isset($toolCallID)) {
                $message['tool_call_id'] = $toolCallID;
            }
            if (isset($this->{$this->_messageFieldName})) {
                $this->{$this->_messageFieldName}->append($message);
            } else {
                $this->{'set'.$this->_messageFieldName}([$message]);
            }
            return $this->{'get'.$this->_messageFieldName}();
        }
        return false;
    }

    /**
     * @param  string|array  $message
     * @param  string|null  $type
     * @return array|string
     */
    protected function formatContentMessage(string|array $message, ?string $type = null): array|string
    {
        if (isset($type)) {
            $content = [];
            switch ($type) {
                case ContentTypeEnum::text->value:
                case ContentTypeEnum::image->value:
                    if (is_array($message)) {
                        foreach ($message as $msg) {
                            $content[] = [$type => $msg, 'type' => $type];
                        }
                    } else {
                        $content[] = [$type => $message, 'type' => $type];
                    }
                    break;
                case ContentTypeEnum::reference->value:
                    if (is_array($message)) {
                        $content[] = ['reference_ids' => $message, 'type' => ContentTypeEnum::reference->value];
                    } else {
                        throw new InvalidArgumentException($message.' must be an array for reference');
                    }
                    break;
                default:
                    throw new InvalidArgumentException('Content type "'.$type.'" is unknown');
            }
        } else {
            $content = $message;
        }
        return $content;
    }
}
