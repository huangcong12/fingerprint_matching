<?php

namespace Akong\FingerprintMatching\Tests;

use Akong\FingerprintMatching\DriverNameServer;
use Akong\FingerprintMatching\Fgtit\Driver;
use Akong\FingerprintMatching\FingerPrintServer;

class FingerPrintServerTest extends \PHPUnit\Framework\TestCase
{
	public function testInstance()
	{
		// 1.实例化
		$instance = FingerPrintServer::instance();
		// 1.1.新实例化
		$instance2 = FingerPrintServer::instance(true);

		// 2.都是 FingerPrintServer 的对象
		$this->assertInstanceOf(
			FingerPrintServer::class,
			$instance,
		);
		$this->assertInstanceOf(
			FingerPrintServer::class,
			$instance2
		);

		// 3.但是他们两个不相等
		$this->assertNotSame($instance, $instance2);
	}

	public function testLoadDriver()
	{
		// 1.载入一个存在的驱动 fgtit
		$this->assertInstanceOf(
			Driver::class,
			FingerPrintServer::instance()->loadDriver(DriverNameServer::FGTIT),
		);

		// 2.载入一个不存在的驱动
		$this->assertFalse(FingerPrintServer::instance()->loadDriver('not_exists_driver_name'));
	}
}