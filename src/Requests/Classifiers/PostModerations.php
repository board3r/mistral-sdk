<?php

namespace Board3r\MistralSdk\Requests\Classifiers;

use Board3r\MistralSdk\Dto\Error\RequestError;
use Board3r\MistralSdk\Dto\Request\ModerationsRequest;
use Board3r\MistralSdk\Dto\Response\ModerationsResponse;
use Board3r\MistralSdk\Traits\RequestFormatter;
use InvalidArgumentException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class PostModerations extends Request implements HasBody
{
    use HasJsonBody;
    use RequestFormatter;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/moderations";
    }

    public function __construct(protected array|ModerationsRequest $request)
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

    public function createDtoFromResponse(Response $response): ModerationsResponse|RequestError
    {
        if ($response->status() == 200) {
            return new ModerationsResponse($response->array());
        } else {
            return new RequestError($response->array());
        }
    }
}
