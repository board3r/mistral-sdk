<?php

namespace Board3r\MistralSdk\Helpers;

interface SessionHandlerInterface
{
    public  function get(string $key):?string;

    public  function write(string $key,string $value = null):void;

    public  function has(string $key):bool;

    public  function unset(string $key):void;

    public  function id():string;
}
