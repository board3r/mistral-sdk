<?php

namespace Board3r\MistralSdk\Dto\Objects\Message\Content;

use BadFunctionCallException;
use Board3r\MistralSdk\Dto\Collection;
use Board3r\MistralSdk\Dto\FormatInterface;
use Board3r\MistralSdk\Enums\ContentTypeEnum;

/**
 * @method ContentText|ContentImage|ContentReference offsetGet(int $key)
 * @method ContentText|ContentImage|ContentReference get(int $key)
 */
class ContentCollection extends Collection
{
    public array|string $_dataTypes  = [ContentText::class,ContentImage::class,ContentReference::class];

    /**
     * @param  array  $value
     * @return ContentText|ContentImage|ContentReference|FormatInterface
     * @throws BadFunctionCallException
 */
    protected function dataClassLogic(array $value): ContentText|ContentImage|ContentReference|FormatInterface
    {
        if (isset($value['type']) && ContentTypeEnum::tryFrom($value['type'])) {
            switch ($value['type']) {
                case ContentTypeEnum::text->value:
                    return new ContentText($value);
                case ContentTypeEnum::image->value:
                    return new ContentImage($value);
                case ContentTypeEnum::reference->value:
                    return new ContentReference($value);
            }
        }
        return parent::dataClassLogic($value);
    }
}
