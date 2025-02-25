<?php

namespace Board3r\MistralSdk\Dto\Objects\Message;

use Board3r\MistralSdk\Dto\Objects\Message\Content\ContentText;
use Board3r\MistralSdk\Dto\Objects\Message\Content\ContentTextCollection;
use Board3r\MistralSdk\Enums\RoleEnum;

/**
 * @method string|ContentTextCollection|ContentText[] getContent()
 * @method self setContent(array|string|ContentTextCollection $content)
 * @method string getRole()
 * @method self setRole(string $role)
 */
class MessageSystem extends Message
{
    public string|ContentTextCollection $content;
    public string $role = RoleEnum::system->value;
}
