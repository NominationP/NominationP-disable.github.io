---
layout: archive
permalink: /
title: "Latest Posts"
image:
    feature: background/cover.png

---
<!--
layout: archive
permalink: /
title: "Latest Posts"
image:
    feature: background/moble.jpg
    credit: Hubber's high resolution photo
    creditlink: http://www.universetoday.com/wp-content/uploads/2010/02/The-Majestic-Sombrero-Galaxy-M104.jpg
 -->

<div class="tiles">
{% for post in site.posts %}
    {% if post.categories contains 'ban' %}
    {% else %}
	   {% include post-grid.html %}
    {% endif %}
{% endfor %}
</div><!-- /.tiles -->


