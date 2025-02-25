<?php

namespace Board3r\MistralSdk\Dto\Request;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\Traits\withModel;
use Board3r\MistralSdk\Enums\ModelEnum;

/**
 * @method string|string[] getInput()
 * @method self setInput(string|string[] $input)
 */
class ModerationsRequest extends DataObject
{
    use withModel;

    public string|array $input;

    protected array $_allowedModels = [ModelEnum::moderation->value];
}
