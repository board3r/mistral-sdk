<?php

use Board3r\MistralSdk\Enums\RoleEnum;
use Board3r\MistralSdk\Helpers\HistoryHelper;

test('Session params', function () {
    HistoryHelper::disable();
    HistoryHelper::enable();
    $stateEnabled = HistoryHelper::isEnabled();
    $history = 5;
    HistoryHelper::setParamHistory($history);
    $stateHistory = HistoryHelper::getParamHistory();

    expect($stateEnabled)->toBeTrue()
        ->and($stateHistory)->toBe($history);
});

test('Add message', function ($messages) {
    HistoryHelper::enable();
    HistoryHelper::resetMessages();
    HistoryHelper::addMessages($messages );
    $sessionMessages = HistoryHelper::getMessagesHistory();

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
    expect($sessionMessages)->toBeArray()
        ->and($countUserSessionMessage)->when($countUserMessage >= HistoryHelper::getParamHistory(),
            fn($countUserSessionMessage) => $countUserSessionMessage->toBeLessThanOrEqual(HistoryHelper::getParamHistory()))
        ->and($countUserSessionMessage)->when($countUserMessage < HistoryHelper::getParamHistory(),
            fn($countUserSessionMessage) => $countUserSessionMessage->toBe($countUserMessage))
        ->and($promptPresent)->toBe($promptSessionPresent);
})->with('session messages');
