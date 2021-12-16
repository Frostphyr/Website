---
---
<?php

{% assign release = site.data[page.project].releases | last %}
include("{{ release.version | major }}.{{ release.version | minor }}/index.{{ page.file_type }}");