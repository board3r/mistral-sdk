<?php

namespace Board3r\MistralSdk\Requests\Files;

use Board3r\MistralSdk\Dto\Request\FileRequest;
use Board3r\MistralSdk\Traits\RequestFormatter;
use Saloon\Enums\Method;
use Saloon\Http\Request;


class DownloadFile extends Request
{
    use RequestFormatter;

    protected Method $method = Method::GET;
    protected array $_requiredFields = ['file_id'];

    public function resolveEndpoint(): string
    {
        $arr = $this->requestAsArray();
        return "/files/".$arr['file_id'].'/content';
    }

    public function __construct(protected array|FileRequest $request)
    {
    }
}
