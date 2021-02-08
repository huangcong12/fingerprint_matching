<?php

namespace FingerprintMatching\Fgtit;


use FingerprintMatching\DriverInterface;

/**
 * FGTIT 指纹比对驱动
 * 参考：https://www.php.net/manual/zh/ffi.examples-complete.php
 */
class Driver implements DriverInterface
{
	/**
	 * 安全模式 通过的比对比分
	 *
	 * @var int
	 */
	const SAFE_SCOPE = 80;

	/**
	 * 正常模式 通过的比对比分
	 *
	 * @var int
	 */
	const NORMAL_SCOPE = 60;

	/**
	 * 通过比分
	 *
	 * @var int
	 */
	public $licensedScope = self::NORMAL_SCOPE;

	/**
	 * 类库操作对象
	 *
	 * @var
	 */
	private static $ffi = null;

	public function __construct()
	{
		if (is_null(self::$ffi)) {
			self::$ffi = \FFI::cdef("
			int UserMatch(unsigned char *Src,unsigned char *Dst,unsigned char SecuLevel,int *MatchScore);
			int Match2Fp(unsigned char *Src,unsigned char *Dst);
		", __DIR__ . "/libOpticMatch.so");
		}
	}

	/**
	 * 一对一比对
	 *
	 * @param $fingerFirst string 指纹 1
	 * @param $fingerSecond string 指纹 2
	 * @return bool true/false
	 */
	public function comparedOne(string $fingerFirst, string $fingerSecond): bool
	{
		// 1.转换指纹数据
		$fingerFirstByte = $this->getBytes(base64_decode($fingerFirst));
		$fingerSecondByte = $this->getBytes(base64_decode($fingerSecond));

		// 2.调用比对类
		$score = self::$ffi->Match2Fp($this->phpArrToCChar($fingerFirstByte), $this->phpArrToCChar($fingerSecondByte));

		return $score >= $this->licensedScope;
	}

	/**
	 * 一对多指纹比对
	 * 从给的指纹数组里比对，看是否 $fingerFirst 存在指纹数组里
	 *
	 * @param string $fingerNow string 指纹 1
	 * @param array $fingerArr array 指纹数组
	 * @return string 返回 $fingerNow 在 $fingerArr 里的 key
	 */
	public function comparedMany(string $fingerNow, array $fingerArr)
	{
		// 1.转换指纹数据
		$fingerNowByte = $this->getBytes(base64_decode($fingerNow));

		// 2.逐一比对
		foreach ($fingerArr as $key => $value) {
			$fingerValue = $this->getBytes(base64_decode($value));
			$score = self::$ffi->Match2Fp($this->phpArrToCChar($fingerNowByte), $this->phpArrToCChar($fingerValue));

			if ($score >= $this->licensedScope) {
				return $key;
			}
		}

		return false;
	}


	/**
	 * 设置 通过分数
	 *
	 * @param $scope
	 * @return $this
	 */
	public function setScope($scope)
	{
		$this->licensedScope = $scope;
		return $this;
	}

	/**
	 * 设置 安全模式
	 * 安全模式下，比分高于 80 才可通过
	 *
	 * @return $this
	 */
	public function setUpSafeMode()
	{
		$this->setScope(self::SAFE_SCOPE);
		return $this;
	}

	/**
	 * 把 php 数组的数据存到 c 的 unsigned char 数组里
	 *
	 * @param $arr
	 * @return mixed
	 */
	protected function phpArrToCChar($arr)
	{
		$cChar = \FFI::new("unsigned char [" . count($arr) . "]");
		foreach ($arr as $key => $value) {
			$cChar[$key] = $arr[$key];
		}

		return $cChar;
	}

	/**
	 * 字符串转出 byte 类型数组
	 *
	 * @param $string
	 * @return array
	 */
	protected function getBytes($string)
	{
		$bytes = array();
		for ($i = 0, $iMax = strlen($string); $i < $iMax; $i++) {
			$bytes[] = ord($string[$i]);
		}
		return $bytes;
	}
}