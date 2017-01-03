---
layout: page
title: About
permalink: /about/
---

This is the base Jekyll theme. You can find out more info about customizing your Jekyll theme, as well as basic Jekyll usage documentation at [jekyllrb.com](http://jekyllrb.com/)

You can find the source code for the Jekyll new theme at:
{% include icon-github.html username="jekyll" %} /
[minima](https://github.com/jekyll/minima)

You can find the source code for Jekyll at
{% include icon-github.html username="jekyll" %} /
[jekyll](https://github.com/jekyll/jekyll)zz



* 目录
{:toc}

# 陈三

## 陈三的博客
请注意，* 目录这一行是必需的，它表示目录树列表，至于星号后面写什么请随意
如果要把某标题从目录树中排除，则在该标题的下一行写上 {:.no_toc}
目录深度可以通过 config.yml 文件中添加 toc_levels 选项来定制，默认为 1..6，表示标题一至标题六全部渲染
{:toc} 默认生成的目录列表会添加 id 值 markdown-toc，我们可以自定义 id 值，比如 {:toc #chenxsan}，生成的目录列表添加的 id 将会是 chenxsan。

raw_text.gsub(/(\d+\. |\* )\K\[(x|X)\]/, %(<i class="fa fa-check-square-o"></i>)).gsub(/(\d+\. |\* )\K\[ \]/, %(<i class="fa fa-square-o"></i>))