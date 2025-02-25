<?php

namespace Board3r\MistralSdk\Resource;

use Board3r\MistralSdk\Dto\Request\ModerationsChatRequest;
use Board3r\MistralSdk\Dto\Request\ModerationsRequest;
use Board3r\MistralSdk\Mistral;
use Board3r\MistralSdk\Requests\Classifiers\PostChatModerations;
use Board3r\MistralSdk\Requests\Classifiers\PostModerations;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @property Mistral $connector
 */
class Classifiers extends BaseResource
{
    /**
     * @param  array|ModerationsRequest  $data
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function postModeration(array|ModerationsRequest $data): Response
    {
        return $this->connector->send(new PostModerations($data));
    }

    /**
     * @param  array|ModerationsChatRequest  $data
     * @return Response
     * @throws FatalRequestException
     * @throws RequestException
     */
    public function postChatModeration(array|ModerationsChatRequest $data): Response
    {
        return $this->connector->send(new PostChatModerations($data));
    }
}
