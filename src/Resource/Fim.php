<?php

namespace Board3r\MistralSdk\Resource;

use Board3r\MistralSdk\Concerns\HandlesStreamedResponses;
use Board3r\MistralSdk\Dto\Request\FimCompletionRequest;
use Board3r\MistralSdk\Dto\Response\FimCompletionResponse;
use Board3r\MistralSdk\Mistral;
use Board3r\MistralSdk\Requests\Fim\PostFimCompletion;
use Generator;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @property Mistral $connector
 */
class Fim extends BaseResource
{
    use HandlesStreamedResponses;

    /**
     * @param  array|FimCompletionRequest  $data
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function post(array|FimCompletionRequest $data): Response
    {
        if (is_array($data)){
            $data['stream'] = false;
        }else{
            $data->setStream(false);
        }
        return $this->connector->send(new PostFimCompletion($data));
    }

    /**
     * @param  array|FimCompletionRequest  $data
     * @return Generator
     * @throws FatalRequestException
     * @throws JsonException
     * @throws RequestException
     */
    public function postStreamed(array|FimCompletionRequest $data): Generator
    {
        if (is_array($data)){
            $data['stream'] = true;
        }else{
            $data->setStream(true);
        }
        $response =  $this->connector->send(new PostFimCompletion($data));
        foreach ($this->getStreamIterator($response->stream()) as $chatResponse) {
            yield new FimCompletionResponse($chatResponse);
        }
    }

}
