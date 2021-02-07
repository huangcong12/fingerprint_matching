<?php

namespace Akong\FingerprintMatching;


/**
 * 设备厂家名
 *
 * Class FingerPrintDriverName
 * @package akong\fingerprint_matching
 */
class DriverNameServer
{
	/**
	 * 命名规则：
	 * const {设备厂家} = '{厂家 so 文件的文件夹名字}';
	 */
	const FGTIT = 'Fgtit';

	/**
	 * 驱动列表
	 *
	 * @var string[]
	 */
	private static $driverList = [
		self::FGTIT
	];

	/**
	 * 判断指纹驱动是否存在
	 *
	 * @param $driver
	 * @return bool
	 */
	public static function exist($driver)
	{
		return in_array($driver, self::$driverList);
	}

	/**
	 * 获取当前驱动的路径
	 *
	 * @param $driver
	 * @return mixed
	 */
	public static function getDriver($driverName)
	{
		$className = __NAMESPACE__ . '\\' . $driverName . '\\Driver';

		if (!class_exists($className)) {
			return false;
		}

		return new $className();
	}
}