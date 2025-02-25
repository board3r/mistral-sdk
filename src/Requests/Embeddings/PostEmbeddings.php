<?php

namespace Board3r\MistralSdk\Requests\Embeddings;

use Board3r\MistralSdk\Dto\Error\RequestError;
use Board3r\MistralSdk\Dto\Request\EmbeddingsRequest;
use Board3r\MistralSdk\Dto\Response\EmbeddingsResponse;
use Board3r\MistralSdk\Traits\RequestFormatter;
use InvalidArgumentException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;


class PostEmbeddings extends Request implements HasBody
{
    use HasJsonBody;
    use RequestFormatter;

    protected Method $method = Method::POST;


    public function resolveEndpoint(): string
    {
        return "/embeddings";
    }

    public function __construct(protected array|EmbeddingsRequest $request)
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

    public function createDtoFromResponse(Response $response): EmbeddingsResponse|RequestError
    {
        if ($response->status() == 200) {
            return new EmbeddingsResponse($response->array());
        } else {
            return new RequestError($response->array());
        }
    }
}
