<?php

use Board3r\MistralSdk\Dto\Error\RequestError;
use Board3r\MistralSdk\Dto\Request\AgentsCompletionRequest;
use Board3r\MistralSdk\Dto\Response\AgentsCompletionResponse;
use Board3r\MistralSdk\Enums\FinishReasonEnum;
use Board3r\MistralSdk\Enums\RoleEnum;
use Board3r\MistralSdk\Mistral;
use Board3r\MistralSdk\Requests\Agents\PostAgentsCompletion;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use function Board3r\MistralSdk\Helpers\CamelCase;

// think to setup phpunit.xml and set env
beforeEach(function () {
    $this->mistral = new Mistral();
});

test('Simple Chat Completion', closure: function (string $message) {
    MockClient::global([
        PostAgentsCompletion::class => MockResponse::fixture("agents.simpleChatCompletion.".md5($message)),
    ]);

    $request = new AgentsCompletionRequest();
    $request->setAgentId(getenv('MISTRAL_AGENT_ID'));
    $request->addUserMessage($message);
    $response = $this->mistral->agents()->post($request);

    /**
     * @var AgentsCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($request->getMessages()->get(0)->getContent())->toBe($message)
        ->and($request->getMessages()->get(0)->getRole())->toBe(RoleEnum::user->value)
        ->and($request->getAgentId())->toBe(getenv('MISTRAL_AGENT_ID'))
        ->and($object)->toBeInstanceOf(AgentsCompletionResponse::class)
        ->and($object->getObject())->toBe("chat.completion")
        ->and($object->getCreated())->toBeInstanceOf(DateTime::class)
        ->and($object->getChoices())->toHaveCount(1)
        ->and($object->getChoices()->get(0)->getIndex())->toBeInt()
        ->and($object->getChoices()->get(0)->getFinishReason())->toBe(FinishReasonEnum::stop->value)
        ->and($object->getChoices()->get(0)->getMessage()->getRole())->toBe(RoleEnum::assistant->value)
        ->and($object->getChoices()->get(0)->getMessage()->getContent())->toBeString();

})->with('simple chat');

test('Stream Chat Completion', closure: function (string $message) {
    MockClient::global([
        PostAgentsCompletion::class => MockResponse::fixture("agents.streamChatCompletion.".md5($message)),
    ]);

    $request = new AgentsCompletionRequest();
    $request->setAgentId(getenv('MISTRAL_AGENT_ID'));
    $request->addUserMessage($message);
    $response = $this->mistral->agents()->postStreamed($request);

    /**
     * @var AgentsCompletionResponse[] $chunks
     */
    $chunks = iterator_to_array($response);
    $randomChunk = rand(0,(count($chunks)-1));
    //dump($object->getChoices()->get($randomChunk)->getMessage()->getContent());
    expect($chunks)->not()->toBeEmpty()
        ->and($chunks[$randomChunk]->getObject())->toBe("chat.completion.chunk")
        ->and($chunks[0]->getChoices()->get(0)->getDelta()->getRole())->toBe('assistant')
        ->and($chunks)->toContainOnlyInstancesOf(AgentsCompletionResponse::class);
})->with('simple chat');

test('Discussion Chat Completion', closure: function (array $discussion) {
    MockClient::global([
        PostAgentsCompletion::class => MockResponse::fixture("agents.discussionChatCompletion.".md5(json_encode($discussion))),
    ]);

    $request = new AgentsCompletionRequest();
    $request->setAgentId(getenv('MISTRAL_AGENT_ID'));
    foreach ($discussion as $message) {
        switch ($message['role']) {
            case RoleEnum::user->value:
                $request->addUserMessage($message['content']);
                break;
            case RoleEnum::assistant->value:
                $request->addAssistantMessage($message['content']);
                break;
            case RoleEnum::system->value:
                $request->addSystemMessage($message['content']);
                break;
        }
    }

    $response = $this->mistral->agents()->post($request);
    /**
     * @var AgentsCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($request->getMessages())->toHaveCount(count($discussion))
        ->and($request->getAgentId())->toBe(getenv('MISTRAL_AGENT_ID'))
        ->and($object)->toBeInstanceOf(AgentsCompletionResponse::class)
        ->and($object->getObject())->toBe("chat.completion")
        ->and($object->getCreated())->toBeInstanceOf(DateTime::class)
        ->and($object->getChoices())->toHaveCount(1)
        ->and($object->getChoices()->get(0)->getIndex())->toBeInt()
        ->and($object->getChoices()->get(0)->getFinishReason())->toBe(FinishReasonEnum::stop->value)
        ->and($object->getChoices()->get(0)->getMessage()->getRole())->toBe(RoleEnum::assistant->value)
        ->and($object->getChoices()->get(0)->getMessage()->getContent())->toBeString();
})->with('discussion chat');

test('Functions Chat Completion', closure: function (string $message) {
    MockClient::global([
        PostAgentsCompletion::class => MockResponse::fixture("agents.functionsChatCompletion.".md5($message)),
    ]);

    $request = new AgentsCompletionRequest();
    $request->setAgentId(getenv('MISTRAL_AGENT_ID'));
    $request->addUserMessage($message);
    $request->addFunction([MistralFunction::class, 'getElectionResult']);

    $response = $this->mistral->agents()->post($request);
    /**
     * @var AgentsCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->toArray());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($object->getChoices()->get(0)->getFinishReason())->toBe(FinishReasonEnum::tool_calls->value)
        ->and($object->getChoices()->get(0)->getMessage()->getRole())->toBe(RoleEnum::assistant->value)
        ->and($object->getChoices()->get(0)->getMessage()->getContent())->toBeEmpty()
        ->and($object->getChoices()->get(0)->getMessage()->getToolCalls()->get(0)->getType())->toBe('function')
        ->and($object->getChoices()->get(0)->getMessage()->getToolCalls()->get(0)->getFunction()->getName())->toBe('electionResult')
        ->and($object->getChoices()->get(0)->getMessage()->getToolCalls()->get(0)->getFunction()->getArguments())->toHaveCount(2);

})->with('function chat');

test('Request Error Chat Completion', closure: function (string $message) {
    MockClient::global([
        PostAgentsCompletion::class => MockResponse::fixture("agents.requestErrorChatCompletion"),
    ]);

    $request = new AgentsCompletionRequest();
    $request->setAgentId(getenv('MISTRAL_AGENT_ID'));
    $request->addUserMessage($message);
    $request->getPrediction()->setContent("not available with this model");
    // forget to pass message
    $response = $this->mistral->agents()->post($request);
    /**
     * @var RequestError $object
     */
    $object = $response->dto();
    //dump($object->getErrorMessage());
    expect($response->status())->toBe(400)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($object)->toBeInstanceOf(RequestError::class)
        ->and($object->getErrorMessage())->toBeString()
        ->and($object->getErrorMessage())->toBe('Prediction support is not enabled for this model');
})->with('simple chat');

