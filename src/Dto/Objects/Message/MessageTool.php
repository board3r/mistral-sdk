<?php

namespace Board3r\MistralSdk\Dto\Objects\Message;

use Board3r\MistralSdk\Dto\Objects\Message\Content\Content;
use Board3r\MistralSdk\Dto\Objects\Message\Content\ContentCollection;
use Board3r\MistralSdk\Enums\RoleEnum;

/**
 * @method string|ContentCollection|Content[] getContent()
 * @method self setContent(array|string|ContentCollection|null $content)
 * @method string|null getToolCallId()
 * @method self setToolCallId(string|null $toolCallId)
 * @method string|null getName()
 * @method self setName(string|null $name)
 * @method string getRole()
 * @method self setRole(string $role)
 */
class MessageTool extends Message
{
    public string|ContentCollection|null $content;
    public string|null $toolCallId;
    public string|null $name;
    public string $role = RoleEnum::tool->value;
}
