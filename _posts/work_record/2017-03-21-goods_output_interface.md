---
layout: pureread
title: "goods output interface"
modified: 2017.03.23
category: work_record
tag:
- work

#excerpt:
toc: true
image:
#  feature:
    teaser: /teaser/gil.jpg
#  thumb:
date: 2017-03-23
---


### 接口详情

#### 公共属性

| 参数名称      | 意义  |
|:------------- |:-----|
| sign      | 加密字符串 |
| username  | 用户名 |
| password | 密码|
| resultCode      | 状态码 （2XX：成功 3XX：重定向 4XX：客户端错误 5XX：服务器错误 ）|
| success     | 是否成功 （1：成功 0：失败） |
| resultMessage     | 返回信息 |



#### `大类接口`

- URL: https://shop.shanghai.com.cn/api/category
- HTTPS请求方式：POST
- 请求参数

| 参数名称        | 参数选项| 意义  |
|:------------- |:----|:-----|
| Sign     | 必须 | 公钥加密字符串 |

- 返回结果参数

| 参数名称      | 意义  |
|:------------- |:-----|
| first_level     | 一级目录 |
| second_level      | 二级目录 |
| third_level     | 三级目录 |
| cat_id      | 分类ID |
| cat_name      | 分类名称 |
| parent_id     | 这个分类的上级分类ID（0表示没有上级） |


- 请求实例

{% highlight json %}
{
  "Sign":"f43f3efr4f4f3667yyrg5h",
}
{% endhighlight %}

