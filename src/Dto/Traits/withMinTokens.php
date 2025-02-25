<?php

namespace Board3r\MistralSdk\Dto\Traits;

/**
 * @method int|null getMinTokens()
 */
trait withMinTokens
{
    public int|null $minTokens;

    public function setMinTokens(?int $minTokens): static
    {
        if ($minTokens !== null && $minTokens >= 0) {
            $this->minTokens = $minTokens;
        } else {
            $this->minTokens = null;
        }
        return $this;
    }
}
