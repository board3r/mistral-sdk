<?php

namespace Board3r\MistralSdk\Requests\Agents;

use Board3r\MistralSdk\Dto\Error\RequestError;
use Board3r\MistralSdk\Dto\Error\ValidationError;
use Board3r\MistralSdk\Dto\Request\AgentsCompletionRequest;
use Board3r\MistralSdk\Dto\Response\AgentsCompletionResponse;
use Board3r\MistralSdk\Traits\RequestFormatter;
use InvalidArgumentException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;


class PostAgentsCompletion extends Request implements HasBody
{
    use HasJsonBody;
    use RequestFormatter;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/agents/completions";
    }

    public function __construct(protected array|AgentsCompletionRequest $request)
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

    public function createDtoFromResponse(Response $response): AgentsCompletionResponse|ValidationError|RequestError
    {
        if ($response->status() == 422) {
            return new ValidationError($response->array());
        } elseif ($response->status() == 200) {
            return new AgentsCompletionResponse($response->array());
        } else {
            return new RequestError($response->array());
        }
    }

}
