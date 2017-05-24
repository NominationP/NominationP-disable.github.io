---
layout: pureread
title: "goods schedule"
modified: 2017.03.07
category: work_record
tag:
- work

#excerpt:
toc: false
image:
#  feature:
    teaser: /teaser/gil.jpg
#  thumb:
date: 2017-03-07
---

>goods update schedule

### 已完成
JD/SN 定时更新商品（图片，分类，价格，上下架，利润等）
> 在本地，用 crontab 定时访问服务器(网址)来更新 (jd 一天/次  sn 三天/次)

> 目前JD商品积压太多（20W以上）需要很长时间才能调完（程序运行时间）


### 待完善
JD商品分类（以前是手动分类
> 增加JD原始分类对映表（由于种类很多，所以根据每天新增的商品来完善）

JD接口需要重构
>没有封装，不可扩展，不可调用，不安全