# PHP 指纹比对扩展包

原理是通过 PHP7.4 的 FFI 功能调用 .so 包提供的比对方法。

[![Latest Stable Version](https://poser.pugx.org/akong/fingerprint_matching/v)](//packagist.org/packages/akong/fingerprint_matching) 
[![Total Downloads](https://poser.pugx.org/akong/fingerprint_matching/downloads)](//packagist.org/packages/akong/fingerprint_matching) 
[![Latest Unstable Version](https://poser.pugx.org/akong/fingerprint_matching/v/unstable)](//packagist.org/packages/akong/fingerprint_matching) 
[![License](https://poser.pugx.org/akong/fingerprint_matching/license)](//packagist.org/packages/akong/fingerprint_matching)

# 支持的设备厂家

- [菲格特（FGTIT）](http://www.fgtit.com/PC/demo-server.html)

如果别家产品有提供 .so 文件，也可以参考此包实现比对功能。

# 安装
## 要求
- PHP >= 7.4
- FFI 扩展，且 `ffi.enable=true`

## 基于 composer 安装

```
composer require akong/fingerprint_matching
```

# 使用

## 基本方法

### 1 对 1 比对
比对成功返回：`true`，否则 `false`

```php
<?php
use Akong\FingerprintMatching\FingerPrintServer;
use Akong\FingerprintMatching\DriverNameServer;

$driver = FingerPrintServer::instance()->loadDriver(DriverNameServer::FGTIT);

$driver->comparedOne("{$code1}", "{$code2}");
```

### 1 对 N 比对
返回匹配的数组 `key`

```php
<?php
use Akong\FingerprintMatching\FingerPrintServer;
use Akong\FingerprintMatching\DriverNameServer;

$driver = FingerPrintServer::instance()->loadDriver(DriverNameServer::FGTIT);
$driver->comparedMany("{$code}", "{$codeArr}");
```

## 高级用法

### 严格模式

将通过比分调整为 80 分，默认是`一般模式` 60 分。

```php
<?php
...
$driver->setUpSafeMode();
...
```

### 自定义通过比分

如果`一般模式（60）`和`严格模式（80）`不满足，可单独设置通过分数

```php
<?php
...
$driver->setScope("{通过分数}");
...
```