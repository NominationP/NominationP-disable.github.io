---
layout: article
title: "Jekyll MD Tip"
modified:
categories: todo
#excerpt:
tags: [tur, markdwon]
toc: true
image:
#  feature:
    teaser: /teaser/mha_mac.jpg
#  thumb:
date: 2017-01-21T14:51:15+08:00
---
>some tip for jekyll markdown

## code

{% highlight c++ %}
{% raw %}
#include <iostream>
int main(){
    cout<<1;
}
{% endraw %}
{% endhighlight %}
{% highlight bash %}
{% raw %}
gem install jekyll
{% endraw %}
{% endhighlight %}


## highlight && color

>```
`set your color`{: style="color: red"}
```
`set your color`{: style="color: red"}

>```
`fix color`
```
`fix color`


## checkbox

>```
<i class="fa fa-check-square-o">
```
<i class="fa fa-check-square-o">

>```
<i class="fa fa-square-o">
```
<i class="fa fa-square-o">

## TOC

>```
toc: true
```
show toc :)










