<?php

namespace Board3r\MistralSdk\Dto\Traits;

/**
 * @method int|null getMaxTokens()
 */
trait withMaxTokens
{
    public int|null $maxTokens;

    public function setMaxTokens(?int $maxTokens): static
    {
        if ($maxTokens !== null && $maxTokens >= 0) {
            $this->maxTokens = $maxTokens;
        } else {
            $this->maxTokens = null;
        }
        return $this;
    }
}
