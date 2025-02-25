<?php

use Board3r\MistralSdk\Dto\Error\RequestError;
use Board3r\MistralSdk\Dto\Request\FimCompletionRequest;
use Board3r\MistralSdk\Dto\Response\FimCompletionResponse;
use Board3r\MistralSdk\Enums\FinishReasonEnum;
use Board3r\MistralSdk\Enums\ModelEnum;
use Board3r\MistralSdk\Enums\RoleEnum;
use Board3r\MistralSdk\Mistral;
use Board3r\MistralSdk\Requests\Fim\PostFimCompletion;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use function Board3r\MistralSdk\Helpers\CamelCase;

// think to setup phpunit.xml and set env
beforeEach(function () {
    $this->mistral = new Mistral(apiKey: getenv('CODESTRAL_API_KEY'),baseUrl: getenv('CODESTRAL_BASE_URL'));
});

test('Simple Chat Completion', closure: function (string $message) {
    MockClient::global([
        PostFimCompletion::class => MockResponse::fixture("fim.simpleFimCompletion.".md5($message)),
    ]);

    $request = new FimCompletionRequest();
    $request->setModel(ModelEnum::codestral->value);
    $request->setPrompt($message);
    $response = $this->mistral->fim()->post($request);

    /**
     * @var FimCompletionResponse $object
     */
    $object = $response->dto();
    dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($request->getPrompt())->toBe($message)
        ->and($request->getModel())->toBe(ModelEnum::codestral->value)
        ->and($object)->toBeInstanceOf(FimCompletionResponse::class)
        ->and($object->getObject())->toBe("chat.completion")
        ->and($object->getCreated())->toBeInstanceOf(DateTime::class)
        ->and($object->getChoices())->toHaveCount(1)
        ->and($object->getChoices()->get(0)->getIndex())->toBeInt()
        ->and($object->getChoices()->get(0)->getFinishReason())->toBe(FinishReasonEnum::stop->value)
        ->and($object->getChoices()->get(0)->getMessage()->getRole())->toBe(RoleEnum::assistant->value)
        ->and($object->getChoices()->get(0)->getMessage()->getContent())->toBeString();

})->with('simple fim');

test('Stream Chat Completion', closure: function (string $message) {
    MockClient::global([
        PostFimCompletion::class => MockResponse::fixture("fim.streamFimCompletion.".md5($message)),
    ]);

    $request = new FimCompletionRequest();
    $request->setModel(ModelEnum::codestral->value);
    $request->setPrompt($message);
    $response = $this->mistral->fim()->postStreamed($request);

    /**
     * @var FimCompletionResponse[] $chunks
     */
    $chunks = iterator_to_array($response);
    $randomChunk = rand(0,(count($chunks)-1));
    //dump($object->getChoices()->get($randomChunk)->getMessage()->getContent());
    expect($chunks)->not()->toBeEmpty()
        ->and($chunks[$randomChunk]->getModel())->toBe(ModelEnum::codestral->value)
        ->and($chunks[$randomChunk]->getObject())->toBe("chat.completion.chunk")
        ->and($chunks[0]->getChoices()->get(0)->getDelta()->getRole())->toBe('assistant')
        ->and($chunks)->toContainOnlyInstancesOf(FimCompletionResponse::class);
})->with('simple fim');

test('Request Error Chat Completion', closure: function (string $message) {
    MockClient::global([
        PostFimCompletion::class => MockResponse::fixture("fim.requestErrorFimCompletion"),
    ]);

    $request = new FimCompletionRequest();
    $request->setModel(ModelEnum::codestral->value);
    //$request->setPrompt($message);
    // forget to pass the prompt
    $response = $this->mistral->fim()->post($request);
    /**
     * @var RequestError $object
     */
    $object = $response->dto();
    //dump($object->getErrorMessage());
    expect($response->status())->toBe(422)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($object)->toBeInstanceOf(RequestError::class)
        ->and($object->getErrorMessage())->toBeString()
        ->and($object->getErrorMessage())->toBe('missing "body > prompt" : Field required');
})->with('simple fim');

