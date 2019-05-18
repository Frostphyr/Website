---
layout: project
title: Releases | KIN Event Keyer
---

# KIN Event Keyer Releases

{% assign project = page.projects[page.project-id] %}
{% assign releases = site.pages | where: "layout", "release" | where: "project-id", page.project-id | sort: "date" | reverse %}
{% assign highest_major = 0 %}
{% for release in releases %}
    {% assign major = release.version | split: "." | first | plus: 0 %}
    {% if major > highest_major %}
        {% assign highest_major = major %}
    {% endif %}
{% endfor %}

{% for i in (0..highest_major) reversed %}
    {%- for release in releases %}
        {%- assign major = release.version | split: "." | first | plus: 0 %}
        {%- if major == i %}
* KIN Event Keyer {{ release.version }} ({{ release.date | date: "%B %-d, %Y" }}) - [Download]({{ project.url }}/releases/download/{{ release.version }}) \| [Release Notes]({{ project.url }}/releases/{{ release.version }})
        {%- endif %}
    {%- endfor %}
{%- endfor %}