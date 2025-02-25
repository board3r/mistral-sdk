<?php

namespace Board3r\MistralSdk\Dto\Request;

use Board3r\MistralSdk\Dto\DataObject;
use Board3r\MistralSdk\Dto\Traits\withAgentId;
use Board3r\MistralSdk\Dto\Traits\withFunction;
use Board3r\MistralSdk\Dto\Traits\withMaxTokens;
use Board3r\MistralSdk\Dto\Traits\withMessage;
use Board3r\MistralSdk\Dto\Traits\withN;
use Board3r\MistralSdk\Dto\Traits\withPenalty;
use Board3r\MistralSdk\Dto\Traits\withPrediction;
use Board3r\MistralSdk\Dto\Traits\withRandomSeed;
use Board3r\MistralSdk\Dto\Traits\withResponseFormat;
use Board3r\MistralSdk\Dto\Traits\withStop;
use Board3r\MistralSdk\Dto\Traits\withStream;

class AgentsCompletionRequest extends DataObject
{
    use withMaxTokens;
    use withStream;
    use withStop;
    use withRandomSeed;
    use withMessage;
    use withResponseFormat;
    use withFunction;
    use withPenalty;
    use withN;
    use withPrediction;
    use withAgentId;

}
