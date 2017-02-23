---
layout: pureread
title: "add goods process"
modified: 2017.02.22
category: work_record
tag:
- work

#excerpt:
toc: false
image:
#  feature:
    teaser: /teaser/gil.jpg
#  thumb:
date: 2017-02-08T15:15:15+08:00
---

>add goods process

## process

#### 将京东，苏宁，一号店商品导入三合一
> (ecs_goods,ecs_brand_new,ecs_category,ecs_goods_gallery)

{% highlight c++ %}

- 三合一商品总数 : 32417
- jd : 26929  >>>>if (rate>=0.03 && fenxiao_price>0.1)
- sn : 3013  >>>>if (fenxiao_price != 0)
- yhd : 2457  >>>>if (fenxiao_price != 0)
- 没有图片信息的商品个数 : 4632 (暂把 is_on_sale = 0)
> /log/gallery_null.txt

{% endhighlight %}

#### 商品导入策略

> ###### 总览

>`jd 商品池推送API，价格推送API，上下架推送API，通过这3个接口定时更新JD商品库（原JD库，和3合1库）`

>`sn/yhd 扫描整个表，调用接口加入商品`

> ###### 详情 (只写出特殊情况)

-  **价格推送API**
    - 更新三合一商城时,如果利润率低于0.03，下架
-  **上下架推送API**
分为三种情况（按程序运行的先后顺序）
    - 在更新价格时，如果利润率低于0.03，下架
    - 更新推送接口商品的上下架
    - 更新三合一商城中所有下架的京东商品（考虑到价格改变自动下架的商品）


> ###### 存在问题

- jd没有充分利用接口
- jd接口重复调用
- jd扩展不方便 **（没有封装接口）**



##### jd更新商品流程图

- **新增商品**

![jd_add_goods_process](/images/work_log/2017-02-08/add-flash_goods.png)

- **update price && is_on_sale**

![jd_add_goods_process](/images/work_log/2017-02-08/update_is_on_sale.png)

##### sn / yhd

- 调用接口

{% highlight c++ %}

include "middle.php";
$mt = new Meddle_trans;
$mt->update_sn_goods();
$mt->update_yhd_goods();

{% endhighlight %}


#### detail

- 修改／增加了元宵的代码，所有修改地方加了注释 (//new add)

> addNewProduct.php
middle_db.php
update_price.php

- add new code

> jd/sn/yhd add new goods , update_price ,  update sale
















