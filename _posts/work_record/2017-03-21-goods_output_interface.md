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

### 商品输出（商品部分）

#### 商品组合
需要一个**后台**来让运营方面组合各个不同属性的商品（以下是一些需要实现的需求）
>各个字段的搜索（比如：价格，颜色，分类，品牌），及时显示对应商品
>选择2个合适商品组合
>可以看到所有组合商品（以及销量情况）

商品组合刚开始需要运营去组合，日后可以根据运营提出的越来越清晰的条件，来用程序生成组合，配合人工审核，根据销量等其他因素来自动增加/删除组合商品。

-------

#### 需要提供的商品接口（以下商品默认都是组合商品）

##### 说明

所有接口的数据源，有俩种方式
- 数据库（所有接口的信息都来自此数据）
    - 商品接口，新增商品接口，商品详情，商品图片，分类，品牌
- 所属供应商的接口，对于那些实时性较高的操作（下单），需要获取最新消息，所以我们的接口需要调用相应供销商的接口来返回最新消息。
    - 商品价格，商品上下架状态


----------


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

