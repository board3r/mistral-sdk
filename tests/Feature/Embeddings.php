<?php

use Board3r\MistralSdk\Dto\Error\RequestError;
use Board3r\MistralSdk\Dto\Request\EmbeddingsRequest;
use Board3r\MistralSdk\Dto\Response\EmbeddingsResponse;
use Board3r\MistralSdk\Enums\ModelEnum;
use Board3r\MistralSdk\Mistral;
use Board3r\MistralSdk\Requests\Embeddings\PostEmbeddings;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;


// think to setup phpunit.xml and set env
beforeEach(function () {
    $this->mistral = new Mistral();
});

test('Embeddings simple', closure: function (array $message) {
    MockClient::global([
        PostEmbeddings::class => MockResponse::fixture("embeddings.simple.".md5(implode($message))),
    ]);
    $request = new EmbeddingsRequest();
    $request->setModel(ModelEnum::embed->value);
    $request->setInput($message);
    $response = $this->mistral->embeddings()->post($request);

    /**
     * @var EmbeddingsResponse $object
     */
    $object = $response->dto();
    //dump($object->toArray());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($request->getInput())->toBe($message)
        ->and($request->getModel())->toBe(ModelEnum::embed->value)
        ->and($object)->toBeInstanceOf(EmbeddingsResponse::class)
        ->and($object->getObject())->toBe("list")
        ->and($object->getId())->toBeString()
        ->and($object->getData())->toHaveCount(count($message))
        ->and($object->getData()->get(0)->getIndex())->toBeInt()
        ->and($object->getData()->get(0)->getObject())->toBe("embedding")
        ->and($object->getData()->get(0)->getEmbedding())->toBeArray();

})->with('embeddings');

test('Request Error Chat Completion', closure: function (array $message) {
    MockClient::global([
        PostEmbeddings::class => MockResponse::fixture("embeddings.requestErrorEmbeddings"),
    ]);

    $request = new EmbeddingsRequest();
    $request->setModel(ModelEnum::embed->value);
    //$request->setInput($message);
    // forget to pass the prompt
    $response = $this->mistral->embeddings()->post($request);
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
})->with('embeddings');

test('encoding_format - parameter', closure: function (array $message) {
    MockClient::global([
        PostEmbeddings::class => MockResponse::fixture("embeddings.encodingFormat"),
    ]);

    $request = new EmbeddingsRequest();
    $request->setModel(ModelEnum::embed->value);
    $request->setInput($message);
    $request->setEncodingFormat("float");
    $response = $this->mistral->embeddings()->post($request);

    /**
     * @var EmbeddingsResponse $object
     */
    $object = $response->dto();
    //dump($object->getChoices()->get(0)->getMessage()->getContent());
    expect($response->status())->toBe(200)
        ->and($request->getEncodingFormat())->toBe("float")
        ->and($object->getData()->toArray())->toHaveCount(count($message));

})->with('embeddings');
