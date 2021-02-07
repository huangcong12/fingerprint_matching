<?php

namespace Akong\FingerprintMatching;

/**
 * 指纹操作服务类
 *
 * Class FingerPrintServer
 * @package internal\classes
 */
class FingerPrintServer
{
	/**
	 * 当前对象
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * 实例化当前对象
	 *
	 * @return object|static
	 */
	public static function instance($refresh = false)
	{
		if ($refresh || empty(self::$instance)) {
			self::$instance = new static();
		}

		return self::$instance;
	}

	/**
	 * 获取驱动对象
	 *
	 * @param string $driverName
	 * @throws \Exception
	 */
	public function loadDriver(string $driverName)
	{
		if (!DriverNameServer::exist($driverName)) {
			return false;
		}

		$driverInstance = DriverNameServer::getDriver($driverName);

		return $driverInstance;
	}
}