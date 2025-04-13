<?php
echo'<?xml version="1.0" encoding="UTF-8"?>';
echo'<?xml-stylesheet type="text/xsl" href="'.root.'sitemap/sitemap.xsl"?>
';?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<?php foreach(base()->cms as $c){
$date = date('Y-m-d') ?>
<url>
<loc><?=root."page/".$c->slug_url?></loc>
<lastmod><?=$date?></lastmod>
</url>
<?php } ?>
</urlset>