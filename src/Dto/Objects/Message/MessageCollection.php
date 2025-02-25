<?php

namespace Board3r\MistralSdk\Dto\Objects\Message;

use BadFunctionCallException;
use Board3r\MistralSdk\Dto\Collection;
use Board3r\MistralSdk\Dto\FormatInterface;
use Board3r\MistralSdk\Enums\RoleEnum;

/**
 * @method MessageUser|MessageAssistant|MessageSystem|MessageTool offsetGet(int $key)
 * @method MessageUser|MessageAssistant|MessageSystem|MessageTool get(int $key)
 */
class MessageCollection extends Collection
{
    protected array|string $_dataTypes = [MessageUser::class,MessageAssistant::class,MessageSystem::class,MessageTool::class];

    /**
     * @param  array  $value
     * @return MessageUser|MessageAssistant|MessageSystem|MessageTool|FormatInterface
     * @throws BadFunctionCallException
     */
    protected function dataClassLogic(array $value): MessageUser|MessageAssistant|MessageSystem|MessageTool|FormatInterface
    {
        if (isset($value['role']) && RoleEnum::tryFrom($value['role'])) {
            switch ($value['role']) {
                case RoleEnum::user->value:
                    return new MessageUser($value);
                case RoleEnum::assistant->value:
                    return new MessageAssistant($value);
                case RoleEnum::tool->value:
                    return new MessageTool($value);
                case RoleEnum::system->value:
                    return new MessageSystem($value);
            }
        }
        return parent::dataClassLogic($value);
    }
}
