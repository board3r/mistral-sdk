<?php

namespace Board3r\MistralSdk\Dto\Traits;

use DateTime;

trait withCreated
{
    public int|null $created;

    /**
     * @param  string|null  $format
     * @return DateTime|string|null
     */
    public function getCreated(?string $format = null): DateTime|string|null
    {
        if (!is_null($this->created)) {
            $dt = new DateTime();
            $dt->setTimestamp($this->created);
            if ($format) {
                return $dt->format($format);
            }
            return $dt;
        }
        return null;
    }
}
