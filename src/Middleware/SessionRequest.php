<?php

namespace Board3r\MistralSdk\Middleware;

use Board3r\MistralSdk\Helpers\HistoryHelper;
use Saloon\Contracts\RequestMiddleware;
use Saloon\Http\PendingRequest;

class SessionRequest implements RequestMiddleware
{

    protected string $sessionType;

    /**
     * @param  PendingRequest  $pendingRequest
     * @return void
     */
    public function __invoke(PendingRequest $pendingRequest): void
    {
        $body = $pendingRequest->body()->all();
        if (isset($body['messages']) && is_array($body['messages'])) {
            // memorize the current request message
            HistoryHelper::addSentMessages($body['messages'], $this->sessionType);
            // add history message in the request
            $body['messages'] = array_merge(HistoryHelper::getMessagesHistory($this->sessionType), $body['messages']);
            $pendingRequest->body()->set($body);
        }
    }
}
