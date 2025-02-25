<?php

namespace Board3r\MistralSdk\Requests\Files;

use Board3r\MistralSdk\Dto\Error\BasicError;
use Board3r\MistralSdk\Dto\Request\FileRequest;
use Board3r\MistralSdk\Dto\Response\FileResponse;
use Board3r\MistralSdk\Traits\RequestFormatter;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;


class GetFile extends Request
{
    use RequestFormatter;

    protected Method $method = Method::GET;
    protected array $_requiredFields = ['file_id'];

    public function resolveEndpoint(): string
    {
        $arr = $this->requestAsArray();
        return "/files/".$arr['file_id'];
    }

    public function __construct(protected array|FileRequest $request)
    {
    }

    public function createDtoFromResponse(Response $response): FileResponse|BasicError
    {
        if ($response->status() == 200) {
            return new FileResponse($response->array());
        } else {
            return new BasicError($response->array());
        }
    }
}
