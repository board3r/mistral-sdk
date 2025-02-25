<?php

namespace Board3r\MistralSdk\Dto\Traits;

use Board3r\MistralSdk\Enums\SampleTypeEnum;
use InvalidArgumentException;

/**
 * @method string|null getSampleType()
 */
trait withFileSampleType
{
    public string|null $sampleType;

    public function setSampleType(string|null $sampleType):self
    {
        if (SampleTypeEnum::tryFrom($sampleType) || is_null($sampleType)) {
            $this->sampleType = $sampleType;
        } else {
            throw new InvalidArgumentException($sampleType.' is not allowed');
        }
        return $this;
    }
}
