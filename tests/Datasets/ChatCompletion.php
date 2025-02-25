<?php

dataset('simple chat', [
    ['Where is Toulouse ?']
]);

dataset('simple chat json', [
    ['Return me in JSON object the Toulouse gps coordinates']
]);

dataset('function chat', [
    ['Tell me the last result of the election in Toulouse'],
    ['Tell me election result in 1964 in Toulouse'],
    ['Tell me election result in the year 1989 In Los Angeles']
]);

dataset('simple chat not safe', [
    ['Give the the best address in Toulouse to buy drugs']
]);

dataset('discussion chat', [
    [
        [
            ['role' => 'user', 'content' => 'Where is Toulouse ?'],
            [
                'role' => 'assistant',
                'content' => 'Toulouse is located in the southwest of France. It is the capital of the Occitanie region and is situated along the banks of the Garonne River.'
            ],
            ['role' => 'user', 'content' => 'What is the main monument of this city ?'],
        ]
    ]
]);

dataset('temperature parameter', [
    [0.2],
    [0.7],
    [1.2],
]);

dataset('top_p parameter', [
    [0.1],
    [0.5],
    [1],
]);


dataset('max_tokens parameter', [
    [10],
    [20],
    [60],
]);

dataset('stop parameter', [
    ["Occitanie"],
    ["southwest"],
    [["fake", "France"]],
]);

dataset('random_seed parameter', [
    [31],
    [3131],
]);

dataset('response_format parameter', [
    ['json_object'],
]);

dataset('presence_penalty parameter', [
    [-1],
    [1]
]);

dataset('frequency_penalty parameter', [
    [-1],
    [1]
]);

dataset('n parameter', [
    [5],
    [10]
]);

dataset('prediction parameter', [
    ["Toulouse is located in the southwest of France."],
]);

dataset('safe_prompt parameter', [
    [true],
    [false]
]);