<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method string getName()
 * @method self setName(string $name)
 * @method string getDescription()
 * @method self setDescription(string $description)
 * @method bool|null getStrict()
 * @method self setStrict(bool|null $strict)
 * @method array getParameters()
 * @method self setParameters(array $parameters)
 */
class ToolFunction extends DataObject
{
    public string $name;
    public string $description;
    public bool|null $strict;
    public array $parameters;

}
