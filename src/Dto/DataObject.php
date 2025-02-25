<?php

namespace Board3r\MistralSdk\Dto;

use BadFunctionCallException;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionProperty;
use ReflectionUnionType;

use function Board3r\MistralSdk\Helpers\CamelCase;
use function Board3r\MistralSdk\Helpers\PascalCase;
use function Board3r\MistralSdk\Helpers\SnakeCase;

/**
 * Property Object
 */
class DataObject implements FormatInterface
{
    /**
     * Allowed types for properties
     * @var array
     */
    protected array $_properties;

    /**
     * Allowed class for properties
     * @var array
     */
    protected array $_propertiesClass;
    /**
     * Alias of some cast
     * @var string[]
     */
    protected array $_alias = ['integer' => 'int', 'boolean' => 'bool', 'double' => 'float'];
    /**
     * List of properties to force null value in array format
     * @var array
     */
    protected array $_forceNull = [];

    /**
     * Set raw data to object
     * The array properties can be set in
     * @param  array  $data
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $prop => $value) {
            if ($this->allowedProperty($prop)) {
                $prop = CamelCase($prop);
                $this->{'set'.PascalCase($prop)}($value);
            }
        }
    }

    /**
     * Magic Setters and Getter
     * @param $method
     * @param $args
     * @return $this|DataObject|bool
     * @throws InvalidArgumentException
     */
    public function __call($method, $args)
    {
        $prop = CamelCase(substr($method, 3));
        if ($this->allowedProperty($prop)) {
            switch (substr($method, 0, 3)) {
                case 'get':
                    return $this->dataGet($prop);
                case 'set':
                    return $this->dataSet($prop, $args[0]);
                case 'uns':
                    return $this->dataUnset($prop);
                case 'has':
                    return isset($this->{$prop});
            }
        }
        throw new InvalidArgumentException(
            sprintf('Invalid method %s::%s(%s)', get_class($this), $method, print_r($args, true))
        );
    }

    /**
     * Set and return allowed properties and types by Reflection
     * @return array
     */
    protected function properties(): array
    {
        if (!isset($this->_properties)) {
            $this->_properties = [];
            $this->_propertiesClass = [];
            $reflect = new ReflectionClass($this);
            $props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
            foreach ($props as $prop) {
                $this->_properties[$prop->getName()] = [];
                $types = $prop->getType() instanceof ReflectionUnionType ? $prop->getType()->getTypes() : [$prop->getType()];
                foreach ($types as $type) {
                    // classic type
                    if ($type->isBuiltin()) {
                        $this->_properties[$prop->getName()][] = $this->dataTypeAlias($type->getName());
                        // a float can have integer type
                        if ($type->getName() == 'float') {
                            $this->_properties[$prop->getName()][] = 'int';
                        }
                    } else {
                        // object type
                        if (!isset($this->_propertiesClass[$prop->getName()])) {
                            $this->_propertiesClass[$prop->getName()] = [];
                        }
                        $this->_propertiesClass[$prop->getName()][] = $type->getName();
                    }
                }
                // add null allowed
                if ($prop->getType()->allowsNull()) {
                    $this->_properties[$prop->getName()][] = "null";
                }
                $this->_properties[$prop->getName()] = array_unique($this->_properties[$prop->getName()]);
            }
        }
        return $this->_properties;
    }

    /**
     * List of classes allowed by property
     * @return array
     */
    protected function propertiesClass(): array
    {
        if (!isset($this->_propertiesClass)) {
            $this->properties();
        }
        return $this->_propertiesClass;
    }

    /**
     * Check is the property is allowed
     * @param  string  $prop
     * @return bool
     */
    public function allowedProperty(string $prop): bool
    {
        $prop = CamelCase($prop);
        return array_key_exists($prop, $this->properties());
    }

    /**
     * Return classic types allowed by property
     * @param  string  $prop
     * @return array
     */
    protected function propertyTypes(string $prop): array
    {
        return $this->allowedProperty($prop) ? $this->properties()[$prop] : [];
    }

