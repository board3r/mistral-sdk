<?php

namespace Board3r\MistralSdk\Dto;

use ArrayObject;
use InvalidArgumentException;
use BadFunctionCallException;

/**
 * Collection Object
 */
class Collection extends ArrayObject implements FormatInterface
{
    /**
     * Determine the allowed type(s) in collection
     * @var array|string
     */
    protected array|string $_dataTypes = 'string';

    /**
     * @param  array  $array
     */
    public function __construct(array $array = [])
    {
        foreach ($array as $i => $value) {
            $array[$i] = $this->getValueFormated($value);
        }
        parent::__construct($array);
    }

    /**
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     * @throws InvalidArgumentException
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        parent::offsetSet($key, $this->getValueFormated($value));
    }

    /**
     * Alis to get an index of a collection
     * @param  int  $key
     * @return mixed
     */
    public function get(int $key): mixed
    {
        return parent::offsetGet($key);
    }

    /**
     * @param $value
     * @return void
     */
    public function append($value): void
    {
        parent::append($this->getValueFormated($value));
    }

    /**
     * Logic to determine the class to instance from value
     * @param  array  $value
     * @return FormatInterface
     * @throws BadFunctionCallException
     */
    protected function dataClassLogic(array $value): FormatInterface
    {
        // only one type is allowed, so set it
        if (is_string($this->_dataTypes)) {
            $class = $this->_dataTypes;
        } else {
            // the logic must be implanted in the parent class
            throw new BadFunctionCallException("A logic must be implanted to determine the class to instance");
        }
        return new $class($value);
    }

    /**
     * Format collection to Array
     * @return array
     */
    public function toArray(): array
    {
        $return = [];
        foreach ($this->getIterator() as $value) {
            if (is_object($value)) {
                if ($value instanceof FormatInterface) {
                    $return[] = $value->toArray();
                } else {
                    $return[] = (array) $value;
                }
            } else {
                $return[] = $value;
            }
        }
        return $return;
    }

    /**
     * Format collection to JSON
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Format collection to JSON
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * @param  mixed  $value
     * @return FormatInterface|mixed
     */
    protected function getValueFormated(mixed $value): mixed
    {
        if ($this->_dataTypes) {
            $type = gettype($value);
            if ($type === 'array') {
                $value = $this->dataClassLogic($value);
            } else {
                if (is_string($this->_dataTypes)) {
                    if (
                        ($type === "object" && get_class($value) !== $this->_dataTypes) ||
                        ($type !== "object" && $type !== $this->_dataTypes)
                    ) {
                        throw new InvalidArgumentException("Must be of type ".$this->_dataTypes);
                    }
                } elseif (is_array($this->_dataTypes)) {
                    if (
                        ($type === "object" && !in_array(get_class($value), $this->_dataTypes)) ||
                        ($type !== "object" && !in_array($type, $this->_dataTypes))
                    ) {
                        throw new InvalidArgumentException("Must be a type in ".implode(', ', $this->_dataTypes));
                    }
                }
            }
        }
        return $value;
    }

}
