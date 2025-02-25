<?php

use Board3r\MistralSdk\Dto\Objects\Message\Message;
use Board3r\MistralSdk\Dto\Objects\Message\MessageCollection;
use Board3r\MistralSdk\Dto\Objects\Message\MessageUser;
use Board3r\MistralSdk\Dto\Objects\Prediction;
use Board3r\MistralSdk\Dto\Objects\ResponseFormat;
use Board3r\MistralSdk\Dto\Request\ChatCompletionRequest;
use Board3r\MistralSdk\Enums\ResponseFormatEnum;
use Board3r\MistralSdk\Enums\RoleEnum;

test('Set data from array', function (array $entry) {
    $request = new ChatCompletionRequest($entry);
    $array = $request->toArray();
    $json = $request->toJson();

    expect($array)->toBeArray()
    ->and($json)->toBeJson()
    ->and((string)$request)->toBeJson();
})->with('chat completion request');

test('Getter with empty data', function () {
    $request = new ChatCompletionRequest();
    $array = $request->toArray();
    $modelAr = $request->getModel();
    $responseFormat = $request->getResponseFormat();
    $responseFormatType = $request->getResponseFormat()->getType();
    $prediction = $request->getPrediction();
    $predictionContent = $request->getPrediction()->getContent();
    $messages = $request->getMessages();
    $message = $request->getMessages()->get(0);
    expect($array)->toBeArray()
        ->and($modelAr)->toBeNull()
        ->and($responseFormat)->toBeInstanceOf(ResponseFormat::class)
        ->and($prediction)->toBeInstanceOf(Prediction::class)
        ->and($messages)->toBeInstanceOf(MessageCollection::class)
        ->and($responseFormatType)->toBeNull()
        ->and($predictionContent)->toBeNull()
        ->and($message)->toBeNull()
    ;
});

test('Setter with empty data', function () {
    $request = new ChatCompletionRequest();
    $request->getResponseFormat()->setType(ResponseFormatEnum::json->value);
    $responseFormat  = $request->getResponseFormat()->getType();
    $responseFormatAr = $request->toArray();
    $messageTest= ['content'=>'test','role'=> RoleEnum::user->value];
    $request->getMessages()->append($messageTest);
    $message = $request->getMessages()->get(0);
    $array = $request->toArray();

    expect($responseFormat)->toBe(ResponseFormatEnum::json->value)
    ->and($responseFormatAr)->toBe(['response_format'=>['type'=>ResponseFormatEnum::json->value]])
    ->and($request->getMessages())->toBeInstanceOf(MessageCollection::class)
    ->and($message)->toBeInstanceOf(Message::class)
    ->and($message)->toBeInstanceOf(MessageUser::class)
    ->and($array)->toBe(['messages'=>[$messageTest],'response_format'=>['type'=>ResponseFormatEnum::json->value]])
    ;

});
