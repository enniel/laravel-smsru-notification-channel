<?php

namespace NotificationChannels\SmsRu\Test;

use NotificationChannels\SmsRu\SmsRuMessage;

class SmsRuMessageTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_construct_with_a_new_message()
    {
        $actual = SmsRuMessage::create('Foo');
        $this->assertEquals('Foo', $actual->text);
    }

    /** @test */
    public function it_can_set_new_content()
    {
        $actual = SmsRuMessage::create();
        $this->assertNull($actual->text);
        $actual->content('Bar');
        $this->assertEquals('Bar', $actual->text);
    }
}
