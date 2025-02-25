<?php

namespace Board3r\MistralSdk\Dto\Objects\Message;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method string getContent()
 * @method ToolCallCollection|ToolCall[]|null getToolCalls()
 * @method bool getPrefix()
 * @method string getRole()
 */
class ChoiceDelta extends DataObject
{
    public string $content;
    public ToolCallCollection|null $toolCalls;
    public bool|null $prefix;
    public string|null $role;
}
