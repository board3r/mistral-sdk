<?php

namespace Board3r\MistralSdk\Dto\Traits;

use InvalidArgumentException;

/**
 * @method float|null getPresencePenalty()
 * @method float|null getFrequencyPenalty()
 */
trait withPenalty
{
    public float|null $presencePenalty;

    public float|null $frequencyPenalty;

    /**
     * @param  float|null  $number
     * @return $this
     */
    public function setPresencePenalty(?float $number): static
    {
        if (is_float($number) && $number >= -2 && $number <= 2) {
            $this->presencePenalty = round($number, 1);
        } elseif (is_null($number)) {
            $this->presencePenalty = null;
        } else {
            throw new InvalidArgumentException($number.' is not allowed');
        }
        return $this;
    }

    /**
     * @param  float|null  $number
     * @return $this
     */
    public function setFrequencyPenalty(?float $number): static
    {
        if (is_float($number) && $number >= -2 && $number <= 2) {
            $this->frequencyPenalty = round($number, 1);
        } elseif (is_null($number)) {
            $this->frequencyPenalty = null;
        } else {
            throw new InvalidArgumentException($number.' is not allowed');
        }
        return $this;
    }
}
