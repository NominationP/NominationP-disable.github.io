---
layout: pureread
title: "goods output"
modified: 2017.03.13
category: work_record
tag:
- work

#excerpt:
toc: false
image:
#  feature:
    teaser: /teaser/gil.jpg
#  thumb:
date: 2017-03-13
---


##### 接口详情



`商品详情接口`

- URL: https://shop.shanghai.com.cn/api/goods_detail
- HTTPS请求方式：POST
- 请求参数

| 参数名称        | 参数选项| 意义  |
|:------------- |:----|:-----|
| Sign     | 必须 | 公钥加密字符串 |
| sku      | 必须 | 商品编号，只支持单个查询|

- 请求实例

{% highlight json %}
{
    "Sign":"f43f3efr4f4f3667yyrg5h",
    "sku" :"304844"
}
{% endhighlight %}

- 返回结果

{% highlight json %}
{
    "result":{
                "resultCode"    :400,
                "success"       :false,
                "resultMessage" :"失败原因"
            },
    "detail":{
                "sku"    : "1023433",
                "name"   : "XXXXXXXX",
                "number" : "201",
                "weight" : "1.02",
                "price"  : "20.4",
                "img"    : "https://www.shop.shanghai.com.cn/api/graph/...",
                "status" : "1",
                "desc"   : "XXXXXXXX",
            }
}
{% endhighlight %}

