<?php

namespace Board3r\MistralSdk\Resource;

use Board3r\MistralSdk\Dto\Request\FileRequest;
use Board3r\MistralSdk\Dto\Request\FileListRequest;
use Board3r\MistralSdk\Dto\Request\FileSignedUrlRequest;
use Board3r\MistralSdk\Dto\Request\FileUploadRequest;
use Board3r\MistralSdk\Mistral;
use Board3r\MistralSdk\Requests\Files\DeleteFile;
use Board3r\MistralSdk\Requests\Files\DownloadFile;
use Board3r\MistralSdk\Requests\Files\GetFile;
use Board3r\MistralSdk\Requests\Files\GetFileSignedUrl;
use Board3r\MistralSdk\Requests\Files\ListFile;
use Board3r\MistralSdk\Requests\Files\UploadFile;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @property Mistral $connector
 */
class Files extends BaseResource
{
    /**
     * @param  array|FileUploadRequest  $data
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function upload(array|FileUploadRequest $data): Response
    {
        return $this->connector->send(new UploadFile($data));
    }

    /**
     * @param  array|FileListRequest  $data
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function list(array|FileListRequest $data): Response
    {
        return $this->connector->send(new ListFile($data));
    }

    /**
     * @param  array|FileRequest  $data
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function get(array|FileRequest $data): Response
    {
        return $this->connector->send(new GetFile($data));
    }

    /**
     * @param  array|FileRequest  $data
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function delete(array|FileRequest $data): Response
    {
        return $this->connector->send(new DeleteFile($data));
    }

    /**
     * @param  array|FileSignedUrlRequest  $data
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function getSignedUrl(array|FileSignedUrlRequest $data): Response
    {
        return $this->connector->send(new GetFileSignedUrl($data));
    }


    /**
     * @param  array|FileSignedUrlRequest  $data
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function download(array|FileRequest $data): Response
    {
        return $this->connector->send(new DownloadFile($data));
    }
}
