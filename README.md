# CryptoKit

This package is part of Fruit Framework.

CryptoKit abstracts crypter, which encrypt and decrypt your data, and hash, which generates hashsum.

CryptoKit is still under development, not usable now.

## Synopsis

### Encrypt and decrypt some data

```php
$data = 'hello world';
$crypter = new Fruit\CryptoKit\ROT13;

$encrypted = $crypter->encrypt($data);
$data = $crypter->decrypt($encrypted);
```

### Encrypt or decrypt via stream

```php
stream_filter_register('myfilter', 'Fruit\CryptoKit\CryptoFilter');
$f = fopen('myfile.txt', 'r');
stream_filter_append($f, 'myfilter', STREAM_FILTER_READ, [
	'crypter' => new Fruit\CryptoKit\ROT13,
	'crypt_type' => 'encrypt',
]);
$encrypted = stream_get_contents($f);
fclose($f);
```

### Compute hashsum

```php
$h = new Fruit\CryptoKit\Hash('md5');
$hashsum = $h->update($data)->sum();
```

### Compute hashsum via stream

```php
$f = fopen('myfile', 'r');
$h = new Fruit\CryptoKit\Hash('md5');
$hashsum = $h->updateStream($f)->sum();
fclose($f);
```

## License

Any version of MIT, GPL or LGPL.
