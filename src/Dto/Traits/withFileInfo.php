<?php

namespace Board3r\MistralSdk\Dto\Traits;
use DateTime;

/**
 * @method string getBytes()
 * @method string getNumLines()
 */
trait withFileInfo
{
    public int $bytes;
    public int $createdAt;
    public int $numLines;

    /**
     * @param  string|null  $format
     * @return DateTime|string
     */
    public function getCreatedAt(?string $format = null): DateTime|string
    {
        $dt = new DateTime();
        $dt->setTimestamp($this->createdAt);
        if ($format) {
            return $dt->format($format);
        }
        return $dt;
    }
}
