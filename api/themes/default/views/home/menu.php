<?php foreach ($modulesname as $module) {

    if(!$is_home) {
        $slug = $module['link'];
        $href = base_url('m-' . $slug);
        $target = "_self";
    }else{
        $slug = $module['link'];
        if ($module['slug'] == "flightst") {
            $href = base_url($module['slug']);
            $target = "_self";
            $data_toggle = '';
        }else{
            $href = '#'.$slug;
            $data_toggle = 'data-toggle="tab"';
        }
    }
    ?>

    <li class="nav-item mr-0 m-mb-0">
    <a class="nav-link d-flex align-items-center nav-mob nav-mob-p8 <?=$module['link']?> <?php if($order == $module['order']){ echo "active"; }?>" id="<?=$module['link']?>-tab" data-toggle="tab" href="#<?=$module['link']?>" role="tab" aria-controls="<?=$module['link']?>" aria-selected="true">
    <i class="nav-mob <?=($module['icon'])?> mr-1"></i>  <span class="nav-mob"><?=lang($module['name'])?></span>
    </a>
    </li>

    <!--data-name="<?=$module['link']?>"  href="<?=$href?>" target="<?=$target?>" <?=$data_toggle?>-->

<?php }


    // echo "<pre>";
    // print_r($order);
    // print_r($modulesname);
?>
<!--
<?php
foreach($modulesList as $index=> $module):
if(isModuleActive($module->name) && ! empty(count((array) $module->frontend)) && ! in_array($module->name, ['Blog','Offers'])):
?>
    <li role="presentation" name="<?=$module->name;?>" class="<?=(($active_menu == strtolower($module->frontend->slug)))?'active':''?> text-center">
        <?php
            if(!$is_home):
                $slug = strtolower($module->frontend->slug);
                $href = base_url('m-'.$slug);
                $target = "_self";
                if ($slug == "Viator") {
                    $href = "https://www.partner.Viator.com/en/{$module->settings->affid}";
                    $target = "_blank";
                }
            ?>
            <a class="text-center" href="<?=$href?>" target="<?=$target?>">
                <div class="visible-xs visible-md clearfix"></div>
                <span class="hidden-xs"><?php echo trans($module->frontend->label);?></span>
            </a>
        <?php else: ?>
            <?php
                $slug = strtolower($module->frontend->slug);
                $href = '#'.$slug;
                if ($slug == "flightst") {
                    $href = base_url($slug);
                }
                if ($slug == "Viator") {
                    $href = "https://www.partner.Viator.com/en/{$module->settings->affid}";
                }
            ?>
            <?php if(in_array($slug, ["flightst","Viator"])): ?>
                <a class="text-center" href="<?=$href?>" title="<?=$module->frontend->label?>" target="_blank" data-toggle="tab">
                    <span class="hidden-xs"><?php echo trans($module->frontend->label);?></span>
                </a>
            <?php else: ?>
                <a class="" href="<?=$href?>" data-toggle="tab" aria-controls="home" aria-expanded="true" title="<?=$module->frontend->label?>">
                    <div class="visible-xs visible-md clearfix"></div>
                    <span class="hidden-xs"><?php echo trans($module->frontend->label);?></span>
                </a>
            <?php endif; ?>
        <?php endif; ?>
    </li>
<?php endif; endforeach; ?>
<script>
$(document).ready(function()
{
$('.nav li').click(function(e)
{
const listItems = document.querySelectorAll('.nav li');
var className = $(this).attr('name');
for (var i = 0; i < listItems.length; i++) {
if(listItems[i].textContent == className){
    $(this).closest('li').addClass('active');
}else{
    $('nav li.active').removeClass('active');
}
}
});
});
</script>-->

<script>
$(document).ready(function()
{
var listItems = document.querySelectorAll('.nav li a');
var className = window.location.href;
var parts = className.split("/");
var last_part = parts[parts.length-1];
var classname = last_part.split("-").splice(1);
if(classname !='') {
var nameclass = $('.' + classname).data('name');
for (var i = 0; i < listItems.length; i++) {
if (listItems[i].attributes[1].nodeValue.trim() == nameclass) {
$('.' + listItems[i].attributes[1].nodeValue.trim().toLowerCase()).addClass('active');
$('#' + listItems[i].attributes[1].nodeValue.trim().toLowerCase()).addClass('active');
} else {
$('.' + listItems[i].attributes[1].nodeValue.trim().toLowerCase()).removeClass('active');
$('#' + listItems[i].attributes[1].nodeValue.trim().toLowerCase()).removeClass('active');
}
}
}
});
</script>