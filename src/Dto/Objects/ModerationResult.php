<?php

namespace Board3r\MistralSdk\Dto\Objects;

use Board3r\MistralSdk\Dto\DataObject;
use stdClass;

/**
 * @method array getCategories()
 * @method array getCategoryScores()
 */
class ModerationResult extends DataObject
{
    public array $categories;
    public array $categoryScores;
}
