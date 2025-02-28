![Banner](/art/mistral-banner.jpg)

# PHP Client for Mistral AI

[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/board3r/mistral-sdk/blob/main/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/board3r/mistral-sdk)](https://github.com/board3r/mistral-sdk/issues)
[![GitHub stars](https://img.shields.io/github/stars/board3r/mistral-sdk)](https://github.com/board3r/mistral-sdk/stargazers)

## Introduction

This PHP library provides a straightforward wrapper for the Mistral API, enabling seamless integration of the Mistral API into your PHP projects.

_Coming soon :_
- _Fine tuning API_
- _Models API_
- _Batch API_

## Features

- Easy integration with the Mistral API
- Chat session management
- Support for various Mistral models
- Flexible configuration
- Full Data To Object approach (request and response)
- Trick integration for message functions
- Built-in testing to ensure reliability

## Requirements

- PHP 8.2 or higher
- [Mistral.ai API key](https://console.mistral.ai/api-keys)

## Installation

You can install the package via Composer:

```bash
composer require board3r/mistral-sdk
```

## Usage

To create an instance of the Mistral client and start interacting with the API, you'll need to initialize the client with your API key or any required credentials. This instance will serve as your primary interface for sending requests to Mistral.AI.

### Client Instantiation & Simple request

```php
require 'vendor/autoload.php';

use Board3r\MistralSdk\Mistral;
use Board3r\MistralSdk\Dto\Request\ChatCompletionRequest;
use Board3r\MistralSdk\Enums\ModelEnum;

$client = new Mistral('your-api-key');
// Chose the Dto or use a simple array
$request = new ChatCompletionRequest();
// Set some datas
$request->setModel(ModelEnum::small->value);
$request->addUserMessage("Please, help me to have some information about Toulouse")
// make the request
$response = $client->chat()->post($request);
// load the response in to the object
$responseObject = $response->dto();

```
You also use the API without the DTO 
```php
// Chose the Dto or use a simple array
$request = new ChatCompletionRequest();
// make the request
$response = $client->chat()->post(
    [
        'messages'=>[[
            'role'=>'user',
            'content'=>"Please, help me to have some information about Toulouse"
        ]],
        'model'=>'mistral-small-latest'
    ]
);
// load the response into an array
$responseAr = $response->array();

```
## Configuration

Some parameters that you can initiate in the .env file

```ini
# Mistral API key can be set directly here or during client instantiation
MISTRAL_API_KEY="[YOUR_API_KEY]"
#  Mistral base url, for Codestral use https://codestral.mistral.ai/v1 and your dedicated api key
MISTRAL_BASE_URL="https://api.mistral.ai/v1"

# Enable session mode for chat messages (available only for chat and agents method) If true the conversation will be keep in session and sent on each call 
MISTRAL_SESSION_ENABLED=false
# Number of user messages to keep in session history
MISTRAL_SESSION_HISTORY=10

# Settings of timeout
MISTRAL_CONNECT_TIMEOUT=30
MISTRAL_REQUEST_TIMEOUT=60

```

## Resources
The resources are directly accessible by the client. They help to send the request and get the response. Call them like that :
```php
// make the request and get response
$response = $client->chat()->post($request);
```
###  [chat()](https://docs.mistral.ai/api/#tag/chat)
- post() | [ChatCompletionRequest](#ChatCompletionRequest) > [ChatCompletionResponse](#ChatCompletionResponse)
- postStreamed() | [ChatCompletionRequest](#ChatCompletionRequest) > [ChatCompletionResponse](#ChatCompletionResponse)

###  [agents()](https://docs.mistral.ai/api/#tag/agents)
- post() | [AgentsCompletionRequest](#AgentsCompletionRequest) > [AgentsCompletionResponse](#AgentsCompletionResponse)
- postStreamed() | [AgentsCompletionRequest](#AgentsCompletionRequest) >~~~~ [AgentsCompletionResponse](#AgentsCompletionResponse)

###  [fim()](https://docs.mistral.ai/api/#tag/fim)
- post() | [FimCompletionRequest](#FimCompletionRequest) > [FimCompletionResponse](#FimCompletionResponse)
- postStreamed() | [FimCompletionRequest](#FimCompletionRequest) > [FimCompletionResponse](#FimCompletionResponse)

### [embeddings()](https://docs.mistral.ai/api/#tag/embeddings)
- post() | [EmbeddingsRequest](#EmbeddingsRequest) > [EmbeddingsResponse](#EmbeddingsResponse)

###  [classifiers()](https://docs.mistral.ai/api/#tag/classifiers)
- postModeration() | [ModerationsRequest](#ModerationsRequest) > [ModerationsResponse](#ModerationsResponse)
- postChatModeration() | [ModerationsChatRequest](#ModerationsChatRequest) > [ModerationsResponse](#ModerationsResponse)

###  [files()](https://docs.mistral.ai/api/#tag/files)
- upload() | [FileUploadRequest](#FileUploadRequest) > [FileResponse](#FileResponse)
- list() | [FileListRequest](#FileListRequest) > [FileListResponse](#FileListResponse)
- get() | [FileRequest](#FileRequest) > [FileResponse](#FileListResponse)
- delete() | [FileRequest](#FileRequest) > [FileDeleteResponse](#FileDeleteResponse)
- getSignedUrl() | [FileSignedUrlRequest](#FileSignedUrlRequest) > [FileSignedUrlRequest](#FileSignedUrlRequest)
- download() | [FileRequest](#FileRequest) > Binary

### Streamed request
The API offer the possibility to steam some response using the method postStreamed().

Below an example to use the stream.
```php
use \Board3r\MistralSdk\Dto\Response\ChatCompletionResponse;
// Returns a generator, which you can iterate over to get the streamed chunks
$stream = $client->chat()->postStreamed($request);

foreach ($stream as $chunk) {

    /** @var ChatCompletionResponse $chunk */
    foreach ($chunk->getChoices() as $choice) {
        $choice->getDelta()->getContent(); // 'Assistant message .'       
    }
}
```

## Chat history Session
Streamed responses are not supported by the Chat history Session. 

Use the lazy mode to keep the conversation in session and send it automatically on each request.

Enable session history using the [.env](#configuration) configuration or using the helper

```php
use Board3r\MistralSdk\Helpers\HistoryHelper;
HistoryHelper::enable();
```
To configure the number of messages retained in the conversation history, set a limit on the number of user messages that are stored. While system, assistant, and tool messages will remain in the session, they will not count towards the history limit. This setup helps manage the conversation context efficiently.
The limit can be set using the [.env](#configuration) configuration or using the helper

```php
use Board3r\MistralSdk\Helpers\HistoryHelper;
HistoryHelper::setParamHistory(10);
```
If the conversation start with a prompt (system message), this prompt will always be used ast first message and will not be erased from your history.   

## Data to Objects (DTOs)
The data to object are based on all properties of request or response defined in [Mistral.ai API documentation](https://docs.mistral.ai/api/).
Each DTOs have a setter and a getter by magical function, so for each property of the API request and response follow this information to set or get the data.

Just use prefix 'set', or 'get' and the API property in PascalCase.

```php
// equivalent to ['model'=>'test']
$dto->setModel('test');
$return = $dto->getModel();
// equivalent to ['presence_penalty'=>1]
$dto->setPressencePenalty(1);
$return = $dto->getPressencePenalty();
// Case with a children property
//equivalent to ['response_format'=>['type'=>'json_object']]
$dto->getResponseFormat()->setType(ResponseFormatEnum::json->value));
// or you can bind directly the DTO
$responseFormat = new ResponseFormat();
$responseFormat->setType(ResponseFormatEnum::json->value);
$dto->setResponseFormat($responseFormat);

$return = $dto->getResponseFormat->getType();


```
In case of collection, it's possible to bind the array or the object
```php
// equivalent to ['messages'=> [['role'=>'user','content'=>"Information about Toulouse"]]]
$dto->setMessages([['role'=>'user','content'=>"Information about Toulouse"]]);
// or 
$collection = new MessageCollection([['role'=>'user','content'=>"Information about Toulouse"]]);
$dto->setMessages(MessageCollection);
// or
$dto->getMessages()->append(['role'=>'user','content'=>"Information about Toulouse"]);
// or
$message = new Message();
$message->setRole(RoleEnum::user->value);
$message->setContent("Information about Toulouse");
$dto->getMessages()->append($message);

// get all collection 
$return = $dto->getMessages();
// or to get the first message only (can throw not defined)
$return = $dto->getMessages()[0];
// equivalent to (return null if not defined)
$return = $dto->getMessages()->get(0);
// count number of messages
$count = $dto->getMessages()->count()
// or
$count = count($dto->getMessages());

// browse the collection
foreach($dto->getMessages() AS $message){
...
}

```
Each DTO can be converted to array or json
```php
$ar = $dto->toArray();

$json = $dto->toJson();
// or
$json = (string)$dto;
```
Some DTO have shortcut function to lazy bind or get data, each function will be described below.

## Request Data to Objects

###  Chat
#### ChatCompletionRequest
For addFunction() [Message's Function trick](#messages-function-trick)
```php
// Add tool function in your call
$request->addFunction(callable $callable, ?string $description = null, ?array $paramDesc = null, ?bool $strict = null);
// Add a message with user role
$request->addUserMessage(string|array $message, ?string $type = null);
// Add a message with assistant role
$request->addAssistantMessage(string|array $message, ?string $type = null, ToolCallCollection|array|null $toolCall = null, ?bool $prefix = null);
// Add a message with system role
$request->addSystemMessage(string|array $message);
// Add a message with tool role
$request->addToolMessage(string|array $message, ?string $type = null, ?string $name = null, ?string $toolCallID = null);

```

###  Agents
#### AgentsCompletionRequest
See [ChatCompletionRequest](#ChatCompletionRequest)
###  FIM
#### FimCompletionRequest

###  Embeddings
#### EmbeddingsRequest

###  Classifiers
#### ModerationsChatRequest

#### ModerationsRequest

###  Files
#### FileListRequest

#### FileRequest

#### FileSignedUrlRequest

#### FileUploadRequest
```php
// To upload a file, just give the path, by default the file will be validate before to send it. The format and the data will be check.
$request->setFile(string $filepath,bool $validate = true);

```

## Response Data to Objects
All properties referer to a timestamp (created, created_at) will return automatically a DateTime object, or a string with formated date if you pass the arguments format calling the method.
```php

$dateTimeObject = $request->getCreated();

$dateFormated = $request->getCreated("Y-m-d H:i:s");

```
###  Chat
#### ChatCompletionResponse

###  Agents
#### AgentsCompletionResponse

###  FIM
#### FimCompletionResponse

###  Embeddings
#### EmbeddingsResponse

###  Classifiers
#### ModerationsResponse
```php
// Get the moderation scoring with a float by category Name. You can use ClassificationEnum 
$request->getScore(string $catName); 
// Get a boolean to know if the message is moderate or not by category name.
$request->getModeration(string $catName);
```
###  Files
#### FileResponse

#### FileSignedUrlResponse

#### FileListResponse
#### FileDeleteResponse

###  Errors
```php
//All errors get the ErrorInterface with this method. Get the error information message.
$error->getErrorMessage();
```
#### BasicError

#### ValidationError

#### RequestError

## Message's Function trick
In Chat and Agents API request you can set a function calling the method setFunction() on the DTO.

This method will set the property 'tools' in the API request
Some explanation here about this use.
```php

class MyClass
{
    public static function myFunction(string $param1, ?int $param2 = null): string
    {
        ...
        return $result;
    }
}
// The first parameter must be a callable
$request->addFunction(callable:[MyClass::class,'myFunction'],
                      description:'Give a good description about the function',
                      paramDesc :['param1'=>'Give a good description for param1',
                                  'param2'=>'Give a good description for param2'],
                      strict:true);


```
Using PHP Doc block, all the block are optional, if they are not set, the information about the function will be built by the reflexion class and the parameters $description and $paramDesc when the method setFunction() is called.

- @mistralName : Alternative name of the function
- @mistralDesc : Good description of the function for  Mistral.ai
- @mistralParam format $paramName : Good description of the parameter for Mistral.ai
- @mistralJSON paramName : json based on https://json-schema.org/ to define the parameter, let you use other attributes like enum, regex...
- @mistralRequired $paramName : To make the parameter required in Mistral.ai
- @mistralStrict : Activate the strict mode for the function in Mistral.ai
```php

class MyClass
{
    /**
     * @mistralName myFunction
     * @mistralDesc Give a good description about the function
     * @mistralParam string $param1 Give a good description for param1
     * @mistralJSON param2 {"type": "number","description": "Give a good description about "}
     * @mistralRequired $param1
     * @mistralStrict
     **/
    public static function myFunction(string $param1, ?int $param2 = null): string
    {
        ...
        return $result;
    }
}

$request->setFunction([MyClass::class,'myFunction'],);


```

## Model Enums
Use your model accessing by enum
```php
use \Board3r\MistralSdk\Enums\ModelEnum;

$request->setModel(ModelEnum::large->value);

```

**Premium Models:**
- codestral = 'codestral-latest'
- large = 'mistral-large-latest'
- pixtral = 'pixtral-large-latest'
- saba = 'mistral-saba-latest'
- ministral3b = 'ministral-3b-latest'
- ministral8b = 'ministral-8b-latest'
- embed = 'mistral-embed'
- moderation = 'mistral-moderation-latest'

**Free Models:**
- small = 'mistral-small-latest'
- pixtral12b = 'pixtral-12b-2409'

**Research Models:**
- nemo = 'open-mistral-nemo'
- mamba = 'open-codestral-mamba'

**Legacy Models:**
- mistral7b = 'open-mistral-7b'
- mixtral8x7b = 'open-mixtral-8x7b'
- mixtral8x22B = 'open-mixtral-8x22b'
- medium = 'mistral-medium-2312'
- small2402 = 'mistral-small-2402'
- large2402 = 'mistral-large-2402'
- large2407 = 'mistral-large-2407'
- codestral2405 = 'codestral-2405'

## Testing

To run tests, use Pest:

```bash
vendor/bin/pest
```

## Changelog
For a detailed list of changes and updates, please refer to the [CHANGELOG](CHANGELOG.md) file.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE.md) file for details.

## Disclaimer

Mistral and the Mistral logo are trademarks of Mistral.ai. This package is not affiliated with, endorsed by, or sponsored by Mistral.ai. All trademarks and registered trademarks are the property of their respective owners.

See [Mistral.AI](https://mistral.ai/) for more information.

## Special Thanks

This package is inspired by [Helge Sverre's Mistral](https://github.com/HelgeSverre/mistral).

And their code helped me : 
- [Saloon PHP](https://github.com/saloonphp/saloon) / Simplify all the API requests
- [Arnold Daniels](https://github.com/jasny/phpdoc-parser) / Help me to read PHP doc block
- [Raphael Stolt](https://github.com/stolt/json-lines) / Help me to read Jsonl Files

