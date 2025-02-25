<?php

namespace Board3r\MistralSdk\Dto\Traits;

use Board3r\MistralSdk\Dto\Objects\Choice;
use Board3r\MistralSdk\Dto\Objects\ChoiceCollection;

/**
 * @method Choice[]|ChoiceCollection getChoices()
 */
trait withChoices
{
    public ChoiceCollection $choices;

}
