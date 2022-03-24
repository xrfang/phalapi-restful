
## PhalApi 2.x 扩展类库：基于FastRoute的快速路由

> 本仓库是`luyuanxun/phalapi-restful`的一个镜像，因为原仓库（https://github.com/luyuanxun/phalapi-restful）已经消失了。本仓库仅对原作的导入路径做了更改。以下为原作者的文档。

此扩展基于 [FastRoute](https://github.com/nikic/FastRoute) 实现，需要 **PHP 5.4.0** 及以上版本，快速实现完整restful api（与phalapi/fast-route不同，phalapi-restful支持 get post put delete）

## 安装

在项目的composer.json文件中，添加：

```
{
    "require": {
        "luyuanxun/phalapi-restful": "dev-master"
    }
}
```

配置好后，执行composer update更新操作即可。

## 配置

我们需要在 **./config/app.php** 配置文件中追加以下配置：
```php
	/**
	 * 扩展类库 - 快速路由配置
	 */
    'FastRoute' => array(
         /**
          * 格式：array($method, $routePattern, $handler)
          *
          * @param string/array $method 允许的HTTP请求方式，可以为：GET/POST/HEAD/DELETE 等
          * @param string $routePattern 路由的正则表达式
          * @param string $handler 对应PhalApi中接口服务名称，即：?service=$handler
          */
        'routes' => array(
            array('GET', '/site/index', 'Site.Index'),
            array('GET', '/examples/curd/get/{id:\d}', 'Examples_CURD.Get'),
        ),
    ),


```

## nginx的协助配置（省略index.php）
如果是使用nginx的情况下，需要添加以下配置：

```
    # 最终交由index.php文件处理
    location /{
    	try_files $uri $uri/ /index.php?$uri&$args;
    }

    # 匹配未找到的文件路径
    if (!-e $request_filename) {
        rewrite ^/(.*)$ /index.php/$1 last;
    }
```
然后重启nginx。


## 入门使用
### (1)入口注册在di.php追加配置
```php

/**
 * RESTFUL API
 */

$di->request = new PhalApi\Restful\RestfulRequest();
$di->fastRoute = new PhalApi\Restful\Lite();
$di->fastRoute->dispatch();
```

### 扩展类库参考（参考开发拓展流程）
请访问 [phalapi/fast-route](https://github.com/phalapi/fast-route) ，查看phalapi官方说明。
