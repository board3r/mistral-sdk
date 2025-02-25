<?php

namespace Board3r\MistralSdk\Dto;

/**
 * Interface to cast
 */
interface FormatInterface
{
    /**
     * Convert object to array
     * @return array
     */
    public function toArray(): array;
    /**
     * Convert object to json
     * @return string
     */
    public function toJson(): string;
    /**
     * Convert object to json
     * @return string
     */
    public function __toString(): string;

}
