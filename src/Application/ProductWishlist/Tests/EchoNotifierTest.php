<?php

namespace Develop\Business\Application\ProductWishlist\Tests;

use Develop\Business\Application\ProductWishlist\EchoNotifier;

class EchoNotifierTest extends \PHPUnit_Framework_TestCase
{
    public function testEchoSomeText()
    {
        $this->expectOutputString('Email: email@test.com, Message: message body' . PHP_EOL);
        $notifier = new EchoNotifier();
        $notifier->send('email@test.com', 'message body');
    }
}
