<?php

namespace Board3r\MistralSdk\Dto\Traits;

use Board3r\MistralSdk\Dto\Objects\Message\MessageAssistant;
use Board3r\MistralSdk\Dto\Objects\Message\MessageCollection;
use Board3r\MistralSdk\Dto\Objects\Message\MessageSystem;
use Board3r\MistralSdk\Dto\Objects\Message\MessageTool;
use Board3r\MistralSdk\Dto\Objects\Message\MessageUser;

/**
 * @method self setInput(array|MessageCollection $messages)
 * @method MessageAssistant[]|MessageUser[]|MessageTool[]|MessageSystem[]|MessageCollection|null getInput()
 */
trait withInputMessage
{
    use withMessageBase;

    public MessageCollection $input;

    protected string $_messageFieldName = 'input';
}
