---
layout: pureread
title: "work year sum"
modified: 2017-02-06T09:44:15+08:00
category: work_record
tag:
- work

#excerpt:
toc: true
image:
#  feature:
    teaser: /teaser/delete.jpg
#  thumb:
date: 2017-01-23T17:41:15+08:00
---

>last work in year(china)

## 已完成 ：

- {{site.check_box}}php-java-bridge
    -  shengchengtong
    -  yufu(need to sub)
    -  putian
- {{site.check_box}}商品表
    - 整体流程：（找到新商品）---》程序---》插入新商品表（新分类，新品牌...）
        - 商品目录分类整理及导入
        - 商品品牌整理及导入
        - 新增商品导入

## BUG
- 原本有很多不匹配的信息
    - 品牌不对应（jd）
    - 分类字段为0
    - ......


## process

1. category: by rule file change yhd/sn category data table (add attribute [jd_id])
2. brand: sum all brand in a table ,brand_name --- jd_id --- sn_id --- yhd_id
2. when add a new good ==> generate new brand && category ==> save



update jd goods data find new goods
username
shengchengtong


check jd_goods ====> add new good
check my_goods ====> delete old good

every time click goods ===> update price and caculate benefit if bad ---> cancel






