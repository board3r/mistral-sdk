<?php

namespace Board3r\MistralSdk\Resource;

use Board3r\MistralSdk\Concerns\HandlesStreamedResponses;
use Board3r\MistralSdk\Dto\Request\AgentsCompletionRequest;
use Board3r\MistralSdk\Dto\Response\AgentsCompletionResponse;
use Board3r\MistralSdk\Helpers\HistoryHelper;
use Board3r\MistralSdk\Middleware\SessionAgentsRequest;
use Board3r\MistralSdk\Middleware\SessionAgentsResponse;
use Board3r\MistralSdk\Mistral;
use Board3r\MistralSdk\Requests\Agents\PostAgentsCompletion;
use Generator;
use JsonException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @property Mistral $connector
 */
class Agents extends BaseResource
{
    use HandlesStreamedResponses;

    /**
     * @param  array|AgentsCompletionRequest  $data
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function post(array|AgentsCompletionRequest $data): Response
    {
        if (is_array($data)) {
            $data['stream'] = false;
        } else {
            $data->setStream(false);
        }
        return $this->connector->send($this->getRequestWithMiddleware($data));
    }

    /**
     * @param  array|AgentsCompletionRequest  $data
     * @return Generator
     * @throws FatalRequestException
     * @throws JsonException
     * @throws RequestException
     */
    public function postStreamed(array|AgentsCompletionRequest $data): Generator
    {
        if (is_array($data)) {
            $data['stream'] = true;
        } else {
            $data->setStream(true);
        }
        $response = $this->connector->send($this->getRequestWithMiddleware($data));
        foreach ($this->getStreamIterator($response->stream()) as $chatResponse) {
            yield new AgentsCompletionResponse($chatResponse);
        }
    }

    protected function getRequestWithMiddleware(array|AgentsCompletionRequest $data): PostAgentsCompletion
    {
        $request = new PostAgentsCompletion($data);
        if (HistoryHelper::isEnabled()) {
            $request->middleware()->onRequest(new SessionAgentsRequest())->onResponse(new SessionAgentsResponse());
        }
        return $request;
    }
}
