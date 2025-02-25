<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method string getType()
 * @method self setType(string $type)
 * @method string getContent()
 * @method self setContent(string $content)
 */
class Prediction extends DataObject
{
    public string $type = "content";
    public string $content;

}