test('temperature - parameter', closure: function (string $message, float $temperature) {
    MockClient::global([
        PostFimCompletion::class => MockResponse::fixture("fim.temperatureParameter.".$temperature),
    ]);

    $request = new FimCompletionRequest();
    $request->setModel(ModelEnum::codestral->value);
    $request->setPrompt($message);
    $request->setTemperature($temperature);
    $response = $this->mistral->fim()->post($request);

    /**
     * @var FimCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getTemperature())->toBe($temperature)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple fim', 'temperature parameter');

test('top_p - parameter', closure: function (string $message, float $topP) {
    MockClient::global([
        PostFimCompletion::class => MockResponse::fixture("fim.topPParameter.".$topP),
    ]);

    $request = new FimCompletionRequest();
    $request->setModel(ModelEnum::codestral->value);
    $request->setPrompt($message);
    $request->setTopP($topP);
    $response = $this->mistral->fim()->post($request);

    /**
     * @var FimCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getTopP())->toBe($topP)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple fim', 'top_p parameter');

test('max_tokens - parameter', closure: function (string $message, int $maxTokens) {
    MockClient::global([
        PostFimCompletion::class => MockResponse::fixture("fim.maxTokensParameter.".$maxTokens),
    ]);

    $request = new FimCompletionRequest();
    $request->setModel(ModelEnum::codestral->value);
    $request->setPrompt($message);
    $request->setMaxTokens($maxTokens);
    $response = $this->mistral->fim()->post($request);

    /**
     * @var FimCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getMaxTokens())->toBe($maxTokens)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple fim', 'max_tokens parameter');

test('min_tokens - parameter', closure: function (string $message, int $minTokens) {
    MockClient::global([
        PostFimCompletion::class => MockResponse::fixture("fim.minTokensParameter.".$minTokens),
    ]);

    $request = new FimCompletionRequest();
    $request->setModel(ModelEnum::codestral->value);
    $request->setPrompt($message);
    $request->setMinTokens($minTokens);
    $response = $this->mistral->fim()->post($request);

    /**
     * @var FimCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getMinTokens())->toBe($minTokens)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple fim', 'max_tokens parameter');

test('stop - parameter', closure: function (string $message, string|array $stop) {
    MockClient::global([
        PostFimCompletion::class => MockResponse::fixture("fim.stopParameter.".(is_array($stop) ? CamelCase(implode('_', $stop)) : $stop)),
    ]);

    $request = new FimCompletionRequest();
    $request->setModel(ModelEnum::codestral->value);
    $request->setPrompt($message);
    $request->setStop($stop);
    $response = $this->mistral->fim()->post($request);

    /**
     * @var FimCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getStop())->toBe($stop)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple fim', 'stop parameter fim');

test('random_seed - parameter', closure: function (string $message, int $randomSeed) {
    MockClient::global([
        PostFimCompletion::class => MockResponse::fixture("fim.randomSeedParameter.".$randomSeed),
    ]);

    $request = new FimCompletionRequest();
    $request->setModel(ModelEnum::codestral->value);
    $request->setPrompt($message);
    $request->setRandomSeed($randomSeed);
    $response = $this->mistral->fim()->post($request);

    /**
     * @var FimCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getRandomSeed())->toBe($randomSeed)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple fim', 'random_seed parameter');

test('suffix - parameter', closure: function (string $message, string $suffix) {
    MockClient::global([
        PostFimCompletion::class => MockResponse::fixture("fim.suffixParameter.".md5($suffix)),
    ]);

    $request = new FimCompletionRequest();
    $request->setModel(ModelEnum::codestral->value);
    $request->setPrompt($message);
    $request->setSuffix($suffix);
    $response = $this->mistral->fim()->post($request);

    /**
     * @var FimCompletionResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getSuffix())->toBe($suffix)
        ->and($object->getChoices())->toHaveCount(1);

})->with('simple fim', 'suffix parameter');
