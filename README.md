# PHP 指纹比对扩展包

原理是通过 PHP7.4 的 FFI 功能调用 .so 包提供的比对方法。

[![License](https://poser.pugx.org/w7corp/easywechat/license)](https://packagist.org/packages/w7corp/easywechat)


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

```
$driver = FingerPrintServer::instance()->loadDriver(\Akong\FingerprintMatching\DriverNameServer::FGTIT)
$driver->comparedOne("{$code1}", "{$code2}");
```

### 1 对 N 比对
返回匹配的数组 `key`

```
$driver = FingerPrintServer::instance()->loadDriver(\Akong\FingerprintMatching\DriverNameServer::FGTIT)
$driver->comparedMany("{$code1}", "{$codeArr}");
```

## 高级方式

### 严格模式

将通过比分调整为 80 分，默认是`一般模式` 60 分。

```
$driver->setUpSafeMode();
```

### 自定义通过比分

如果`一般模式（60）`和`严格模式（80）`不满足，可单独设置通过分数

```
$driver->setScope("{通过分数}")；
```