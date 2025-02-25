<?php

namespace Board3r\MistralSdk\Enums;

enum SampleTypeEnum: string
{
    case pretrain = 'pretrain';
    case instruct = 'instruct';
    case batchRequest = 'batch_request';
    case batchResult = 'batch_result';
    case batchError = 'batch_error';
}
