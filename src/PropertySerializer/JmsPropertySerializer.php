<?php

namespace League\Tactician\Logger\PropertySerializer;

use JMS\Serializer\Serializer;

/**
 * Simple implementation of JMS serializer
 *
 */
class JmsPropertySerializer implements PropertySerializer
{

    /**
     *
     * @var Serializer
     */
    protected $serializer;

    /**
     * Format
     * @var string
     */
    protected $format;

    /**
     *
     * @param Serializer $serializer
     * @param string $format
     */
    public function __construct(Serializer $serializer, $format = 'json')
    {
        $this->serializer = $serializer;
        $this->format = $format;
    }

    public function encode($command)
    {
        return $this->serializer->serialize($command, $this->format);
    }

}
