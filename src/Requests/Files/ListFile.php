<?php

namespace Board3r\MistralSdk\Requests\Files;

use Board3r\MistralSdk\Dto\Error\BasicError;
use Board3r\MistralSdk\Dto\Error\RequestError;
use Board3r\MistralSdk\Dto\Request\FileListRequest;
use Board3r\MistralSdk\Dto\Response\FileListResponse;
use Board3r\MistralSdk\Traits\RequestFormatter;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;


class ListFile extends Request
{
    use RequestFormatter;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/files";
    }

    public function __construct(protected array|FileListRequest $request)
    {
    }

    protected function defaultQuery(): array
    {
        return $this->requestAsArray();
    }

    public function createDtoFromResponse(Response $response): FileListResponse|BasicError
    {
        if ($response->status() == 200) {
            return new FileListResponse($response->array());
        } else {
            return new BasicError($response->array());
        }
    }
}
