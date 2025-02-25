<?php

dataset('chat completion request', [
    // Tests with mistral-large-latest
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.7,
            "top_p" => 1,
            "max_tokens" => 50,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quelle est la capitale de la France ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0,
            "frequency_penalty" => 0,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 1,
            "top_p" => 0.8,
            "max_tokens" => 50,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un assistant utile."]]],
                ["role" => "user", "content" => "Traduis 'Hello' en français."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0,
            "frequency_penalty" => 0.2,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 1,
            "top_p" => 0.7,
            "max_tokens" => 150,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "Le livre '1984' est un roman dystopique."]]],
                ["role" => "user", "content" => "Résume le livre '1984' de George Orwell."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.3,
            "frequency_penalty" => 0,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 1,
            "top_p" => 1,
            "max_tokens" => 100,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => [["type" => "text", "text" => "Quels sont les ingrédients pour faire une omelette ?"]]],
                ["role" => "tool", "tool_call_id" => "call_1", "content" => [["type" => "image_url", "image_url" => "https://example.com/omelette.jpg"]]]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [["type" => "function", "function" => ["name" => "image_search", "arguments" => ["query" => "omelette"]]]],
            "tool_choice" => "auto",
            "presence_penalty" => 0,
            "frequency_penalty" => 0,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.9,
            "top_p" => 0.5,
            "max_tokens" => 200,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique la théorie de la relativité d'Einstein."],
                ["role" => "assistant", "content" => "La théorie de la relativité est complexe."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.5,
            "frequency_penalty" => 0.5,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.7,
            "top_p" => 0.3,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quelle est la différence entre une girouette et un anémomètre ?"],
                ["role" => "assistant", "content" => "Une girouette indique la direction du vent."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.7,
            "frequency_penalty" => 0.7,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.8,
            "top_p" => 0.2,
            "max_tokens" => 150,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en mécanique."]]],
                ["role" => "user", "content" => "Comment fonctionne un moteur à combustion interne ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.8,
            "frequency_penalty" => 0.8,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.6,
            "top_p" => 0.1,
            "max_tokens" => 120,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "L'énergie solaire est renouvelable."]]],
                ["role" => "user", "content" => "Quels sont les avantages de l'énergie solaire ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.9,
            "frequency_penalty" => 0.9,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.7,
            "top_p" => 0.0,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quelle est la recette du tiramisu ?"],
                ["role" => "tool", "tool_call_id" => "call_2", "content" => [["type" => "image_url", "image_url" => "https://example.com/tiramisu.jpg"]]]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [["type" => "function", "function" => ["name" => "image_search", "arguments" => ["query" => "tiramisu"]]]],
            "tool_choice" => "auto",
            "presence_penalty" => 1.0,
            "frequency_penalty" => 1.0,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.9,
            "top_p" => 0.9,
            "max_tokens" => 200,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique le concept de blockchain."],
                ["role" => "assistant", "content" => "La blockchain est une technologie décentralisée."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.1,
            "frequency_penalty" => 0.1,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.5,
            "top_p" => 0.8,
            "max_tokens" => 70,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un assistant médical."]]],
                ["role" => "user", "content" => "Quels sont les symptômes de la grippe ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.2,
            "frequency_penalty" => 0.2,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.8,
            "top_p" => 0.7,
            "max_tokens" => 150,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Comment apprendre une nouvelle langue efficacement ?"],
                ["role" => "assistant", "content" => "L'immersion est une méthode efficace."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.3,
            "frequency_penalty" => 0.3,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.6,
            "top_p" => 0.6,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un coach de vie."]]],
                ["role" => "user", "content" => "Quelle est la meilleure façon de gérer le stress ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.4,
            "frequency_penalty" => 0.4,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.7,
            "top_p" => 0.5,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "Rome est riche en histoire."]]],
                ["role" => "user", "content" => "Quels sont les principaux monuments de Rome ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.5,
            "frequency_penalty" => 0.5,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.9,
            "top_p" => 0.4,
            "max_tokens" => 200,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique le fonctionnement d'un réseau neuronal."],
                ["role" => "assistant", "content" => "Un réseau neuronal est inspiré du cerveau humain."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.6,
            "frequency_penalty" => 0.6,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.5,
            "top_p" => 0.3,
            "max_tokens" => 70,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en bien-être."]]],
                ["role" => "user", "content" => "Quels sont les bienfaits de la méditation ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.7,
            "frequency_penalty" => 0.7,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.6,
            "top_p" => 0.2,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Comment préparer un smoothie vert ?"],
                ["role" => "assistant", "content" => "Utilise des ingrédients frais."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.8,
            "frequency_penalty" => 0.8,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.7,
            "top_p" => 0.1,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un développeur web."]]],
                ["role" => "user", "content" => "Quelle est la différence entre le HTML et le CSS ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.9,
            "frequency_penalty" => 0.9,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.8,
            "top_p" => 0.0,
            "max_tokens" => 150,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "La photosynthèse est essentielle pour les plantes."]]],
                ["role" => "user", "content" => "Explique le principe de la photosynthèse."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 1.0,
            "frequency_penalty" => 1.0,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.6,
            "top_p" => 0.9,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quels sont les avantages du yoga ?"],
                ["role" => "assistant", "content" => "Le yoga améliore la flexibilité."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.1,
            "frequency_penalty" => 0.1,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.7,
            "top_p" => 0.8,
            "max_tokens" => 120,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en énergie renouvelable."]]],
                ["role" => "user", "content" => "Comment fonctionne un panneau solaire ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.2,
            "frequency_penalty" => 0.2,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.5,
            "top_p" => 0.7,
            "max_tokens" => 70,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quelle est la recette des cookies au chocolat ?"],
                ["role" => "tool", "tool_call_id" => "call_3", "content" => [["type" => "image_url", "image_url" => "https://example.com/cookies.jpg"]]]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [["type" => "function", "function" => ["name" => "image_search", "arguments" => ["query" => "cookies"]]]],
            "tool_choice" => "auto",
            "presence_penalty" => 0.3,
            "frequency_penalty" => 0.3,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.9,
            "top_p" => 0.6,
            "max_tokens" => 200,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique le concept de l'intelligence artificielle."],
                ["role" => "assistant", "content" => "L'IA simule l'intelligence humaine."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.4,
            "frequency_penalty" => 0.4,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.5,
            "top_p" => 0.5,
            "max_tokens" => 70,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en allergies."]]],
                ["role" => "user", "content" => "Quels sont les symptômes de l'allergie au pollen ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.5,
            "frequency_penalty" => 0.5,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.8,
            "top_p" => 0.4,
            "max_tokens" => 150,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Comment améliorer sa productivité au travail ?"],
                ["role" => "assistant", "content" => "Faire des pauses régulières."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.6,
            "frequency_penalty" => 0.6,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.6,
            "top_p" => 0.3,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un coach sportif."]]],
                ["role" => "user", "content" => "Quelle est la meilleure façon de faire de l'exercice ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.7,
            "frequency_penalty" => 0.7,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.7,
            "top_p" => 0.2,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "Paris est connue pour ses monuments."]]],
                ["role" => "user", "content" => "Quels sont les principaux monuments de Paris ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.8,
            "frequency_penalty" => 0.8,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.9,
            "top_p" => 0.1,
            "max_tokens" => 200,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique le fonctionnement d'un moteur électrique."],
                ["role" => "assistant", "content" => "Un moteur électrique convertit l'énergie électrique en mouvement."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.9,
            "frequency_penalty" => 0.9,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.5,
            "top_p" => 0.0,
            "max_tokens" => 70,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en bien-être."]]],
                ["role" => "user", "content" => "Quels sont les bienfaits de la marche ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 1.0,
            "frequency_penalty" => 1.0,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.6,
            "top_p" => 0.9,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Comment préparer une salade César ?"],
                ["role" => "assistant", "content" => "Utilise des ingrédients frais."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.1,
            "frequency_penalty" => 0.1,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.7,
            "top_p" => 0.8,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un développeur web."]]],
                ["role" => "user", "content" => "Quelle est la différence entre le JavaScript et le TypeScript ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.2,
            "frequency_penalty" => 0.2,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.8,
            "top_p" => 0.7,
            "max_tokens" => 150,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "La gravité est une force fondamentale."]]],
                ["role" => "user", "content" => "Explique le principe de la gravité."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.3,
            "frequency_penalty" => 0.3,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.6,
            "top_p" => 0.6,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quels sont les avantages de la natation ?"],
                ["role" => "assistant", "content" => "La natation est un excellent exercice cardiovasculaire."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.4,
            "frequency_penalty" => 0.4,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.7,
            "top_p" => 0.5,
            "max_tokens" => 120,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en énergie renouvelable."]]],
                ["role" => "user", "content" => "Comment fonctionne une éolienne ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.5,
            "frequency_penalty" => 0.5,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.5,
            "top_p" => 0.4,
            "max_tokens" => 70,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quelle est la recette du gâteau au yaourt ?"],
                ["role" => "tool", "tool_call_id" => "call_4", "content" => [["type" => "image_url", "image_url" => "https://example.com/yogurt_cake.jpg"]]]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [["type" => "function", "function" => ["name" => "image_search", "arguments" => ["query" => "yogurt cake"]]]],
            "tool_choice" => "auto",
            "presence_penalty" => 0.6,
            "frequency_penalty" => 0.6,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.9,
            "top_p" => 0.3,
            "max_tokens" => 200,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique le concept de la réalité augmentée."],
                ["role" => "assistant", "content" => "La réalité augmentée superpose des éléments virtuels au monde réel."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.7,
            "frequency_penalty" => 0.7,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.5,
            "top_p" => 0.2,
            "max_tokens" => 70,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en nutrition."]]],
                ["role" => "user", "content" => "Quels sont les symptômes de l'intolérance au lactose ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.8,
            "frequency_penalty" => 0.8,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.8,
            "top_p" => 0.1,
            "max_tokens" => 150,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Comment améliorer sa mémoire ?"],
                ["role" => "assistant", "content" => "Utilise des techniques de mémorisation."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.9,
            "frequency_penalty" => 0.9,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.6,
            "top_p" => 0.0,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un coach de vie."]]],
                ["role" => "user", "content" => "Quelle est la meilleure façon de se détendre ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 1.0,
            "frequency_penalty" => 1.0,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.7,
            "top_p" => 0.9,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "Londres est riche en histoire."]]],
                ["role" => "user", "content" => "Quels sont les principaux monuments de Londres ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.1,
            "frequency_penalty" => 0.1,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.9,
            "top_p" => 0.8,
            "max_tokens" => 200,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique le fonctionnement d'un réacteur nucléaire."],
                ["role" => "assistant", "content" => "Un réacteur nucléaire produit de l'énergie par fission."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.2,
            "frequency_penalty" => 0.2,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.5,
            "top_p" => 0.7,
            "max_tokens" => 70,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en bien-être."]]],
                ["role" => "user", "content" => "Quels sont les bienfaits du vélo ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.3,
            "frequency_penalty" => 0.3,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.6,
            "top_p" => 0.6,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Comment préparer des sushis ?"],
                ["role" => "assistant", "content" => "Utilise des ingrédients frais."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.4,
            "frequency_penalty" => 0.4,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.7,
            "top_p" => 0.5,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un développeur web."]]],
                ["role" => "user", "content" => "Quelle est la différence entre le Python et le Java ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.5,
            "frequency_penalty" => 0.5,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.8,
            "top_p" => 0.4,
            "max_tokens" => 150,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "L'électromagnétisme est une force fondamentale."]]],
                ["role" => "user", "content" => "Explique le principe de l'électromagnétisme."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.6,
            "frequency_penalty" => 0.6,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.6,
            "top_p" => 0.3,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quels sont les avantages de la natation ?"],
                ["role" => "assistant", "content" => "La natation est un excellent exercice cardiovasculaire."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.7,
            "frequency_penalty" => 0.7,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-large-latest",
            "temperature" => 0.7,
            "top_p" => 0.2,
            "max_tokens" => 120,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en énergie renouvelable."]]],
                ["role" => "user", "content" => "Comment fonctionne une éolienne ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.8,
            "frequency_penalty" => 0.8,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],

    // Tests with mistral-small-latest
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.7,
            "top_p" => 1,
            "max_tokens" => 50,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quelle est la capitale de la France ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0,
            "frequency_penalty" => 0,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 1,
            "top_p" => 0.8,
            "max_tokens" => 50,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un assistant utile."]]],
                ["role" => "user", "content" => "Traduis 'Hello' en français."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0,
            "frequency_penalty" => 0.2,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 1,
            "top_p" => 0.7,
            "max_tokens" => 150,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "Le livre '1984' est un roman dystopique."]]],
                ["role" => "user", "content" => "Résume le livre '1984' de George Orwell."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.3,
            "frequency_penalty" => 0,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 1,
            "top_p" => 1,
            "max_tokens" => 100,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => [["type" => "text", "text" => "Quels sont les ingrédients pour faire une omelette ?"]]],
                ["role" => "tool", "tool_call_id" => "call_1", "content" => [["type" => "image_url", "image_url" => "https://example.com/omelette.jpg"]]]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [["type" => "function", "function" => ["name" => "image_search", "arguments" => ["query" => "omelette"]]]],
            "tool_choice" => "auto",
            "presence_penalty" => 0,
            "frequency_penalty" => 0,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.9,
            "top_p" => 0.5,
            "max_tokens" => 200,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique la théorie de la relativité d'Einstein."],
                ["role" => "assistant", "content" => "La théorie de la relativité est complexe."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.5,
            "frequency_penalty" => 0.5,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.7,
            "top_p" => 0.3,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quelle est la différence entre une girouette et un anémomètre ?"],
                ["role" => "assistant", "content" => "Une girouette indique la direction du vent."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.7,
            "frequency_penalty" => 0.7,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.8,
            "top_p" => 0.2,
            "max_tokens" => 150,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en mécanique."]]],
                ["role" => "user", "content" => "Comment fonctionne un moteur à combustion interne ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.8,
            "frequency_penalty" => 0.8,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.6,
            "top_p" => 0.1,
            "max_tokens" => 120,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "L'énergie solaire est renouvelable."]]],
                ["role" => "user", "content" => "Quels sont les avantages de l'énergie solaire ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.9,
            "frequency_penalty" => 0.9,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.7,
            "top_p" => 0.0,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quelle est la recette du tiramisu ?"],
                ["role" => "tool", "tool_call_id" => "call_2", "content" => [["type" => "image_url", "image_url" => "https://example.com/tiramisu.jpg"]]]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [["type" => "function", "function" => ["name" => "image_search", "arguments" => ["query" => "tiramisu"]]]],
            "tool_choice" => "auto",
            "presence_penalty" => 1.0,
            "frequency_penalty" => 1.0,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.9,
            "top_p" => 0.9,
            "max_tokens" => 200,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique le concept de blockchain."],
                ["role" => "assistant", "content" => "La blockchain est une technologie décentralisée."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.1,
            "frequency_penalty" => 0.1,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.5,
            "top_p" => 0.8,
            "max_tokens" => 70,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un assistant médical."]]],
                ["role" => "user", "content" => "Quels sont les symptômes de la grippe ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.2,
            "frequency_penalty" => 0.2,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.8,
            "top_p" => 0.7,
            "max_tokens" => 150,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Comment apprendre une nouvelle langue efficacement ?"],
                ["role" => "assistant", "content" => "L'immersion est une méthode efficace."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.3,
            "frequency_penalty" => 0.3,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.6,
            "top_p" => 0.6,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un coach de vie."]]],
                ["role" => "user", "content" => "Quelle est la meilleure façon de gérer le stress ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.4,
            "frequency_penalty" => 0.4,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.7,
            "top_p" => 0.5,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "Rome est riche en histoire."]]],
                ["role" => "user", "content" => "Quels sont les principaux monuments de Rome ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.5,
            "frequency_penalty" => 0.5,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.9,
            "top_p" => 0.4,
            "max_tokens" => 200,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique le fonctionnement d'un réseau neuronal."],
                ["role" => "assistant", "content" => "Un réseau neuronal est inspiré du cerveau humain."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.6,
            "frequency_penalty" => 0.6,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.5,
            "top_p" => 0.3,
            "max_tokens" => 70,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en bien-être."]]],
                ["role" => "user", "content" => "Quels sont les bienfaits de la méditation ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.7,
            "frequency_penalty" => 0.7,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.6,
            "top_p" => 0.2,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Comment préparer un smoothie vert ?"],
                ["role" => "assistant", "content" => "Utilise des ingrédients frais."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.8,
            "frequency_penalty" => 0.8,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.7,
            "top_p" => 0.1,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un développeur web."]]],
                ["role" => "user", "content" => "Quelle est la différence entre le HTML et le CSS ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.9,
            "frequency_penalty" => 0.9,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.8,
            "top_p" => 0.0,
            "max_tokens" => 150,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "La photosynthèse est essentielle pour les plantes."]]],
                ["role" => "user", "content" => "Explique le principe de la photosynthèse."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 1.0,
            "frequency_penalty" => 1.0,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.6,
            "top_p" => 0.9,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quels sont les avantages du yoga ?"],
                ["role" => "assistant", "content" => "Le yoga améliore la flexibilité."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.1,
            "frequency_penalty" => 0.1,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.7,
            "top_p" => 0.8,
            "max_tokens" => 120,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en énergie renouvelable."]]],
                ["role" => "user", "content" => "Comment fonctionne un panneau solaire ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.2,
            "frequency_penalty" => 0.2,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.5,
            "top_p" => 0.7,
            "max_tokens" => 70,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quelle est la recette des cookies au chocolat ?"],
                ["role" => "tool", "tool_call_id" => "call_3", "content" => [["type" => "image_url", "image_url" => "https://example.com/cookies.jpg"]]]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [["type" => "function", "function" => ["name" => "image_search", "arguments" => ["query" => "cookies"]]]],
            "tool_choice" => "auto",
            "presence_penalty" => 0.3,
            "frequency_penalty" => 0.3,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.9,
            "top_p" => 0.6,
            "max_tokens" => 200,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique le concept de l'intelligence artificielle."],
                ["role" => "assistant", "content" => "L'IA simule l'intelligence humaine."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.4,
            "frequency_penalty" => 0.4,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.5,
            "top_p" => 0.5,
            "max_tokens" => 70,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en allergies."]]],
                ["role" => "user", "content" => "Quels sont les symptômes de l'allergie au pollen ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.5,
            "frequency_penalty" => 0.5,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.8,
            "top_p" => 0.4,
            "max_tokens" => 150,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Comment améliorer sa productivité au travail ?"],
                ["role" => "assistant", "content" => "Faire des pauses régulières."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.6,
            "frequency_penalty" => 0.6,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.6,
            "top_p" => 0.3,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un coach sportif."]]],
                ["role" => "user", "content" => "Quelle est la meilleure façon de faire de l'exercice ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.7,
            "frequency_penalty" => 0.7,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.7,
            "top_p" => 0.2,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "Paris est connue pour ses monuments."]]],
                ["role" => "user", "content" => "Quels sont les principaux monuments de Paris ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.8,
            "frequency_penalty" => 0.8,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.9,
            "top_p" => 0.1,
            "max_tokens" => 200,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique le fonctionnement d'un moteur électrique."],
                ["role" => "assistant", "content" => "Un moteur électrique convertit l'énergie électrique en mouvement."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.9,
            "frequency_penalty" => 0.9,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.5,
            "top_p" => 0.0,
            "max_tokens" => 70,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en bien-être."]]],
                ["role" => "user", "content" => "Quels sont les bienfaits de la marche ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 1.0,
            "frequency_penalty" => 1.0,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.6,
            "top_p" => 0.9,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Comment préparer une salade César ?"],
                ["role" => "assistant", "content" => "Utilise des ingrédients frais."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.1,
            "frequency_penalty" => 0.1,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.7,
            "top_p" => 0.8,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un développeur web."]]],
                ["role" => "user", "content" => "Quelle est la différence entre le JavaScript et le TypeScript ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.2,
            "frequency_penalty" => 0.2,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.8,
            "top_p" => 0.7,
            "max_tokens" => 150,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "La gravité est une force fondamentale."]]],
                ["role" => "user", "content" => "Explique le principe de la gravité."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.3,
            "frequency_penalty" => 0.3,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.6,
            "top_p" => 0.6,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quels sont les avantages de la natation ?"],
                ["role" => "assistant", "content" => "La natation est un excellent exercice cardiovasculaire."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.4,
            "frequency_penalty" => 0.4,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.7,
            "top_p" => 0.5,
            "max_tokens" => 120,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en énergie renouvelable."]]],
                ["role" => "user", "content" => "Comment fonctionne une éolienne ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.5,
            "frequency_penalty" => 0.5,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.5,
            "top_p" => 0.4,
            "max_tokens" => 70,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quelle est la recette du gâteau au yaourt ?"],
                ["role" => "tool", "tool_call_id" => "call_4", "content" => [["type" => "image_url", "image_url" => "https://example.com/yogurt_cake.jpg"]]]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [["type" => "function", "function" => ["name" => "image_search", "arguments" => ["query" => "yogurt cake"]]]],
            "tool_choice" => "auto",
            "presence_penalty" => 0.6,
            "frequency_penalty" => 0.6,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.9,
            "top_p" => 0.3,
            "max_tokens" => 200,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique le concept de la réalité augmentée."],
                ["role" => "assistant", "content" => "La réalité augmentée superpose des éléments virtuels au monde réel."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.7,
            "frequency_penalty" => 0.7,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.5,
            "top_p" => 0.2,
            "max_tokens" => 70,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en nutrition."]]],
                ["role" => "user", "content" => "Quels sont les symptômes de l'intolérance au lactose ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.8,
            "frequency_penalty" => 0.8,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.8,
            "top_p" => 0.1,
            "max_tokens" => 150,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Comment améliorer sa mémoire ?"],
                ["role" => "assistant", "content" => "Utilise des techniques de mémorisation."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.9,
            "frequency_penalty" => 0.9,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.6,
            "top_p" => 0.0,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un coach de vie."]]],
                ["role" => "user", "content" => "Quelle est la meilleure façon de se détendre ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 1.0,
            "frequency_penalty" => 1.0,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.7,
            "top_p" => 0.9,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "Londres est riche en histoire."]]],
                ["role" => "user", "content" => "Quels sont les principaux monuments de Londres ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.1,
            "frequency_penalty" => 0.1,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.9,
            "top_p" => 0.8,
            "max_tokens" => 200,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Explique le fonctionnement d'un réacteur nucléaire."],
                ["role" => "assistant", "content" => "Un réacteur nucléaire produit de l'énergie par fission."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.2,
            "frequency_penalty" => 0.2,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.5,
            "top_p" => 0.7,
            "max_tokens" => 70,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en bien-être."]]],
                ["role" => "user", "content" => "Quels sont les bienfaits du vélo ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.3,
            "frequency_penalty" => 0.3,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.6,
            "top_p" => 0.6,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Comment préparer des sushis ?"],
                ["role" => "assistant", "content" => "Utilise des ingrédients frais."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.4,
            "frequency_penalty" => 0.4,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.7,
            "top_p" => 0.5,
            "max_tokens" => 80,
            "stop" => ["\n"],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un développeur web."]]],
                ["role" => "user", "content" => "Quelle est la différence entre le Python et le Java ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.5,
            "frequency_penalty" => 0.5,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.8,
            "top_p" => 0.4,
            "max_tokens" => 150,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "assistant", "content" => [["type" => "text", "text" => "L'électromagnétisme est une force fondamentale."]]],
                ["role" => "user", "content" => "Explique le principe de l'électromagnétisme."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.6,
            "frequency_penalty" => 0.6,
            "n" => 1,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.6,
            "top_p" => 0.3,
            "max_tokens" => 100,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "user", "content" => "Quels sont les avantages de la natation ?"],
                ["role" => "assistant", "content" => "La natation est un excellent exercice cardiovasculaire."]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.7,
            "frequency_penalty" => 0.7,
            "n" => 2,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => true
        ]
    ],
    [
        [
            "model" => "mistral-small-latest",
            "temperature" => 0.7,
            "top_p" => 0.2,
            "max_tokens" => 120,
            "stop" => ["."],
            "random_seed" => 0,
            "messages" => [
                ["role" => "system", "content" => [["type" => "text", "text" => "Tu es un expert en énergie renouvelable."]]],
                ["role" => "user", "content" => "Comment fonctionne une éolienne ?"]
            ],
            "response_format" => ["type" => "text"],
            "tools" => [],
            "tool_choice" => "auto",
            "presence_penalty" => 0.8,
            "frequency_penalty" => 0.8,
            "n" => 3,
            "prediction" => ["type" => "content", "content" => ""],
            "safe_prompt" => false
        ]
    ]
]);