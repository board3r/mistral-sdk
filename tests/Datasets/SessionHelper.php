<?php
dataset('session messages', [
    [[['role' => 'user', 'content' => 'test1']]],
    [[['role' => 'user', 'content' => 'test2'], ['role' => 'assistant', 'content' => 'response2']]],
    [[['role' => 'user', 'content' => 'test3.1'], ['role' => 'assistant', 'content' => 'response3.1'], ['role' => 'user', 'content' => 'test3.2']]],
    [
        [
            ['role' => 'system', 'content' => 'prompt4'],
            ['role' => 'user', 'content' => 'test4.1'], ['role' => 'assistant', 'content' => 'response4.1'],
            ['role' => 'user', 'content' => 'test4.2'], ['role' => 'assistant', 'content' => 'response4.2'],
            ['role' => 'user', 'content' => 'test4.3'], ['role' => 'assistant', 'content' => 'response4.3'],
            ['role' => 'user', 'content' => 'test4.4'], ['role' => 'assistant', 'content' => 'response4.4'],
            ['role' => 'user', 'content' => 'test4.5'], ['role' => 'assistant', 'content' => 'response4.5'],
            ['role' => 'user', 'content' => 'test4.6'], ['role' => 'assistant', 'content' => 'response4.6'],
            ['role' => 'user', 'content' => 'test4.7'], ['role' => 'assistant', 'content' => 'response4.7'],
            ['role' => 'user', 'content' => 'test4.8'], ['role' => 'assistant', 'content' => 'response4.8'],
            ['role' => 'user', 'content' => 'test4.9'], ['role' => 'assistant', 'content' => 'response4.9'],
            ['role' => 'user', 'content' => 'test4.10'], ['role' => 'assistant', 'content' => 'response4.10'],
            ['role' => 'user', 'content' => 'test4.11'], ['role' => 'assistant', 'content' => 'response4.11'],
            ['role' => 'user', 'content' => 'test4.12'], ['role' => 'assistant', 'content' => 'response4.12'],
            ['role' => 'user', 'content' => 'test4.13'], ['role' => 'assistant', 'content' => 'response4.13']
        ]
    ],
]);
