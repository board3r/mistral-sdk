<?php

namespace Board3r\MistralSdk\Dto\Objects\Message\Content;

/**
 * @method string getText()
 * @method self setText(string $text)
 * @method string getType()
 * @method self setType(string $type)
 */
class ContentText extends Content
{
    public string $text;
    public string $type = 'text';
}
