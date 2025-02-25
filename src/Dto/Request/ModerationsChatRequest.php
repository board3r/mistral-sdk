<?php

namespace Board3r\MistralSdk\Dto\Request;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\Objects\Message\MessageAssistant;
use Board3r\MistralSdk\Dto\Objects\Message\MessageCollection;
use Board3r\MistralSdk\Dto\Objects\Message\MessageSystem;
use Board3r\MistralSdk\Dto\Objects\Message\MessageTool;
use Board3r\MistralSdk\Dto\Objects\Message\MessageUser;
use Board3r\MistralSdk\Dto\Traits\withInputMessage;
use Board3r\MistralSdk\Dto\Traits\withModel;
use Board3r\MistralSdk\Enums\ModelEnum;

/**
 * @method self setInput(array|MessageCollection $input)
 * @method MessageAssistant[]|MessageUser[]|MessageTool[]|MessageSystem[]|MessageCollection|null getInput()
 */
class ModerationsChatRequest extends DataObject
{
    use withModel;
    use withInputMessage;

    protected array $_allowedModels = [ModelEnum::moderation->value];

    public MessageCollection $input;

}
