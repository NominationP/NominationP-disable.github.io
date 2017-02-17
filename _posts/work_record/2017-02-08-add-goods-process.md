---
layout: pureread
title: "add goods process"
modified: 2017.02.13
categories: work_record
#excerpt:
toc: false
image:
#  feature:
    teaser: /teaser/gil.jpg
#  thumb:
date: 2017-02-08T15:15:15+08:00
---

>add goods process

# goods


## process

#### 将京东，苏宁，一号店商品导入三合一
> (ecs_goods,ecs_brand_new,ecs_category,ecs_goods_gallery)

{% highlight c++ %}

- 三合一商品总数 : 32417
- jd : 26929  >>>>if (rate>=0.03 && fenxiao_price>0.1)
- sn : 3013
- yhd : 2457
- 没有图片信息的商品个数 : 4632 (暂把 is_on_sale = 0)
> /log/gallery_null.txt

{% endhighlight %}

#### 商品导入策略

> jd 商品的加入和价格的更新，通过俩个接口来实现
sn/yhd 扫描整个表，调用接口加入商品

##### jd

- 新增商品

![jd_add_goods_process](/images/work_log/add-flash_goods.png)

##### sn / yhd

- 调用接口

{% highlight c++ %}

//goods_info :sn/yhd商品信息(原来的商品库中取的信息)
include "add_new_goods.php";
$mt = new Meddle_trans;
$re = $mt->sn_add_new_goods($goods_info);
$re = $mt->yhd_add_new_goods($goods_info);
if($re == 1){
    print_r("ok"."\n");
}
{% endhighlight %}


#### detail

- 修改／增加了元宵的代码，所有修改地方加了注释 (//new add)

> addNewProduct.php
middle_db.php
update_price.php

- [add new code](https://github.com/NominationP/work_goods_sum/tree/report/add_new_goods){:target="_blank"}

> jd/sn/yhd add new goods , update_price
















