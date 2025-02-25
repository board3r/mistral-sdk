<?php

namespace Board3r\MistralSdk\Dto\Traits;

use Board3r\MistralSdk\Dto\Objects\Prediction;

/**
 * @method self setPrediction(array|Prediction $prediction)
 * @method Prediction|null getPrediction()
 */
trait withPrediction
{
    public Prediction|null $prediction;

}