test('max_tokens - parameter', closure: function (string $message, int $maxTokens) {
    MockClient::global([
        PostAgentsCompletion::class => MockResponse::fixture("agents.maxTokensParameter.".$maxTokens),
    ]);

    $request = new AgentsCompletionRequest();
    $request->setAgentId(getenv('MISTRAL_AGENT_ID'));
    $request->addUserMessage($message);
    $request->setMaxTokens($maxTokens);
    $response = $this->mistral->agents()->post($request);

    /**
     * @var AgentsCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getMaxTokens())->toBe($maxTokens)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat', 'max_tokens parameter');

test('stop - parameter', closure: function (string $message, string|array $stop) {
    MockClient::global([
        PostAgentsCompletion::class => MockResponse::fixture("agents.stopParameter.".(is_array($stop) ? CamelCase(implode('_', $stop)) : $stop)),
    ]);

    $request = new AgentsCompletionRequest();
    $request->setAgentId(getenv('MISTRAL_AGENT_ID'));
    $request->addUserMessage($message);
    $request->setStop($stop);
    $response = $this->mistral->agents()->post($request);

    /**
     * @var AgentsCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getStop())->toBe($stop)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat', 'stop parameter');

test('random_seed - parameter', closure: function (string $message, int $randomSeed) {
    MockClient::global([
        PostAgentsCompletion::class => MockResponse::fixture("agents.randomSeedParameter.".$randomSeed),
    ]);

    $request = new AgentsCompletionRequest();
    $request->setAgentId(getenv('MISTRAL_AGENT_ID'));
    $request->addUserMessage($message);
    $request->setRandomSeed($randomSeed);
    $response = $this->mistral->agents()->post($request);

    /**
     * @var AgentsCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getRandomSeed())->toBe($randomSeed)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat', 'random_seed parameter');

test('response_format - parameter', closure: function (string $message, string $responseFormat) {
    MockClient::global([
        PostAgentsCompletion::class => MockResponse::fixture("agents.responseFormatParameter.".$responseFormat),
    ]);

    $request = new AgentsCompletionRequest();
    $request->setAgentId(getenv('MISTRAL_AGENT_ID'));
    $request->addUserMessage($message);
    $request->getResponseFormat()->setType($responseFormat);
    $response = $this->mistral->agents()->post($request);

    /**
     * @var AgentsCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getResponseFormat()->getType())->toBe($responseFormat)
        ->and($object->getChoices())->toHaveCount(1)
        ->and($object->getChoices()->get(0)->getMessage()->getContent())->toBeJson();

})->with('simple chat json', 'response_format parameter');

test('presence_penalty - parameter', closure: function (string $message, float $presencePenalty) {
    MockClient::global([
        PostAgentsCompletion::class => MockResponse::fixture("agents.presencePenaltyParameter.".$presencePenalty),
    ]);

    $request = new AgentsCompletionRequest();
    $request->setAgentId(getenv('MISTRAL_AGENT_ID'));
    $request->addUserMessage($message);
    $request->setPresencePenalty($presencePenalty);
    $response = $this->mistral->agents()->post($request);

    /**
     * @var AgentsCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getPresencePenalty())->toBe($presencePenalty)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat', 'presence_penalty parameter');

test('frequency_penalty - parameter', closure: function (string $message, float $frequencyPenalty) {
    MockClient::global([
        PostAgentsCompletion::class => MockResponse::fixture("agents.frequencyPenaltyParameter.".$frequencyPenalty),
    ]);

    $request = new AgentsCompletionRequest();
    $request->setAgentId(getenv('MISTRAL_AGENT_ID'));
    $request->addUserMessage($message);
    $request->setFrequencyPenalty($frequencyPenalty);
    $response = $this->mistral->agents()->post($request);

    /**
     * @var AgentsCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getFrequencyPenalty())->toBe($frequencyPenalty)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat', 'frequency_penalty parameter');

test('n - parameter', closure: function (string $message, int $n) {
    MockClient::global([
        PostAgentsCompletion::class => MockResponse::fixture("agents.NParameter.".$n),
    ]);

    $request = new AgentsCompletionRequest();
    $request->setAgentId(getenv('MISTRAL_AGENT_ID'));
    $request->addUserMessage($message);
    $request->setN($n);
    $response = $this->mistral->agents()->post($request);

    /**
     * @var AgentsCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->toArray());
    expect($response->status())->toBe(200)
        ->and($request->getN())->toBe($n)
        ->and($object->getChoices())->toHaveCount($n);

})->with('simple chat', 'n parameter');
