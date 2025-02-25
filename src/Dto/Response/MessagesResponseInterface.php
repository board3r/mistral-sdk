<?php
namespace Board3r\MistralSdk\Dto\Response;

use Board3r\MistralSdk\Dto\Objects\ChoiceCollection;

interface MessagesResponseInterface {
    public function getChoices() :ChoiceCollection|array;
}
