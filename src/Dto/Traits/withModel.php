<?php

namespace Board3r\MistralSdk\Dto\Traits;

use InvalidArgumentException;

/**
 * @method string getModel()
 * @property array $_allowedModels
 */
trait withModel
{
    public string $model;

    public function setModel(string $model): static
    {
        if (isset($this->_allowedModels) && !in_array($model, $this->_allowedModels)) {
            throw new InvalidArgumentException("Model $model is not allowed. Available models : ".implode(", ", $this->_allowedModels));
        }
        $this->model = $model;

        return $this;
    }
}
