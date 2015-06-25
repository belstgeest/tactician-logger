<?php
namespace League\Tactician\Logger\PropertySerializer;

use ReflectionClass;

/**
 * Quick'n'dirty property serializer that logs the first level properties
 *
 * This is done in an extremely inefficient manner, so please never use this in
 * a production context, only for local debugging.
 */
class SimplePropertySerializer implements PropertySerializer
{
    /**
     * @param object $command
     * @return string
     */
    public function encode($command)
    {
        $reflectionClass = new ReflectionClass(get_class($command));

        $properties = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $properties[$property->getName()] = $this->formatValue($property->getValue($command));
        }

        return json_encode($properties);
    }

    /**
     * Return the given (property) value as a descriptive string
     *
     * @param mixed $value Can be literally anything
     * @return string
     */
    protected function formatValue($value)
    {
        switch (gettype($value)) {
            case 'object':
                return 'object(' . get_class($value) . ')';
            case 'array':
                return '*array*';
            case 'NULL':
                return '*null*';
            default:
                return $value;
        }
    }
}
