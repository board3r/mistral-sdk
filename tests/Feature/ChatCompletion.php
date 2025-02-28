<?php

use Board3r\MistralSdk\Dto\Error\RequestError;
use Board3r\MistralSdk\Dto\Error\ValidationError;
use Board3r\MistralSdk\Dto\Request\ChatCompletionRequest;
use Board3r\MistralSdk\Dto\Response\ChatCompletionResponse;
use Board3r\MistralSdk\Enums\FinishReasonEnum;
use Board3r\MistralSdk\Enums\ModelEnum;
use Board3r\MistralSdk\Enums\RoleEnum;
use Board3r\MistralSdk\Helpers\HistoryHelper;
use Board3r\MistralSdk\Mistral;
use Board3r\MistralSdk\Requests\Chat\PostChatCompletion;

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use function Board3r\MistralSdk\Helpers\CamelCase;

// think to setup phpunit.xml and set env
beforeEach(function () {
    $this->mistral = new Mistral();
});

test('Simple Chat Completion', closure: function (string $message) {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.simpleChatCompletion.".md5($message)),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $response = $this->mistral->chat()->post($request);

    /**
     * @var ChatCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($request->getMessages()->get(0)->getContent())->toBe($message)
        ->and($request->getMessages()->get(0)->getRole())->toBe(RoleEnum::user->value)
        ->and($request->getModel())->toBe(ModelEnum::small->value)
        ->and($object)->toBeInstanceOf(ChatCompletionResponse::class)
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
        PostChatCompletion::class => MockResponse::fixture("chat.streamChatCompletion.".md5($message)),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $response = $this->mistral->chat()->postStreamed($request);

    /**
     * @var ChatCompletionResponse[] $chunks
     */
    $chunks = iterator_to_array($response);
    $randomChunk = rand(0,(count($chunks)-1));
    //dump($object->getChoices()->get($randomChunk)->getMessage()->getContent());
    expect($chunks)->not()->toBeEmpty()
        ->and($chunks[$randomChunk]->getModel())->toBe(ModelEnum::small->value)
        ->and($chunks[$randomChunk]->getObject())->toBe("chat.completion.chunk")
        ->and($chunks[0]->getChoices()->get(0)->getDelta()->getRole())->toBe('assistant')
        ->and($chunks)->toContainOnlyInstancesOf(ChatCompletionResponse::class);
})->with('simple chat');

test('Discussion Chat Completion', closure: function (array $discussion) {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.discussionChatCompletion.".md5(json_encode($discussion))),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
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

    $response = $this->mistral->chat()->post($request);
    /**
     * @var ChatCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($request->getMessages())->toHaveCount(count($discussion))
        ->and($request->getModel())->toBe(ModelEnum::small->value)
        ->and($object)->toBeInstanceOf(ChatCompletionResponse::class)
        ->and($object->getModel())->toBe(ModelEnum::small->value)
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
        PostChatCompletion::class => MockResponse::fixture("chat.functionsChatCompletion.".md5($message)),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $request->addFunction([MistralFunction::class, 'getElectionResult']);

    $response = $this->mistral->chat()->post($request);
    /**
     * @var ChatCompletionResponse $object
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

test('Validation Error Chat Completion', closure: function () {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.validationErrorChatCompletion"),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    // forget to pass message
    $response = $this->mistral->chat()->post($request);
    /**
     * @var ValidationError $object
     */
    $object = $response->dto();
    //dump($object->getErrorMessage());
    expect($response->status())->toBe(422)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($object)->toBeInstanceOf(ValidationError::class)
        ->and($object->getErrorMessage())->toBeString()
        ->and($object->getErrorMessage())->toBe('missing "body > messages" : Field required');
});

test('Request Error Chat Completion', closure: function (string $message) {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.requestErrorChatCompletion"),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $request->getPrediction()->setContent("not available with this model");
    // forget to pass message
    $response = $this->mistral->chat()->post($request);
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


test('Session History Chat Completion', closure: function (string $message) {
    HistoryHelper::enable();
    HistoryHelper::resetMessages('chat');
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.session.step1".md5($message)),
    ]);
    // send first message
    $request1 = new ChatCompletionRequest();
    $request1->setModel(ModelEnum::small->value);
    $request1->addUserMessage($message);
    $response1 = $this->mistral->chat()->post($request1);
    $sessionMessage1 = HistoryHelper::getMessagesHistory('chat');

    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.SessionHistory.step2".md5($message)),
    ]);
    // send second message
    $request2 = new ChatCompletionRequest();
    $request2->setModel(ModelEnum::small->value);
    $request2->addUserMessage($message);
    $response2 = $this->mistral->chat()->post($request2);
    $sessionMessage2 = HistoryHelper::getMessagesHistory('chat');

    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response1->status())->toBe(200)
        ->and($response2->status())->toBe(200)
        ->and($sessionMessage1)->toHaveCount(2)
        ->and($sessionMessage2)->toHaveCount(4)
        ->and(HistoryHelper::getSentMessages('chat'))->toBeEmpty()
    ;
    HistoryHelper::disable();
})->with('simple chat');


