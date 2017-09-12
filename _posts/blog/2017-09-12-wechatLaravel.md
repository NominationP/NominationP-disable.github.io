---
layout: article
title: "EasyWechat Laravel Docker 遇到的坑"
category: blog
tag:
- openSource

#excerpt:
toc: flase
image:
#  feature:
    teaser: /blog/2017.06.15/image.jpg
#  thumb:
date:   2017-09-11 10:44
modified: 2017-09-11 10:44
---



### 端口问题，必须是80端口

我用的docker不是用的80端口，可以用NGINX反向代理

/etc/nginx/conf.d/default.conf （根据自己的路径）

以下：docker用的是8080端口，但面向用户的是80端口，通过proxy_pass转到8080端口

```
location ~* ^/XXX/(.*) {
		resolver 8.8.8.8;
        proxy_set_header  X-Real-IP  $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_pass http://XXXXXXXXX:8080/$1$is_args$args;
   }
```



### Laravel问题

版本：5.4

需要在 app/Http/Middleware/VerifyCsrfToken.php 中添加：

我之前写成 /server/* 和自己的路径不匹配，卡在这里好长时间

```
<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [	
         '/server', //此处添加根据route来写
    ];
}
```

```
Route::any("/server", 'Wechat@server')->name('server');
```



### 重点来了，为什么卡在第二步很长时间：laravel日志中竟然没有验证失败的记录！！

经过排查

发现在 app/Exceptions/Handler.php 的 dontReport 这个属性中

竟然是忽略此类信息，然后我就都注释掉了。。。。。5.5版本是没有的

```
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,             //这行就是关键，此类错误不计入日志
        \Illuminate\Validation\ValidationException::class,
    ];
```






