<?php

namespace Board3r\MistralSdk\Dto\Request;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\Traits\withModel;
use Board3r\MistralSdk\Enums\ModelEnum;

/**
 * @method string|string[] getInput()
 * @method string getEncodingFormat()
 * @method self setInput(string|string[] $input)
 * @method self setEncodingFormat(string|null $encodingFormat)
 */
class EmbeddingsRequest extends DataObject
{
    use withModel;

    public string|array $input;

    public string|null $encodingFormat;

    protected array $_allowedModels = [ModelEnum::embed->value];
}
