<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\Objects\Message\ChoiceDelta;
use Board3r\MistralSdk\Dto\Objects\Message\ChoiceMessage;
use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method int getIndex()
 * @method ChoiceMessage|null getMessage()
 * @method ChoiceDelta|null getDelta()
 * @method string|null getFinishReason()
 */
class Choice extends DataObject
{
    public int $index;
    public ChoiceMessage|null $message;
    public ChoiceDelta|null $delta;
    public ?string $finishReason;

}
