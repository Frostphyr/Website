---
---
<?php

{% assign releases = site.pages | where: "layout", "release" | where: "project-id", page.project-id | sort: "date" %}
{% assign latest_release = 0 %}
{% for release in releases %}
    {% assign major = release.version | split: "." | first | plus: 0 %}
    {% if latest_release == 0 or major >= highest_major %}
        {% assign latest_release = release %}
        {% assign highest_major = major %}
    {% endif %}
{% endfor %}

include($_SERVER['DOCUMENT_ROOT'] . "/{{ page.projects[page.project-id].url }}/download/{{ latest_release.version }}.php");