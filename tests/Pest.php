<?php

use Board3r\MistralSdk\Tests\TestCase;
use Saloon\Http\Faking\MockClient;

uses(TestCase::class)
    ->beforeEach(fn () => MockClient::destroyGlobal())
    ->in(__DIR__);

class MistralFunction
{
    /**
     * @mistralName electionResult
     * @mistralDesc Give election result by city and year
     * @mistralParam string $city City of the election
     * @mistralJSON year {"type": "number","description": "Year of the election"}
     * @mistralRequired $city
     * @mistralStrict
     **/
    public static function getElectionResult(string $city, ?int $year = null): string
    {
        return $city.' - '.$year;
    }
}