---
layout: article
title: "Reids object overview"
category: blog
tag:
- redis 

#excerpt:
toc: false
image:
#  feature:
    teaser: /blog/2019.11/redis-object-cover.png
#  thumb
date:   2019-11-14 22:43
---

# #blog **第八章 对象**

## redis 基于：SDS，双端链表，字典，压缩列表，整数集合等这些数据结构构建一个对象系统，包含：字符串对象，列表对象，哈希对象，集合对象和有序集合对象这五种类型的对象

## 为对象设置多种不同的数据结构，从而优化对象在不同场景下的使用效率

## redis对象系统实现了基于引用计数技术的内存回收机制

## redis还通过引用计数技术实现了对象共享机制

## redis对象带有访问时间记录信息，可以用于计算数据库健的空转时间

![mind](/images/blog/2019.11/redis-object.png)

### 这张图囊括了redis中的所有对象结构，包括字符串，列表，哈希表，集合，有序集合。

### 首先，这5个对象都是至少有俩个对象组成：key object ==> value object

- key object 一定是个字符串类型

- value object 分为上述5中类型

### 这5中类型，分别对应至少2种底层实现方式，也就是2种不同的编码方式（encoding）

- 可以通过 >TYPE 命令来查询用了5中类型中的那种

- 可以通过 >OBJECT ENCODING 命令来查询此对象的编码方式

### 问题

- 我们常用的redis命令分别代表哪种数据结构

- 这几次种数据结构的底层实现是怎样的

- 为什么这么设计底层实现

- redis对象有那几个属性，提供了什么功能

   - type

   - encoding

   - *ptr

   - refcount 引用计数 ， 作用： 内从回收 + 对象共享

   - unsigned lru 对象空转时长 （回收内存的算法中会用到）

