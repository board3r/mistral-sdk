<?php

namespace Board3r\MistralSdk\Dto\Traits;

use InvalidArgumentException;

/**
 * @method float|null getTemperature()
 * @method float|null getTopP()
 */
trait withTemperature
{
    public float|null $temperature;

    public float|null $topP;

    /**
     * @param  float|null  $number
     * @return $this
     */
    public function setTemperature(?float $number): static
    {
        if (is_float($number) && $number >= 0 && $number <= 1.5) {
            $this->temperature = round($number, 1);
        } elseif (is_null($number)) {
            $this->temperature = null;
        } else {
            throw new InvalidArgumentException($number.' is not allowed');
        }
        return $this;
    }

    /**
     * @param  float|null  $number
     * @return $this
     */
    public function setTopP(?float $number): static
    {
        if (is_float($number) && $number >= 0 && $number <= 1) {
            $this->topP = round($number, 1);
        } elseif (is_null($number)) {
            $this->topP = null;
        } else {
            throw new InvalidArgumentException($number.' is not allowed');
        }
        return $this;
    }
}
