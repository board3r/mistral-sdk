<?php

namespace Board3r\MistralSdk\Dto\Objects\Message\Content;

/**
 * @method string getImageUrl()
 * @method self setImageUrl(string $imageUrl)
 * @method string getType()
 * @method self setType(string $type)
 */
class ContentImage extends Content
{
    public string $imageUrl;
    public string $type = 'image_url';
}
