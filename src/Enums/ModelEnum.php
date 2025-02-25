<?php

namespace Board3r\MistralSdk\Enums;

enum ModelEnum: string
{
    // Premier models
    case codestral = 'codestral-latest';
    case large = 'mistral-large-latest';
    case pixtral = 'pixtral-large-latest';
    case saba = 'mistral-saba-latest';
    case ministral3b = 'ministral-3b-latest';
    case ministral8b = 'ministral-8b-latest';
    case embed = 'mistral-embed';
    case moderation = 'mistral-moderation-latest';

    // Free Models
    case small = 'mistral-small-latest';
    case pixtral12b = 'pixtral-12b-2409';

    // Research models
    case nemo = 'open-mistral-nemo';
    case mamba = 'open-codestral-mamba';

    // Legacy
    case mistral7b = 'open-mistral-7b';
    case mixtral8x7b = 'open-mixtral-8x7b';
    case mixtral8x22B = 'open-mixtral-8x22b';
    case medium = 'mistral-medium-2312';
    case small2402 = 'mistral-small-2402';
    case large2402 = 'mistral-large-2402';
    case large2407 = 'mistral-large-2407';
    case codestral2405 = 'codestral-2405';


    public function type(): string
    {
        return match($this) {
            self::codestral, self::large,self::pixtral,self::saba,self::ministral3b,self::ministral8b,self::embed,self::moderation => 'Premier',
            self::small,self::pixtral12b => 'Free',
            self::nemo,self::mamba => 'Research',
            self::mistral7b,self::mixtral8x7b,self::mixtral8x22B,self::medium,self::small2402,self::large2402,self::large2407,self::codestral2405 => 'Legacy'
        };
    }

    public function tokens(): int
    {
        return match($this) {
            self::codestral => 256,
            self::large,self::pixtral,self::ministral3b,self::ministral8b,self::pixtral12b,self::nemo,self::mamba,self::large2407 => 131,
            self::mixtral8x22B => 64,
            self::saba,self::small,self::mistral7b,self::mixtral8x7b,self::medium,self::small2402,self::large2402,self::codestral2405 => 32,
            self::embed,self::moderation => 8,
        };
    }

}
