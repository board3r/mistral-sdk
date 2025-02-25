<?php

namespace Board3r\MistralSdk\Enums;

enum SourceEnum: string
{
    case upload = 'upload';
    case repository = 'repository';
    case mistral = 'mistral';
}
