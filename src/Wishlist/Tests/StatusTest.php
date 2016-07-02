<?php

namespace Develop\Business\Wishlist\Tests;

use Develop\Business\Wishlist\Exceptions\InvalidArgument;
use Develop\Business\Wishlist\Status;

class StatusTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateFromGivenStatus()
    {
        $status = Status::create(Status::PENDING);
        $this->assertEquals(Status::PENDING, (string) $status);
    }

    public function testShouldCreatePendingStatus()
    {
        $status = Status::pending();
        $this->assertEquals(Status::PENDING, (string) $status);
    }

    public function testShouldCreateSentStatus()
    {
        $status = Status::sent();
        $this->assertEquals(Status::SENT, (string) $status);
    }

    public function testTryingToCreateFromUnknownStatus()
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage('The status unknown is not valid. Only supports only the following status: P, S');

        Status::create('unknown');
    }

    public function testCheckStatusIsDifferent()
    {
        $status = Status::pending();
        $this->assertFalse($status->is(Status::SENT));
    }
}
