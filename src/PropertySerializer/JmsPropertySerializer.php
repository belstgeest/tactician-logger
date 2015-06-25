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
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }
   
    public function encode($command)
    {
        return $this->serializer->serialize($command, $this->format);
    }
    /**
     * 
     * @param string $format
     * @return JmsPropertySerializer
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

}
