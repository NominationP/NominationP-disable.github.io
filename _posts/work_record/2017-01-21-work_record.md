---
layout: not_back
title: "Goods Catgory"
modified:
categories: work_record
#excerpt:
tags: [work]
toc: true
image:
#  feature:
    teaser: /teaser/float.jpg
#  thumb:
date: 2017-01-21T15:45:15+08:00
---
>Goods Catgory Record

## 工作进度

- php-java-bridge
    - <i class="fa fa-check-square-o"> shengchengtong
    - <i class="fa fa-check-square-o"> yufu(need to sub)
- 商品目录分类
    已经完成90％
    以下是我的整体思路，以及工作进度
    如果有不合适的地方，请指出



### 商品目录分类策略
- 对于已经存在的商品
    - 规则文件----->   程序 ----->  结果
- 对于新增商品
    - 程序-----> 结果

### 规则文件

- 京东三级目录 ===> 苏宁/一号店对应目录id(方便调试, 可以改成对应cat_name)

    - [category_jd_sn.txt](https://raw.githubusercontent.com/NominationP/work_goods_sum/master/category_jd_sn.txt)
    - [category_jd_yhd.txt](https://raw.githubusercontent.com/NominationP/work_goods_sum/master/category_jd_yhd.txt)

## 结果样例

- 经过上述方法，将现有商品分类结果展示(按京东的分类把苏宁和一号店的商品归类)
- tip:点raw，查看全文

    - [sn](https://github.com/NominationP/work_goods_sum/tree/master/sn_show)
    - [yhd](https://github.com/NominationP/work_goods_sum/tree/master/yhd_show)

## 已知错误


- sn
    - <i class="fa fa-check-square-o">sn_ecs_goods 中有1316个商品目录ID是无效的，最后结果暂时归为０
    - <i class="fa fa-square-o">sn 193
    - 有很多商品本来的分类不准确
        - <i class="fa fa-check-square-o"> 目前发现的有 粮油调味 中有很多饼干

- yhd
    - <i class="fa fa-check-square-o">目前有41个商品的分类为０(只剩一些床单，不知道分哪里。。。)

## 待改进

- yhd
    - <i class="fa fa-square-o"> JD对于抽纸和床单（毛毯）等日常用品没有明确分类，暂时归入 ~~橱具~~ 厨卫清洁


## JD三级 对应 YHD一级原因

|cat level|yhd_nums|jd_nums|
|----------------|------|----|
|1|13|8|
|2|121|8|
|3|986|45|
|4|741|

- yhd二级分类比jd三级分类还要详细
- **按当前策生成的结果符合预期**



## detail

```
思亲肤(skinfood) 水蜜桃清酒紧致化妆水135ml______update ecs_goods set `cat_id`='21' where goods_sn=135145209
思亲肤(skinfood)水蜜桃清酒乳液135ml______update ecs_goods set `cat_id`='21' where goods_sn=135150413
思亲肤(skinfood) 水蜜桃清酒生机面膜23g______update ecs_goods set `cat_id`='21' where goods_sn=135168205
思亲肤(skinfood) 水蜜桃清酒紧致毛孔精华液 45ml______update ecs_goods set `cat_id`='21' where goods_sn=135358757

乐美雅 品位多功能酒杯4件套 J0962______update ecs_goods set `cat_id`='21' where goods_sn=127884543
乐美雅 八角1L1水壶饮料用具七件套 21134______update ecs_goods set `cat_id`='21' where goods_sn=127878586
乐美雅 烈酒吞杯3.4cl促销6件套 G9059______update ecs_goods set `cat_id`='21' where goods_sn=127874574
乐美雅 烈酒金杯3cl促销6件套 G9057______update ecs_goods set `cat_id`='21' where goods_sn=127891596
舒润一次性咖啡搅拌棒*200支______update ecs_goods set `cat_id`='21' where goods_sn=128444668
```











