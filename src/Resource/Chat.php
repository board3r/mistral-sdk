<?php

namespace Board3r\MistralSdk\Resource;

use Board3r\MistralSdk\Concerns\HandlesStreamedResponses;
use Board3r\MistralSdk\Dto\Request\ChatCompletionRequest;
use Board3r\MistralSdk\Dto\Response\ChatCompletionResponse;
use Board3r\MistralSdk\Helpers\HistoryHelper;
use Board3r\MistralSdk\Middleware\SessionChatRequest;
use Board3r\MistralSdk\Middleware\SessionChatResponse;
use Board3r\MistralSdk\Mistral;
use Board3r\MistralSdk\Requests\Chat\PostChatCompletion;
use Generator;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @property Mistral $connector
 */
class Chat extends BaseResource
{
    use HandlesStreamedResponses;

    /**
     * @param  array|ChatCompletionRequest  $data
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function post(array|ChatCompletionRequest $data): Response
    {
        if (is_array($data)){
            $data['stream'] = false;
        }else{
            $data->setStream(false);
        }
        return  $this->connector->send($this->getRequestWithMiddleware($data));
    }

    /**
     * @param  array|ChatCompletionRequest  $data
     * @return Generator
     * @throws FatalRequestException
     * @throws JsonException
     * @throws RequestException
     */
    public function postStreamed(array|ChatCompletionRequest $data): Generator
    {
        if (is_array($data)){
            $data['stream'] = true;
        }else{
            $data->setStream(true);
        }
        $response =  $this->connector->send($this->getRequestWithMiddleware($data));
        foreach ($this->getStreamIterator($response->stream()) as $chatResponse) {
            yield new ChatCompletionResponse($chatResponse);
        }
    }

    protected function getRequestWithMiddleware(array|ChatCompletionRequest $data): PostChatCompletion
    {
        $request = new PostChatCompletion($data);
        if (HistoryHelper::isEnabled()){
            $request->middleware()->onRequest(new SessionChatRequest())->onResponse(new SessionChatResponse());
        }
        return $request;
    }

}
