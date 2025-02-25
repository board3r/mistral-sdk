<?php

namespace Board3r\MistralSdk\Dto\Objects\Message;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method string getName()
 * @method self setName(string $name)
 * @method array getArguments()
 */
class ToolCallFunction extends DataObject
{
    public string $name;
    public array $arguments;

    public function setArguments(array|string $arguments): static
    {
        if (is_string($arguments)) {
            $this->arguments = json_decode($arguments, true);
        } else {
            $this->arguments = $arguments;
        }
        return $this;
    }

}
