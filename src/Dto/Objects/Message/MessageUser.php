<?php

namespace Board3r\MistralSdk\Dto\Objects\Message;

use Board3r\MistralSdk\Dto\Objects\Message\Content\ContentCollection;
use Board3r\MistralSdk\Dto\Objects\Message\Content\ContentImage;
use Board3r\MistralSdk\Dto\Objects\Message\Content\ContentReference;
use Board3r\MistralSdk\Dto\Objects\Message\Content\ContentText;
use Board3r\MistralSdk\Enums\RoleEnum;

/**
 * @method string|ContentCollection|ContentText[]|ContentImage[]|ContentReference[]|null getContent()
 * @method self setContent(array|string|ContentCollection|null $content)
 * @method string getRole()
 * @method self setRole(string $role)
 */
class MessageUser extends Message
{
    public string|ContentCollection|null $content;
    public string $role = RoleEnum::user->value;
}
