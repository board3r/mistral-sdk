<?php

namespace Board3r\MistralSdk\Requests\Files;

use Board3r\MistralSdk\Dto\Error\BasicError;
use Board3r\MistralSdk\Dto\Request\FileRequest;
use Board3r\MistralSdk\Dto\Response\FileDeleteResponse;
use Board3r\MistralSdk\Traits\RequestFormatter;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;


class DeleteFile extends Request
{
    use RequestFormatter;

    protected Method $method = Method::DELETE;
    protected array $_requiredFields = ['file_id'];

    public function resolveEndpoint(): string
    {
        $arr = $this->requestAsArray();
        return "/files/".$arr['file_id'];
    }

    public function __construct(protected array|FileRequest $request)
    {
    }

    public function createDtoFromResponse(Response $response): FileDeleteResponse|BasicError
    {
        if ($response->status() == 200) {
            return new FileDeleteResponse($response->array());
        } else {
            return new BasicError($response->array());
        }
    }
}
