---
layout: archive
permalink: /todo/
title: "Latest Posts in *todo*"
excerpt: "Everything that happens is perfectly destined"
---

<div class="tiles">
{% for post in site.posts %}
	{% if post.categories contains 'todo' %}
		{% include post-grid.html %}
	{% endif %}
{% endfor %}
</div><!-- /.tiles -->
