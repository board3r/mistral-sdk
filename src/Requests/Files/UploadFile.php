<?php

namespace Board3r\MistralSdk\Requests\Files;

use Board3r\MistralSdk\Dto\Error\BasicError;
use Board3r\MistralSdk\Dto\Request\FileUploadRequest;
use Board3r\MistralSdk\Dto\Response\FileResponse;
use Board3r\MistralSdk\Traits\RequestFormatter;
use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasMultipartBody;


class UploadFile extends Request implements HasBody
{
    use HasMultipartBody;
    use RequestFormatter;

    protected Method $method = Method::POST;
    protected array $_requiredFields = ['file'];


    public function resolveEndpoint(): string
    {
        return "/files";
    }

    public function __construct(protected array|FileUploadRequest $request)
    {
    }

    protected function defaultBody(): array
    {
        $arr = $this->requestAsArray();
        $body =  [
            new MultipartValue(name: 'file', value: $arr['file'],filename:$arr['filename']??null,headers:['Content-Type'=> 'application/octet-stream'] )
        ];
        if (isset($arr['purpose'])){
            $body[] = new MultipartValue('purpose',$arr['purpose']);
        }
        return $body;
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
