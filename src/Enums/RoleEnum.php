<?php

namespace Board3r\MistralSdk\Enums;

enum RoleEnum: string
{
    case system = 'system';
    case assistant = 'assistant';
    case user = 'user';
    case tool = 'tool';
}
