<?php

namespace Board3r\MistralSdk\Enums;

enum FinishReasonEnum: string
{
    case stop = 'stop';
    case length = 'length';
    case model_length = 'model_length';
    case error = 'error';
    case tool_calls = 'tool_calls';
}
