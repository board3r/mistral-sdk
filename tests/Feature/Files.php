<?php

use Board3r\MistralSdk\Dto\Error\BasicError;
use Board3r\MistralSdk\Dto\Request\FileRequest;
use Board3r\MistralSdk\Dto\Request\FileListRequest;
use Board3r\MistralSdk\Dto\Request\FileSignedUrlRequest;
use Board3r\MistralSdk\Dto\Request\FileUploadRequest;
use Board3r\MistralSdk\Dto\Response\FileDeleteResponse;
use Board3r\MistralSdk\Dto\Response\FileListResponse;
use Board3r\MistralSdk\Dto\Response\FileResponse;
use Board3r\MistralSdk\Dto\Response\FileSignedUrlResponse;
use Board3r\MistralSdk\Enums\PurposeEnum;
use Board3r\MistralSdk\Enums\SampleTypeEnum;
use Board3r\MistralSdk\Enums\SourceEnum;
use Board3r\MistralSdk\Mistral;
use Board3r\MistralSdk\Requests\Files\DeleteFile;
use Board3r\MistralSdk\Requests\Files\DownloadFile;
use Board3r\MistralSdk\Requests\Files\GetFile;
use Board3r\MistralSdk\Requests\Files\GetFileSignedUrl;
use Board3r\MistralSdk\Requests\Files\ListFile;
use Board3r\MistralSdk\Requests\Files\UploadFile;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

// think to setup phpunit.xml and set env
beforeEach(function () {
    $this->mistral = new Mistral();
});

test('Upload file', closure: function () {
    MockClient::global([
        UploadFile::class => MockResponse::fixture("files.upload"),
    ]);
    $filepath = __DIR__.'/../Fixtures/Files/toulouse.jsonl';
    $filename = "toulouse_".date("YmdHis").'.jsonl';
    $request = new FileUploadRequest();
    $request->setFile($filepath);
    $request->setFilename($filename);
    $response = $this->mistral->files()->upload($request);
    /**
     * @var FileResponse $object
     */
    $object = $response->dto();
    //dump($object->toArray());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($request->getFile())->toBeResource()
        ->and($request->getFilename())->toBe($filename)
        ->and($object)->toBeInstanceOf(FileResponse::class)
        ->and($object->getId())->toBeString()
        ->and($object->getObject())->toBe("file")
        ->and($object->getPurpose())->toBe(PurposeEnum::fineTune->value)
        ->and($object->getSampleType())->toBe(SampleTypeEnum::instruct->value)
        ->and($object->getSource())->toBe(SourceEnum::upload->value)
        ->and($object->getBytes())->toBeInt()
        ->and($object->getFilename())->toContain( "toulouse_")
    ;
});

test('Request Error Upload file', closure: function () {
    MockClient::global([
        UploadFile::class => MockResponse::fixture("files.upload.error"),
    ]);

    $filepath = __DIR__.'/../Fixtures/Files/toulouse_error.jsonl';
    $filename = "toulouse_error".date("YmdHis").'.jsonl';
    $request = new FileUploadRequest();
    // no validate the file before to send it
    $request->setFile($filepath,false);
    $request->setFilename($filename);
    $response = $this->mistral->files()->upload($request);
    /**
     * @var BasicError $object
     */
    $object = $response->dto();
    //dump($object->getErrorMessage());
    expect($response->status())->toBe(422)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($object)->toBeInstanceOf(BasicError::class)
        ->and($object->getErrorMessage())->toBeString();
});

test('List files', closure: function () {
    MockClient::global([
        ListFile::class => MockResponse::fixture("files.list"),
    ]);
    $request = new FileListRequest();
    $request->setPage(0);
    $request->setPageSize(5);
    $request->setSource(SourceEnum::upload->value);
    $request->setPurpose(PurposeEnum::fineTune->value);
    $request->setSampleType(SampleTypeEnum::instruct->value);
    $request->setSearch("toulouse");

    $response = $this->mistral->files()->list($request);
    /**
     * @var FileListResponse $object
     */
    $object = $response->dto();
    //dump($object->toArray());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($request->getPage())->toBe(0)
        ->and($request->getPageSize())->toBe(5)
        ->and($request->getSource())->toBe(SourceEnum::upload->value)
        ->and($request->getPurpose())->toBe(PurposeEnum::fineTune->value)
        ->and($request->getSampleType())->toBe(SampleTypeEnum::instruct->value)
        ->and($object)->toBeInstanceOf(FileListResponse::class)
        ->and($object->getTotal())->toBeInt()
        ->and($object->getObject())->toBe("list")
        ->and($object->getData()->get(0))->toBeInstanceOf(\Board3r\MistralSdk\Dto\Objects\File::class)
        ->and($object->getData()->get(0)->getFilename())->toBeString()
    ;
});

test('Get File', closure: function () {
    MockClient::global([
        GetFile::class => MockResponse::fixture("files.get"),
    ]);
    $request = new FileRequest();

    $request->setFileId(getenv('FILE_ID'));

    $response = $this->mistral->files()->get($request);
    /**
     * @var FileResponse $object
     */
    $object = $response->dto();
    //dump($object->toArray());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($request->getFileId())->toBe(getenv('FILE_ID'))
        ->and($object)->toBeInstanceOf(FileResponse::class)
        ->and($object->getId())->toBeString()
        ->and($object->getObject())->toBe("file")
        ->and($object->getBytes())->toBeInt()
    ;
});

test('Download File', closure: function () {
    MockClient::global([
        DownloadFile::class => MockResponse::fixture("files.get.download"),
    ]);
    $filepath = __DIR__.'/../Fixtures/Files/toulouse_download.jsonl';
    $request = new FileRequest();
    $request->setFileId(getenv('FILE_ID'));
    $response = $this->mistral->files()->download($request);

    $response->saveBodyToFile($filepath);

    expect($response->status())->toBe(200)
        ->and($filepath)->toBeFile()
        ->and($request->getFileId())->toBe(getenv('FILE_ID'));

    unlink($filepath);
});

test('Get Signed Url File', closure: function () {
    MockClient::global([
        GetFileSignedUrl::class => MockResponse::fixture("files.get.signedUrl"),
    ]);
    $request = new FileSignedUrlRequest();
    $request->setFileId(getenv('FILE_ID'));
    $request->setExpiry(48);
    $response = $this->mistral->files()->getSignedUrl($request);
    /**
     * @var FileSignedUrlResponse $object
     */
    $object = $response->dto();
    //dump($object->toArray());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($request->getFileId())->toBe(getenv('FILE_ID'))
        ->and($request->getExpiry())->toBe(48)
        ->and($object)->toBeInstanceOf(FileSignedUrlResponse::class)
        ->and($object->getUrl())->toBeUrl()
    ;
});

test('Delete File', closure: function () {
    MockClient::global([
        DeleteFile::class => MockResponse::fixture("files.delete"),
    ]);
    $request = new FileRequest();

    $request->setFileId(getenv('FILE_ID'));

    $response = $this->mistral->files()->delete($request);
    /**
     * @var FileDeleteResponse $object
     */
    $object = $response->dto();
    //dump($object->toArray());
    expect($response->status())->toBe(200)
        ->and($response->array())->toBeArray()
        ->and($response->body())->toBeJson()
        ->and($request->getFileId())->toBe(getenv('FILE_ID'))
        ->and($object)->toBeInstanceOf(FileDeleteResponse::class)
        ->and($object->getId())->toBeString()
        ->and($object->getObject())->toBe("file")
        ->and($object->getDeleted())->toBeTrue()
    ;
});
