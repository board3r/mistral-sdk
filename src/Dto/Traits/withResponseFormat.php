<?php

namespace Board3r\MistralSdk\Dto\Traits;

use Board3r\MistralSdk\Dto\Objects\ResponseFormat;

/**
 * @method self setResponseFormat(ResponseFormat|array|null $responseFormat)
 * @method ResponseFormat|null getResponseFormat()
 * @method self setStream(bool|null $stream)
 * @method bool|null getStream()
 */
trait withResponseFormat
{
    public ResponseFormat|null $responseFormat;
}
