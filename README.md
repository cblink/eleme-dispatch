<h1 align="center"> eleme-dispatch </h1>

<p align="center"> eleme dispatch SDK.</p>


## Installing

```shell
$ composer require cblink/eleme-dispatch -vvv
```

## Usage
配置项
$config = [
              'app_id' => 'app_id',
              'secret_key' => 'secret_key',
              'debug' => true,  // 测试联调
              'cache' =>  ''// 缓存
          ];
// delivery query         
(new ElemeDispatch($config))->dispatch->deliveryQuery($data);
// create eleme order
(new ElemeDispatch($config))->order->createOrder($data);

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/cblink/eleme-dispatch/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/cblink/eleme-dispatch/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT
