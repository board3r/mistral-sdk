<?php

namespace Board3r\MistralSdk\Resource;

use Board3r\MistralSdk\Dto\Request\EmbeddingsRequest;
use Board3r\MistralSdk\Mistral;
use Board3r\MistralSdk\Requests\Embeddings\PostEmbeddings;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @property Mistral $connector
 */
class Embeddings extends BaseResource
{

    /**
     * @param  array|EmbeddingsRequest  $data
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function post(array|EmbeddingsRequest $data): Response
    {
        return $this->connector->send(new PostEmbeddings($data));
    }

}
