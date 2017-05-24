---
layout: article
title: "Linux Mysql command"
modified:
category: blog
tag:
- Linux
- Mysql

#excerpt:
toc: true
image:
#  feature:
    teaser: /teaser/mha_mac.jpg
#  thumb:
date:   2017-04-04 21:05
modified: 2017-04-04 21:05
---
>common command for Mysql in Linux


### common command

{% highlight bash %}

CREATE DATABASE tutorial_database;

 SHOW DATABASES;

{% endhighlight %}


### privilege



{% highlight bash %}

SELECT User,Host FROM mysql.user;

grant all privileges on *.* to test@'localhost' identified by "jack" with grant option;

flush privileges;

show grants for 'test'@'%';

revoke delete on *.* from 'test'@'localhost';

drop user 'test'@'%'

{% endhighlight %}
