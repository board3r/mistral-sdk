<?php

namespace Board3r\MistralSdk\Dto\Objects\Message\Content;

/**
 * @method array getReferenceIds()
 * @method self setReferenceIds(array $referenceIds)
 * @method string getType()
 * @method self setType(string $type)
 */
class ContentReference extends Content
{
    public array $referenceIds;
    public string $type = 'reference';
}
