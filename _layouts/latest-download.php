---
---
<?php

{% assign release = site.data[page.project].releases | last %}
include("{{ release.version }}/index.{{ page.file_type }}");