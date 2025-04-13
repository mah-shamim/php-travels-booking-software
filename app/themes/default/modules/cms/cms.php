<div class="container">
<div class="sidebar mb-0 mt-5">
<div class="sidebar-widget">
<h3 class="title stroke-shape" style="text-transform:capitalize"><?=str_replace('-', ' ', $title);?></h3>
</div>
<div class="sidebar-widget">
<?php if (!empty($content)) { echo $content;
}else{ echo "Data Not Found!"; } ?>
</div>
</div>
</div>