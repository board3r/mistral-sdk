<?php

namespace Board3r\MistralSdk\Dto\Traits;

/**
 * @method self setRandomSeed(?int $randomSeed)
 * @method int|null getRandomSeed()
 */
trait withRandomSeed
{
    public int|null $randomSeed;
}
