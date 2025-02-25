<?php

namespace Board3r\MistralSdk\Dto\Request;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\Traits\withModel;
use Board3r\MistralSdk\Enums\ModelEnum;

/**
 * @method self setDryRun(bool|null $dryRun)
 * @method bool|null getDryRun()
 *
 */
class FineTuningCreateRequest extends DataObject
{
    use withModel;

    protected array $_allowedModels=[ModelEnum::mistral7b->value,ModelEnum::small->value,ModelEnum::codestral->value,ModelEnum::large->value,ModelEnum::nemo->value,ModelEnum::ministral3b->value];

    public bool|null $dryRun;




}
