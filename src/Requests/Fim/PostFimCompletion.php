<?php

namespace Board3r\MistralSdk\Requests\Fim;

use Board3r\MistralSdk\Dto\Error\RequestError;
use Board3r\MistralSdk\Dto\Request\FimCompletionRequest;
use Board3r\MistralSdk\Dto\Response\FimCompletionResponse;
use Board3r\MistralSdk\Traits\RequestFormatter;
use InvalidArgumentException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class PostFimCompletion extends Request implements HasBody
{
    use HasJsonBody;
    use RequestFormatter;

    protected Method $method = Method::POST;


    public function resolveEndpoint(): string
    {
        return "/fim/completions";
    }

    public function __construct(protected array|FimCompletionRequest $request)
    {
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    protected function defaultBody(): array
    {
        return $this->requestAsArray();
    }

    public function createDtoFromResponse(Response $response): FimCompletionResponse|RequestError
    {
        if ($response->status() == 200) {
            return new FimCompletionResponse($response->array());
        } else {
            return new RequestError($response->array());
        }
    }
}
