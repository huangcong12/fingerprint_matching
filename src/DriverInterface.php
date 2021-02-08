<?php

namespace FingerprintMatching;

interface DriverInterface
{
	/**
	 * 一对一比较
	 *
	 * @param string $fingerFirst 指纹 1
	 * @param string $fingerSecond 指纹 2
	 * @return bool 匹配：true；不匹配：false
	 */
	public function comparedOne(string $fingerFirst, string $fingerSecond): bool;

	/**
	 * 一对多比较，返回匹配到的数组 key
	 *
	 * @param string $fingerNow 需要匹配的指纹
	 * @param array $fingerArr 包含匹配指纹的指纹数组
	 * @return mixed 匹配：返回指纹数组里的 key，不匹配：false
	 */
	public function comparedMany(string $fingerNow, array $fingerArr);

}