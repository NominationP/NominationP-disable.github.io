---
layout: archive
permalink: /work_record/
title: "Latest Posts in *work_record*"
excerpt: "Everything that happens is perfectly destined"
---

<div class="tiles">
{% for post in site.posts %}
    {% if post.categories contains 'work_record' %}
        {% include post-grid.html %}
    {% endif %}
{% endfor %}
</div><!-- /.tiles -->
