<?php

namespace Board3r\MistralSdk\Dto\Objects\Message;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method string getRole()
 * @method self setRole(string $role)
 */
class Message extends DataObject
{
    public string $role;
}
