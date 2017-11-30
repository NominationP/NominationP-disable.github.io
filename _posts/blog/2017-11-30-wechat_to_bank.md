---
layout: article
title: "wechat_pay_bank 微信公众号转个人银行卡 "
category: blog
tag:
- wechat 

#excerpt:
toc: flase
image:
#  feature:
    teaser: /blog/2017.11.30/WeChat-Logo_中英_195.png
#  thumb:
date:   2017-11-30 15:54
modified: 2017-11-30 15:54
---



[github](https://github.com/NominationP/wechat_pay_bank)


### exp (遇到的坑):

- 仔细读文档
- https://pay.weixin.qq.com/wiki/tools/signverify/ 验证加密正确与否 (但我一直觉得这是个钓鱼网站.......)
- php 中 http_build_query() 函数 直接调用可能会有问题,需要一些参数来限制转义
- RSA中的公钥密钥是分格式(RSA公钥格式PKCS,PKCS),格式不对会出错,导致openssl_public_encrypt()函数报错:密钥无效
- php RSA openssl_public_encrypt()第四个参数padding 可设置填充模式,此接口中为OPENSSL_PKCS1_OAEP_PADDING
- php curl 中有证书参数
```
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch,CURLOPT_SSLCERT,CONFIG['cert_file']);
    curl_setopt($ch,CURLOPT_SSLKEY,CONFIG['key_file']);
    curl_setopt($ch,CURLOPT_CAINFO,CONFIG['ca_file']); 
    curl_setopt($ch, CURLOPT_SSLCERTPASSWD, CONFIG['op_pwd']);
```





