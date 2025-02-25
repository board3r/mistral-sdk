<?php
require_once('vendor/autoload.php');


use Board3r\MistralSdk\Dto\Request\FileUploadRequest;
use Board3r\MistralSdk\Mistral;

echo '<pre>';

$mistral = new Mistral("4rJWpqP99qojkb5DzAw2iQjwPoPGdneF");

$request = new FileUploadRequest();
$request->setFile(__DIR__.'/tests/Fixtures/Files/toulouse.jsonl');
$request->setFilename("toulouse_".date("YmdHis").'.jsonl');
$response = $mistral->files()->upload($request);

dump(json_decode($response->body()));
expect(true)->toBeTrue();