test('temperature - parameter', closure: function (string $message, float $temperature) {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.temperatureParameter.".$temperature),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $request->setTemperature($temperature);
    $response = $this->mistral->chat()->post($request);

    /**
     * @var ChatCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getTemperature())->toBe($temperature)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat', 'temperature parameter');

test('top_p - parameter', closure: function (string $message, float $topP) {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.topPParameter.".$topP),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $request->setTopP($topP);
    $response = $this->mistral->chat()->post($request);

    /**
     * @var ChatCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getTopP())->toBe($topP)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat', 'top_p parameter');

test('max_tokens - parameter', closure: function (string $message, int $maxTokens) {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.maxTokensParameter.".$maxTokens),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $request->setMaxTokens($maxTokens);
    $response = $this->mistral->chat()->post($request);

    /**
     * @var ChatCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getMaxTokens())->toBe($maxTokens)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat', 'max_tokens parameter');

test('stop - parameter', closure: function (string $message, string|array $stop) {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.stopParameter.".(is_array($stop) ? CamelCase(implode('_', $stop)) : $stop)),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $request->setStop($stop);
    $response = $this->mistral->chat()->post($request);

    /**
     * @var ChatCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getStop())->toBe($stop)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat', 'stop parameter');

test('random_seed - parameter', closure: function (string $message, int $randomSeed) {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.randomSeedParameter.".$randomSeed),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $request->setRandomSeed($randomSeed);
    $response = $this->mistral->chat()->post($request);

    /**
     * @var ChatCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getRandomSeed())->toBe($randomSeed)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat', 'random_seed parameter');

test('response_format - parameter', closure: function (string $message, string $responseFormat) {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.responseFormatParameter.".$responseFormat),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $request->getResponseFormat()->setType($responseFormat);
    $response = $this->mistral->chat()->post($request);

    /**
     * @var ChatCompletionResponse $object
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
        PostChatCompletion::class => MockResponse::fixture("chat.presencePenaltyParameter.".$presencePenalty),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $request->setPresencePenalty($presencePenalty);
    $response = $this->mistral->chat()->post($request);

    /**
     * @var ChatCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getPresencePenalty())->toBe($presencePenalty)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat', 'presence_penalty parameter');

test('frequency_penalty - parameter', closure: function (string $message, float $frequencyPenalty) {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.frequencyPenaltyParameter.".$frequencyPenalty),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $request->setFrequencyPenalty($frequencyPenalty);
    $response = $this->mistral->chat()->post($request);

    /**
     * @var ChatCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getFrequencyPenalty())->toBe($frequencyPenalty)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat', 'frequency_penalty parameter');

test('n - parameter', closure: function (string $message, int $n) {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.NParameter.".$n),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $request->setN($n);
    $response = $this->mistral->chat()->post($request);

    /**
     * @var ChatCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->toArray());
    expect($response->status())->toBe(200)
        ->and($request->getN())->toBe($n)
        ->and($object->getChoices())->toHaveCount($n);

})->with('simple chat', 'n parameter');

test('prediction - parameter', closure: function (string $message, string $prediction) {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.predictionParameter.".md5($prediction)),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::large->value);
    $request->addUserMessage($message);
    $request->getPrediction()->setContent($prediction);
    $response = $this->mistral->chat()->post($request);

    /**
     * @var ChatCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getPrediction()->getContent())->toBe($prediction)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat', 'prediction parameter');

test('safe_prompt - parameter', closure: function (string $message, bool $safePrompt) {
    MockClient::global([
        PostChatCompletion::class => MockResponse::fixture("chat.safePromptParameter.".$safePrompt),
    ]);

    $request = new ChatCompletionRequest();
    $request->setModel(ModelEnum::small->value);
    $request->addUserMessage($message);
    $request->setSafePrompt($safePrompt);
    $response = $this->mistral->chat()->post($request);

    /**
     * @var ChatCompletionResponse $object
     */
    $object = $response->dto();

    expect($response->status())->toBe(200)
        ->and($request->getSafePrompt())->toBe($safePrompt)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple chat not safe', 'safe_prompt parameter');
