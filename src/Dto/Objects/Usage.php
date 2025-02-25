<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method int getPromptTokens()
 * @method self setPromptTokens(int $promptTokens)
 * @method int getCompletionTokens()
 * @method self setCompletionTokens(int $completionTokens)
 * @method int getTotalTokens()
 * @method self setTotalTokens(int $totalTokens)
 */
class Usage extends DataObject
{
    public int $promptTokens;
    public int $completionTokens;
    public int $totalTokens;
}
