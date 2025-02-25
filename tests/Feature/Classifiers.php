<?php

use Board3r\MistralSdk\Dto\Error\RequestError;
use Board3r\MistralSdk\Dto\Objects\Message\MessageCollection;
use Board3r\MistralSdk\Dto\Request\ModerationsChatRequest;
use Board3r\MistralSdk\Dto\Request\ModerationsRequest;
use Board3r\MistralSdk\Dto\Response\ModerationsResponse;
use Board3r\MistralSdk\Enums\ClassificationEnum;
use Board3r\MistralSdk\Enums\ModelEnum;
use Board3r\MistralSdk\Mistral;
use Board3r\MistralSdk\Requests\Classifiers\PostChatModerations;
use Board3r\MistralSdk\Requests\Classifiers\PostModerations;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;


// think to setup phpunit.xml and set env
beforeEach(function () {
    $this->mistral = new Mistral();
});

test('Moderation simple', closure: function (string $message) {
    MockClient::global([
        PostModerations::class => MockResponse::fixture("classifiers.moderation.simple.".md5($message)),
    ]);
    $request = new ModerationsRequest();
    $request->setModel(ModelEnum::moderation->value);
    $request->setInput($message);
    $response = $this->mistral->classifiers()->postModeration($request);

    /**
     * @var ModerationsResponse $object
     */
    $object = $response->dto();
    //dump($object->toArray());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($request->getInput())->toBe($message)
        ->and($request->getModel())->toBe(ModelEnum::moderation->value)
        ->and($object)->toBeInstanceOf(ModerationsResponse::class)
        ->and($object->getId())->toBeString()
        ->and($object->getScore(ClassificationEnum::pii->value))->toBeFloat()
        ->and($object->getModeration(ClassificationEnum::pii->value))->toBeBool()
        ->and($object->getResults()->get(0)->getCategories())->toBeArray()
        ->and($object->getResults()->get(0)->getCategoryScores())->toBeArray()
        ->and($object->getResults()->get(0)->getCategoryScores())->toHaveCount(count(ClassificationEnum::cases()));

})->with('moderation message');

test('Moderation chat simple', closure: function (string $message) {
    MockClient::global([
        PostChatModerations::class => MockResponse::fixture("classifiers.chatmoderation.simple.".md5($message)),
    ]);
    $request = new ModerationsChatRequest();
    $request->setModel(ModelEnum::moderation->value);
    $request->addUserMessage($message);
    $response = $this->mistral->classifiers()->postChatModeration($request);

    /**
     * @var ModerationsResponse $object
     */
    $object = $response->dto();
    //dump($object->toArray());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($request->getInput())->toBeInstanceOf(MessageCollection::class)
        ->and($request->getModel())->toBe(ModelEnum::moderation->value)
        ->and($object)->toBeInstanceOf(ModerationsResponse::class)
        ->and($object->getId())->toBeString()
        ->and($object->getScore(ClassificationEnum::pii->value))->toBeFloat()
        ->and($object->getModeration(ClassificationEnum::pii->value))->toBeBool()
        ->and($object->getResults()->get(0)->getCategories())->toBeArray()
        ->and($object->getResults()->get(0)->getCategoryScores())->toBeArray()
        ->and($object->getResults()->get(0)->getCategoryScores())->toHaveCount(count(ClassificationEnum::cases()));

})->with('moderation message');

test('Request Error Chat Completion', closure: function () {
    MockClient::global([
        PostModerations::class => MockResponse::fixture("classifiers.moderation.requestError"),
    ]);

    $request = new ModerationsRequest();
    $request->setModel(ModelEnum::moderation->value);
    //$request->setInput($message);
    $response = $this->mistral->classifiers()->postModeration($request);
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
        ->and($object->getErrorMessage())->toBe('missing "body > input" : Field required');
});
