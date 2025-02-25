<?php

namespace Board3r\MistralSdk\Enums;

enum ContentTypeEnum: string
{
    case text = 'text';
    case image = 'image_url';
    case reference = 'reference';
}
