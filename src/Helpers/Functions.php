<?php

namespace Board3r\MistralSdk\Helpers;

/**
 * Format xxxx_xxxx
 * @param  string  $str
 * @return string
 */
function SnakeCase(string $str): string
{
    return strtolower(trim(preg_replace('/([A-Z]|[0-9]+)/', "_$1", $str), '_'));
}

/**
 * Format XxxxXxxx
 * @param  string  $str
 * @return string
 */
function PascalCase(string $str): string
{
    return str_replace(' ', '', ucwords(strtr($str, '_-', '  ')));
}

/**
 * Format xxxXxxx
 * @param  string  $str
 * @return string
 */
function CamelCase(string $str): string
{
    return lcfirst(PascalCase($str));
}
