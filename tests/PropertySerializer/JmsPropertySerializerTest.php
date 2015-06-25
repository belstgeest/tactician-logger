<?php

namespace League\Tactician\Logger\Tests\PropertySerializer;

use JMS\Serializer\SerializerBuilder;
use League\Tactician\Logger\PropertySerializer\JmsPropertySerializer;
use League\Tactician\Logger\Tests\Fixtures\RegisterUserCommand;

/**
 * JmsPropertySerializerTest
 *
 */
class JmsPropertySerializerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var SerializerBuilder
     */
    private $builder;

    protected function setUp()
    {
        $this->builder = new SerializerBuilder();
    }

    public function testCommandPropertiesCanBeSerializedAsJson()
    {
        $serializer = new JmsPropertySerializer($this->builder->build(), 'json');
        $command   = new RegisterUserCommand();
        $createdAt = $command->createdAt->format(\DateTime::ISO8601);
        $expected  = '{'
            . '"name":"Alice",'
            . '"email_address":"alice@example.org",'
            . '"age":30.5,'
            . '"created_at":"' . $createdAt . '",'
            . '"options":{"foo":"thing 1","bar":"thing 2"}'
            . '}';
        $this->assertJsonStringEqualsJsonString($expected, $serializer->encode($command));
    }

    public function testCommandPropertiesCanBeSerializedAsXml()
    {
        $serializer = new JmsPropertySerializer($this->builder->build(), 'xml');
        $command = new RegisterUserCommand();
        $command->createdAt = new \DateTime('2015-06-25T21:22:18+0200');

        $expected  = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<result>
  <name><![CDATA[Alice]]></name>
  <email_address><![CDATA[alice@example.org]]></email_address>
  <age>30.5</age>
  <created_at>2015-06-25T21:22:18+0200</created_at>
  <options>
     <entry>thing 1</entry>
     <entry>thing 2</entry>
  </options>
</result>
EOF;
        $this->assertXmlStringEqualsXmlString($expected, $serializer->encode($command));
    }

    public function testCommandPropertiesCanBeSerializedAsYaml()
    {
        $serializer = new JmsPropertySerializer($this->builder->build(), 'yml');
        $command = new RegisterUserCommand();
        $command->createdAt = new \DateTime('2015-06-25T21:22:18+0200');

        $expected  = <<<EOF
name: Alice
email_address: alice@example.org
age: 30.5
created_at: '2015-06-25T21:22:18+0200'
options:
    foo: 'thing 1'
    bar: 'thing 2'

EOF;
        $this->assertEquals($expected, $serializer->encode($command));
    }

}