    /**
     * Return classes allowed by property
     * @param  string  $prop
     * @return array
     */
    protected function propertyClass(string $prop): array
    {
        return $this->allowedProperty($prop) ? ($this->propertiesClass()[$prop] ?? []) : [];
    }

    /**
     * Check if a type is allowed for a property
     * @param  string  $prop
     * @param  string  $type
     * @return bool
     */
    protected function allowedPropertyType(string $prop, string $type): bool
    {
        return in_array($type, $this->propertyTypes($prop));
    }

    /**
     * Check if a class is allowed for a property
     * @param  string  $prop
     * @param  string  $type
     * @return bool
     */
    protected function allowedPropertyClass(string $prop, string $type): bool
    {
        return in_array($type, $this->propertyClass($prop));
    }

    /**
     * Get the type of data
     * @param  mixed  $data
     * @return string
     */
    protected function dataType(mixed $data): string
    {
        return $this->dataTypeAlias(gettype($data));
    }

    /**
     * In some case type needs to be translated by an alias
     * @param $typeName
     * @return string
     */
    protected function dataTypeAlias($typeName): string
    {
        return $this->_alias[$typeName] ?? $typeName;
    }

    /**
     * Set the data in the current class
     * @param  string  $prop
     * @param  mixed  $value
     * @return $this
     * @throws InvalidArgumentException
     */
    protected function dataSet(string $prop, mixed $value): static
    {
        if (isset($value)) {
            $type = $this->dataType($value);
            $this->allowedPropertyType($prop, $type);
            // bind it directly if the value is allowed
            if ($this->allowedPropertyType($prop, $type) || ($this->allowedPropertyClass($prop, $type) && class_exists($type))) {
                $this->{$prop} = $value;
                return $this;
            } elseif ($type == 'array') {
                $classes = $this->propertyClass($prop);
                if ($classes) {
                    $this->{$prop} = $this->dataClassLogic($prop, $value, $classes);
                    return $this;
                }
            }
        } elseif ($this->allowedPropertyType($prop, "null")) {
            $this->{$prop} = null;
            return $this;
        }
        throw new InvalidArgumentException(sprintf('Invalid data %s => %s', $prop, print_r($value, true)));
    }

    /**
     * Set the data in the current class
     * @param  string  $prop
     * @return $this
     * @throws InvalidArgumentException
     */
    protected function dataGet(string $prop): mixed
    {
        if (!isset($this->{$prop}) && $classes = $this->propertyClass($prop)) {
            $this->{$prop} = new $classes[0]();
        }
        return $this->{$prop} ?? null;
    }

    /**
     * @param  string  $prop
     * @param  mixed  $value
     * @param  array  $classes
     * @return FormatInterface
     * @throws BadFunctionCallException
     */
    protected function dataClassLogic(string $prop, mixed $value, array $classes): FormatInterface
    {
        // only one type is allowed, so set it
        if (count($classes) === 1) {
            $class = current($classes);
        } else {
            // the logic must be implanted in the parent class
            throw new BadFunctionCallException("A logic must be implanted to determine the class to instance %s => %s", $prop, print_r($classes, true));
        }
        return new $class($value);
    }

    /**
     * Unset a property
     * @param  string  $prop
     * @return $this
     */
    protected function dataUnset(string $prop): static
    {
        if ($this->allowedProperty($prop)) {
            unset($this->{$prop});
        }
        return $this;
    }

    /**
     * Convert current object into an array
     * @return array
     */
    public function toArray(): array
    {
        $props = array_keys($this->properties());
        $return = [];
        foreach ($props as $prop) {
            $propOut = SnakeCase($prop);
            if (isset($this->{$prop})) {
                if (is_object($this->{$prop})) {
                    $return[$propOut] = $this->{$prop} instanceof FormatInterface ? $this->{$prop}->toArray() : (array) $this->{$prop};
                } else {
                    $return[$propOut] = $this->{$prop};
                }
            } elseif (in_array($prop, $this->_forceNull)) {
                $return[$propOut] = null;
            }
        }
        return $return;
    }

    /**
     * Convert the object into JSON
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Convert the object into JSON
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

}
