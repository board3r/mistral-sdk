<?php

namespace Board3r\MistralSdk\Dto\Traits;

use InvalidArgumentException;

/**
 * @method int|null getN()
 */
trait withN
{
    public int|null $n;

    /**
     * @param  int|null  $number
     * @return $this
     */
    public function setN(?int $number): static
    {
        if (is_int($number) && $number >= 1) {
            $this->n = round($number, 1);
        } elseif (is_null($number)) {
            $this->n = null;
        } else {
            throw new InvalidArgumentException($number.' is not allowed');
        }
        return $this;
    }
}
