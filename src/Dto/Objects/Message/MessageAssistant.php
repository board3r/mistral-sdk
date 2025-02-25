<?php

namespace Board3r\MistralSdk\Dto\Objects\Message;

use Board3r\MistralSdk\Dto\Objects\Message\Content\ContentCollection;
use Board3r\MistralSdk\Dto\Objects\Message\Content\ContentImage;
use Board3r\MistralSdk\Dto\Objects\Message\Content\ContentReference;
use Board3r\MistralSdk\Dto\Objects\Message\Content\ContentText;
use Board3r\MistralSdk\Enums\RoleEnum;

/**
 * @method string|ContentCollection|ContentText[]|ContentImage[]|ContentReference[]|null getContent()
 * @method self setContent(array|string|ContentCollection|null $content)
 * @method ToolCallCollection|ToolCall[]|null getToolCalls()
 * @method self setToolCalls(array|ToolCallCollection|null $toolCalls)
 * @method bool getPrefix()
 * @method self setPrefix(bool $prefix)
 * @method string getRole()
 * @method self setRole(string $role)
 */
class MessageAssistant extends Message
{
    public string|ContentCollection|null $content;
    public ToolCallCollection|null $toolCalls;
    public bool $prefix;
    public string $role = RoleEnum::assistant->value;
}
