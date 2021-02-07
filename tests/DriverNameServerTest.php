<?php

namespace Akong\FingerprintMatching\Tests;


use Akong\FingerprintMatching\DriverNameServer;
use Akong\FingerprintMatching\Fgtit\Driver;
use PHPUnit\Framework\TestCase;

class DriverNameServerTest extends TestCase
{
	public function testExist()
	{
		// 1.存在的驱动名 fgtit
		$this->assertTrue(DriverNameServer::exist(DriverNameServer::FGTIT));
		// 2.不存在的驱动名
		$this->assertFalse(DriverNameServer::exist('not_exists_driver'));
	}

	public function testGetDriver()
	{
		// 1.存在的驱动名 fgtit
		$this->assertInstanceOf(
			Driver::class,
			DriverNameServer::getDriver(DriverNameServer::FGTIT)
		);

		// 2.不存在的驱动名
		$this->assertFalse(DriverNameServer::getDriver('not_exists_driver'));
	}
}