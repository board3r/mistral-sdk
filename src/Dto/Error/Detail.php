<?php

namespace Board3r\MistralSdk\Dto\Error;

use Board3r\MistralSdk\Dto\DataObject;

/**
 * @method array getLoc()
 * @method self setLoc(array $loc)
 * @method string getMsg()
 * @method self setMsg(string $msg)
 * @method string getType()
 * @method self setType(string $type)
 */
class Detail extends DataObject
{
    /**
     * @var int[]|string[]
     */
    public array $loc;

    public string $msg;

    public string $type;

}
