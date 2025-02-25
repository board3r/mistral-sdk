<?php

namespace Board3r\MistralSdk;

use Board3r\MistralSdk\Resource\Agents;
use Board3r\MistralSdk\Resource\Chat;
use Board3r\MistralSdk\Resource\Classifiers;
use Board3r\MistralSdk\Resource\Embeddings;
use Board3r\MistralSdk\Resource\Files;
use Board3r\MistralSdk\Resource\Fim;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\HasTimeout;
use SensitiveParameter;

/**
 * Mistral AI API
 *
 * Our Chat Completion and Embeddings APIs specification.
 * Create your account on [La Plateforme](https://console.mistral.ai) to get access and read the [docs](https://docs.mistral.ai) to learn how to use it.
 */
class Mistral extends Connector
{
    use AcceptsJson;
    use HasTimeout;

    public function __construct(
        // Mistral API Key
        #[SensitiveParameter] protected ?string $apiKey = null,
        // Mistral API Base URL - default https://api.mistral.ai/v1
        protected ?string $baseUrl = null,
        // Timeout for the request - default 30
        protected ?int $requestTimeout = null,
        // Timeout for the connection - default 60
        protected ?int $connectTimeout = null
    ) {
        $this->apiKey = $apiKey ?? getenv('MISTRAL_API_KEY');
        $this->baseUrl = $baseUrl ?? getenv('MISTRAL_BASE_URL') ?: 'https://api.mistral.ai/v1';

        $this->connectTimeout =$this->connectTimeout ?? getenv('MISTRAL_CONNECT_TIMEOUT') ?: 30;
        $this->requestTimeout = $requestTimeout ?? getenv('MISTRAL_REQUEST_TIMEOUT') ?: 60;
    }

    /**
     * Identification by Header Token with the Mistral API Key
     * @return TokenAuthenticator
     */
    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->apiKey);
    }

    /**
     * Mistral base url for the Endpoint
     * @return string
     */
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @see https://docs.mistral.ai/api/#tag/chat
     * @return Chat
     */
    public function chat(): Chat
    {
        return new Chat($this);
    }

    /**
     * @see https://docs.mistral.ai/api/#tag/agents
     * @return Agents
     */
    public function agents(): Agents
    {
        return new Agents($this);
    }

    /**
     * @see https://docs.mistral.ai/api/#tag/fim
     * @return Fim
     */
    public function fim(): Fim
    {
        return new Fim($this);
    }

    /**
     * @see https://docs.mistral.ai/api/#tag/classifiers
     * @return Classifiers
     */
    public function classifiers(): Classifiers
    {
        return new Classifiers($this);
    }

    /**
     * @see https://docs.mistral.ai/api/#tag/embeddings
     * @return Embeddings
     */
    public function embeddings(): Embeddings
    {
        return new Embeddings($this);
    }

    /**
     * @see https://docs.mistral.ai/api/#tag/files
     * @return Files
     */
    public function files(): Files
    {
        return new Files($this);
    }
}