- 返回结果
{% highlight json %}
```
{
  "result":{
        "resultCode"    :null,
        "success"       :false,
        "resultMessage" :"失败原因"
    },
  "detail":{

    "first_level":[
        {
          "cat_id" : "1",
          "cat_name" : "食品",
          "parent_id" : "0"
        },
        {
          "cat_id" : "2",
          "cat_name" : "电脑",
          "parent_id" : "0"
        }
      ],

    "second_level":[
        {
          "cat_id" : "14",
          "cat_name" : "食品营养",
          "parent_id" : "1"
        },
        {
          "cat_id" : "58",
          "cat_name" : "电脑文具",
          "parent_id" : "2"
        }

      ],

      "thrid_level":[
        {
          "cat_id" : "21",
          "cat_name" : "休闲食品",
          "parent_id" : "14"
        },
        {
          "cat_id" : "61",
          "cat_name" : "外设产品",
          "parent_id" : "58"
        }

      ]
  }
}
{% endhighlight %}




#### `商品池接口`

- URL: https://shop.shanghai.com.cn/api/goods_pool
- HTTPS请求方式：POST
- 请求参数

| 参数名称        | 参数选项| 意义|
|:------------- |:----|:-----|
| Sign    | 必须 | 公钥加密字符串 |
| cat_id  | 必须 | 必须为一级分类 |

- 返回结果参数

| 参数名称      | 意义  |
|:------------- |:-----|
| cat_id      | 大类ID，一级分类 |
| goods_id      | 商品ID，返回该大类下对应的所有商品ID |



- 请求实例

{% highlight json %}
{
  "Sign":"f43f3efr4f4f3667yyrg5h",
  "catId": "1"
}
{% endhighlight %}

- 返回结果
{% highlight json %}
{
  "result":{
        "resultCode"    :null,
        "success"       :false,
        "resultMessage" :"失败原因"
    },
  "detail":{
    "cat_id" : "1",
    "list":[
    {"goods_id" : "1"},
        {"goods_id" : "2"},
        {"goods_id" : "3"},
        {"goods_id" : "4"},
        {"goods_id" : "5"}
    ]
  }
}
{% endhighlight %}


#### `商品详情接口`

- URL: https://shop.shanghai.com.cn/api/goods_detail
- HTTPS请求方式：POST
- 请求参数

| 参数名称        | 参数选项| 意义  |
|:------------- |:----|:-----|
| Sign     | 必须 | 公钥加密字符串 |
| goods_id      | 必须 | 商品编号，只支持单个查询|

- 返回结果参数

| 参数名称      | 意义  |
|:------------- |:-----|
| goods_id      | 商品ID |
| goods_name      | 商品名称|
| cat_id      | 分类ID ||
| brand_id      | 商品对应品牌名称 |
| goods_number      | 库存 |
| is_on_sale      | 是否上架（1：上架 0：下架） |
| goods_weight      | 重量 |
| market_price      | 市场价 |
| shop_price      | 售价 |
| goods_thumb     | 商品缩略图 |
| from      | 来源 （JD：京东，SN：苏宁，YHD：一号店） |
| goods_desc      | 商品描述 |
| img_url     | 商品详情图，在查看商品详情时看到的图片，一个商品有多个|
| is_primary      | 一个商品只有一个主图（1：主图 0：非主图 ）|



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
        "resultCode"    :503,
        "success"       :false,
        "resultMessage" :"失败原因"
    },
  "detail":{
        "goods_id" : "1",
        "goods_name"   : "洽洽 大片西瓜子话梅味 大包装量贩500g/袋",
        "cat_id" : "23",
        "brand_id" : "10",
        "goods_number" : "302",
        "is_on_sale" : "1",
        "goods_weight" : "0.510",
        "market_price"  : "29.59",
        "shop_price" : "26.90",
        "goods_thumb" : "http://img13.360buyimg.com/n0/jfs/t1966/36/1076140103.jpg",
        "from" : "JD",
        "status" : "1",
        "goods_desc"   : "XXXXXXXX",
        "gallery" :[
          {
            "goods_id":"1",
            "img_url" : "www.img0.com",
            "is_primary": "1"
          },
          {
            "goods_id":"1",
            "img_url" : "www.img2.com",
            "is_primary": "0"
          },
          {
            "goods_id":"1",
            "img_url" : "www.img3.com",
            "is_primary": "0"
          }
        ]
        }
}
{% endhighlight %}


#### `商品价格/库存/状态 接口（批量）`

- URL: https://shop.shanghai.com.cn/api/goods_status
- HTTPS请求方式：POST
- 请求参数

| 参数名称        | 参数选项| 意义  |
|:------------- |:----|:-----|
| Sign     | 必须 | 公钥加密字符串 |
| goods_id     | 必须 | 商品编号，请以，分割。例如：J_129408,J_129409(最高支持80个商品)|

- 返回结果参数

| 参数名称      | 意义  |
|:------------- |:-----|
| goods_id      | 商品ID |
| market_price      | 市场价 |
| shop_price      | 售价 |
| goods_number    | 库存 |
| is_on_sale      | 上下架状态 （1：上架 0：下架）|

- 请求实例

{% highlight json %}
{
  "Sign":"f43f3efr4f4f3667yyrg5h",
  "sku" :"1023433,2003313"
}
{% endhighlight %}

- 返回结果
{% highlight json %}
{
  "result":{
        "resultCode"    :null,
        "success"       :false,
        "resultMessage" :"失败原因"
    },
  "detail":[
        {
          "goods_id" : "1023433",
          "market_price" : "32.4",
          "shop_price" : "30",
          "goods_number" : "123",
          "is_on_sale" : "1"
        },
        {
          "goods_id" : "2003313",
          "market_price" : "22.4",
          "shop_price" : "18.2",
          "goods_number" : "1230",
          "is_on_sale" : "0"      ]

}
{% endhighlight %}







#### `新增商品接口`

- URL: https://shop.shanghai.com.cn/api/goods_new_add
- HTTPS请求方式：POST
- 请求参数

| 参数名称        | 参数选项| 意义  |
|:------------- |:----|:-----|
| Sign        | 必须 | 公钥加密字符串 |
| begin_goods_id | 必须 | 必须是一个正确的商品ID（所有商品的商品ID不一定连续）|
| number    | 必须 | 最高支持2000个商品|

- 返回结果参数

| 参数名称      | 意义  |
|:------------- |:-----|
| begin_goods_id      | 本次搜索的起始商品ID |
| end_goods_id      | 本次搜索商品的终止ID |
| goods_number      | 本次搜索商品的数量 |


- 请求实例
{% highlight json %}
{
  "Sign":"f43f3efr4f4f3667yyrg5h",
  "begin_goods_id" :"1023",
  "number" : "3"
}
{% endhighlight %}

- 返回结果
{% highlight json %}
{
  "result":{
        "resultCode"    :null,
        "success"       :false,
        "resultMessage" :"失败原因"
    },
  "detail":{
    "begin_goods_id" : "1023",
    "end_goods_id" : "1035",
    "goods_number" : 3,
    "list":[
    {"goods_id" : "1023"},
        {"goods_id" : "1034"},
        {"goods_id" : "1035"}
    ]
  }


}
{% endhighlight %}




