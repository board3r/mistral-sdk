<?php

namespace Board3r\MistralSdk\Middleware;

use Board3r\MistralSdk\Helpers\HistoryHelper;
use Saloon\Contracts\ResponseMiddleware;
use Saloon\Http\Response;

class SessionResponse implements ResponseMiddleware
{
    protected string $sessionType;

    public function __invoke(Response $response): void
    {
        if ($response->status() === 200) {
            $body = json_decode($response->body(), true);
            if (isset($body['choices']) && is_array($body['choices'])) {
                $messages = [];
                foreach ($body['choices'] as $choice) {
                    if (isset($choice['message']) && is_array($choice['message'])) {
                        $messages[] = $choice['message'];
                    }
                }
                // keep the response in memory, add also sent messages
                HistoryHelper::addMessages($messages, $this->sessionType);
                // reset sent messages
                HistoryHelper::resetSentMessages($this->sessionType);
            }
        }
    }
}
