<?php

use Board3r\MistralSdk\Enums\RoleEnum;
use Board3r\MistralSdk\Helpers\SessionHelper;

test('Session params', function () {
    SessionHelper::disable();
    SessionHelper::enable();
    $stateEnabled = SessionHelper::isEnabled();
    $history = 5;
    SessionHelper::setHistory($history);
    $stateHistory = SessionHelper::getHistory();

    expect($stateEnabled)->toBeTrue()
        ->and($stateHistory)->toBe($history);
});

test('Add message', function ($messages) {
    SessionHelper::enable();
    SessionHelper::resetMessages('chat');
    SessionHelper::addMessages($messages, 'chat');
    $sessionMessages = SessionHelper::getMessages('chat');

    $countUserMessage = 0;
    $promptPresent = (isset($messages[0]['role']) && $messages[0]['role'] == RoleEnum::system->value);
    foreach ($messages as $message) {
        if ($message['role'] == RoleEnum::user->value) {
            $countUserMessage++;
        }
    }
    $countUserSessionMessage = 0;
    $promptSessionPresent = (isset($sessionMessages[0]['role']) && $sessionMessages[0]['role'] == RoleEnum::system->value);
    foreach ($sessionMessages as $message) {
        if ($message['role'] == RoleEnum::user->value) {
            $countUserSessionMessage++;
        }
    }
    //dump($sessionMessages);
    expect($sessionMessages)->toBeArray()
        ->and($countUserSessionMessage)->when($countUserMessage >= SessionHelper::getHistory(),
            fn($countUserSessionMessage) => $countUserSessionMessage->toBeLessThanOrEqual(SessionHelper::getHistory()))
        ->and($countUserSessionMessage)->when($countUserMessage < SessionHelper::getHistory(),
            fn($countUserSessionMessage) => $countUserSessionMessage->toBe($countUserMessage))
        ->and($promptPresent)->toBe($promptSessionPresent);
})->with('session messages');
