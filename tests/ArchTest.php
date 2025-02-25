<?php

arch('All resource classes extend the base resource')
    ->expect('Board3r\MistralSdk\Resource')
    ->toExtend(Saloon\Http\BaseResource::class);

arch('All request classes extend the saloon request class')
    ->expect('Board3r\MistralSdk\Requests')
    ->classes()
    ->toExtend(Saloon\Http\Request::class);