<?php

namespace Board3r\MistralSdk\Requests\Chat;

use Board3r\MistralSdk\Dto\Error\RequestError;
use Board3r\MistralSdk\Dto\Error\ValidationError;
use Board3r\MistralSdk\Dto\Request\ChatCompletionRequest;
use Board3r\MistralSdk\Dto\Response\ChatCompletionResponse;
use Board3r\MistralSdk\Traits\RequestFormatter;
use InvalidArgumentException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class PostChatCompletion extends Request implements HasBody
{
    use HasJsonBody;
    use RequestFormatter;

    protected Method $method = Method::POST;


    public function resolveEndpoint(): string
    {
        return "/chat/completions";
    }

    public function __construct(protected array|ChatCompletionRequest $request)
    {
        //
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    protected function defaultBody(): array
    {
        return $this->requestAsArray();
    }

    public function createDtoFromResponse(Response $response): ChatCompletionResponse|ValidationError|RequestError
    {
        if ($response->status() == 422) {
            return new ValidationError($response->array());
        } elseif ($response->status() == 200) {
            return new ChatCompletionResponse($response->array());
        } else {
            return new RequestError($response->array());
        }
    }
}
