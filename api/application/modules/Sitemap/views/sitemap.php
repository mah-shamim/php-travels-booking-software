<?php header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>

  <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo base_url();?></loc>
    </url>
 <?php
if(!empty($cms)){
 foreach($cms as $url) { ?>
    <url>
        <loc><?php echo base_url().$url->page_slug; ?></loc>
    </url>
    <?php } }
    if(!empty($hotels)){
    foreach($hotels as $h) { ?>
    <url>
        <loc><?php echo $h->slug; ?></loc>
    </url>
    <?php } }
    if(!empty($cars)){
    foreach($cars as $car) { ?>
    <url>
    <loc><?php echo $car->slug; ?></loc>
    </url>
    <?php } }
    if(!empty($tours)){
    foreach($tours as $t) { ?>
    <url>
        <loc><?php echo $t->slug; ?></loc>
    </url>
    <?php } } if(!empty($posts)){
    foreach($posts as $p) { ?>
    <url>
        <loc><?php echo $p->slug; ?></loc>
    </url>
    <?php } } if(!empty($offers)){
    foreach($offers as $o){ ?>
    <url>
        <loc><?php echo $o->slug; ?></loc>
    </url>
    <?php } } ?>

</urlset>