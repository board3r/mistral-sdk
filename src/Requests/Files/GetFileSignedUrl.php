<?php

namespace Board3r\MistralSdk\Requests\Files;

use Board3r\MistralSdk\Dto\Error\BasicError;
use Board3r\MistralSdk\Dto\Request\FileSignedUrlRequest;
use Board3r\MistralSdk\Dto\Response\FileSignedUrlResponse;
use Board3r\MistralSdk\Traits\RequestFormatter;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;


class GetFileSignedUrl extends Request
{
    use RequestFormatter;

    protected Method $method = Method::GET;
    protected array $_requiredFields = ['file_id'];

    public function resolveEndpoint(): string
    {
        $arr = $this->requestAsArray();
        return "/files/".$arr['file_id'].'/url';
    }

    public function __construct(protected array|FileSignedUrlRequest $request)
    {
    }

    protected function defaultQuery(): array
    {
        $arr = $this->requestAsArray();
        $return = [];
        if (isset($arr['expiry'])) {
            $return['expiry'] = $arr['expiry'];
        }
        return $return;
    }

    public function createDtoFromResponse(Response $response): FileSignedUrlResponse|BasicError
    {
        if ($response->status() == 200) {
            return new FileSignedUrlResponse($response->array());
        } else {
            return new BasicError($response->array());
        }
    }
}
