<?php

namespace Board3r\MistralSdk\Dto\Request;


/**
 * @method self setExpiry(int|null $search)
 * @method int|null getExpiry()
 */
class FileSignedUrlRequest extends FileRequest
{
    public int|null $expiry;
}
