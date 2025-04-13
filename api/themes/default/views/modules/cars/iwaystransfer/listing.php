<!-- start Main Wrapper -->
<div class="main-wrapper scrollspy-container">
    <!--<div class="page-title breadcrumb-wrapper">
       <div class="container">
           <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                   <li class="breadcrumb-item"><a href="#">Home</a></li>
                   <li class="breadcrumb-item"><a href="#">Library</a></li>
                   <li class="breadcrumb-item active" aria-current="page">Data</li>
               </ol>
           </nav>
       </div>
       </div>-->
    <section class="page-wrapper bg-light-primary">
        <div class="container">
            <div class="row gap-20 gap-md-30 gap-xl-40">
                <div class="col-12 col-lg-3">
                    <aside class="sidebar-wrapper filter-wrapper mb-10 mb-md-0">
                        <div class="box-expand-lg">
                            <div id="filterResultCallapseOnMobile" class="collapse box-collapse">
                                <div class="wrapper-inner">
                                    <div class="sidebar-title bg-primary">
                                        <div class="d-flex align-items-end">
                                            <div>
                                                <h4 class="text-white font-serif font400">Filter results</h4>
                                            </div>
                                            <!--<div class="ml-auto">
                                               <a href="#" class="filter-reset">Reset</a>
                                               </div>-->
                                        </div>
                                    </div>
                                    <div class="sidebar-box">
                                        <div class="box-title">
                                            <h5><?=lang('0301')?></h5>
                                        </div>
                                        <div class="box-content">
                                            <?php
                                            $exits_value = array();
                                            if(!empty($data['taxi']['result'])) {
                                                foreach ($data['taxi']['result'] as $key => $value) {
                                                    if (!empty($value['price'])) {
                                                        $price_convert = $value['price'];
                                                    } else {
                                                        $price_convert = round($value['price']);
                                                    }
                                                    if (!in_array($price_convert, $exits_value)) {
                                                        ?>
                                                        <div>
                                                            <input type="checkbox"
                                                                   id="price_<?= round($price_convert); ?>"
                                                                   value="<?= round($price_convert); ?>"
                                                                   onclick="filterprice(<?= round($price_convert); ?>)"
                                                                   name="price">
                                                            <label><?= round($price_convert); ?>
                                                                <small>(<?php
                                                                    echo $price[$price_convert];
                                                                    ?>)
                                                                </small>
                                                            </label>
                                                        </div>
                                                    <?php }
                                                    $exits_value[] = $price_convert;
                                                }
                                            }else{lang('066');}
                                            ?>
                                        </div>
                                    </div>

                                    <div class="sidebar-box">
                                        <div class="box-title">
                                            <h5><?=lang('0607')?></h5>
                                        </div>
                                        <div class="box-content">
                                            <?php
                                            $pax_array = array();
                                            if(!empty($data['taxi']['result'])) {
                                                foreach ($data['taxi']['result'] as $key => $value) {
                                                    if (!in_array($value['car_class']['capacity'], $pax_array)) {
                                                        ?>
                                                        <div>
                                                            <input type="checkbox"
                                                                   id="pax_<?= $value['car_class']['capacity']; ?>"
                                                                   onclick="filterpax(<?= $value['car_class']['capacity'] ?>)">
                                                            <label><?= $value['car_class']['capacity'] ?>
                                                                <small>(<?php
                                                                    echo $pax[$value['car_class']['capacity']];
                                                                    ?>)
                                                                </small>
                                                            </label>
                                                        </div>
                                                    <?php }
                                                    $pax_array[] = $value['car_class']['capacity'];
                                                }
                                            }else{lang('066');}
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </aside>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="content-wrapper">
                        <div class="d-lg-flex mb-30 mb-lg-0">
                            <div>
                                <h3 class="heading-title">
                                    <?=lang('0252')?> <?=lang('0612')?> <!--<span class="text-lowercase"></span> </span> <span class="text-primary">--> <?=lang('0291')?>
                                </h3>
                                <p style="font-size:16px" class="text-muted post-heading"><span id="count"><?php echo count($data['taxi']['result']);?></span> <?=lang('0613')?> <small><?= $laoction_form;?> <strong><?=lang('0274')?></strong> <?=$laoction_to;?></small></p>
                            </div>
                            <div class="ml-auto">
                                <button class="btn btn-secondary btn-wide btn-toggle collapsed btn-sm btn-change-search" data-toggle="collapse" data-target="#change-search"><?=lang('0106')?> <?=lang('012')?></button>
                            </div>
                        </div>
                        <div id="change-search" class="collapse">
                            <div class="change-search-wrapper">
                                <?php echo searchForm($appModule,$searchForm); ?>
                            </div>
                        </div>
                        <?php if (!empty($data['taxi']['result'] )) {?>
                            <div class="product-long-item-wrapper">
                                <?php foreach ($data['taxi']['result'] as $key => $value){
                                    $price_convert = round($value['price']);
                                    $car_name = $value['car_class']['title'];
                                    ?>

                                <form action="<?= site_url('itaxi/checkout'); ?>" method="post" id="form_<?= $value['reverse_price']['price_id']; ?>">
                                    <input type="hidden" value="https://iwayex.com/images/cars/<?php echo $value['car_class']['photo'] ?>" name="img"/>
                                    <input type="hidden" value="<?=$car_name ?>" name="name"/>
                                    <input type="hidden" value="<?=$laoction_to;?>" name="name_to"/>
                                    <input type="hidden" value="<?=$laoction_form;?>" name="name_form"/>
                                    <input type="hidden" value="<?=$value['currency'];?>" name="usd"/>
                                    <input type="hidden" value="<?=round($value['price']);?>" name="price"/>
                                    <input type="hidden" value="<?=$value['currency'];?>" name="curr_code"/>
                                    <input type="hidden" value="<?=$start_place_point;?>" name="start_place_point"/>
                                    <input type="hidden" value="<?=$finish_place_point?>" name="finish_place_point"/>
                                    <input type="hidden" value="<?=$laoction_form?>" name="laoction_form"/>
                                    <input type="hidden" value="<?=$laoction_to?>" name="laoction_to"/>
                                    <input type="hidden" value="<?=$value['reverse_price']['price_id'];?>" name="transfer_id"/>
                                </form>

                                    <div class="product-long-item price_<?= $price_convert;?>  pax_<?=$value['car_class']['capacity'];?>">
                                        <div class="row equal-height shrink-auto-md gap-15">
                                            <div class="col-12 col-shrink">
                                                <div class="image height-auto">
                                                    <img src="https://iwayex.com/images/cars/<?php echo $value['car_class']['photo'] ?>" alt="images" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-auto">
                                                <div class="col-inner d-flex flex-column">
                                                    <div class="content-top">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5><a><?=$car_name ?></a>
                                                                </h5>
                                                               <!--<p class="location">
                                                                    <?php
                                                                    $carExamples = $value['type']['carExamples'][$lang];
                                                                    if(!empty($carExamples)){
                                                                        echo $carExamples;
                                                                    }else{
                                                                        echo $value['type']['carExamples']['en'];
                                                                    }
                                                                    ?>
                                                                </p>-->
                                                            </div>
                                                            <div class="ml-auto">
                                                                <div class="price">
                                                                 <span class="text-secondary"><?php

                                                                         echo $value['currency']." ".round($value['price']);
                                                                     }
                                                                     ;?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   <!-- <div class="content">
                                                        <p>
                                                            <?php
                                                            $description = $value['type']['description'][$lang];
                                                            if(!empty($description)){
                                                                echo $description;
                                                            }else{
                                                                echo $value['type']['description']['en'];
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>-->
                                                    <div class="content-bottom mt-auto">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <ul class="meta-list ">
                                                                    <li><?= $value['car_class']['capacity']; ?> <?=lang('0607')?></li>
                                                                </ul>
                                                            </div>
                                                            <div class="ml-auto">
                                                                <a href="javascript:void(0);" onclick="$('#form_<?= $value['reverse_price']['price_id']; ?>').submit();" class="btn btn-primary btn-sm btn-wide"><?=lang('0142')?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- end Main Wrapper -->
<script>
    function filterprice(id){
        var isChecked = document.getElementById('price_'+id).checked;
        var array = [<?php echo '"'.implode('","', $price_array).'"' ?>];
        var arraypax = [<?php echo '"'.implode('","', $pax_array).'"' ?>];
        var i,x,y;
        var count = 0;
        if(isChecked == true) {
            for (i = 0; i < array.length; i++){
                if(array[i] == id) {
                    count++;
                    document.getElementById('price_'+array[i]).checked;
                    $("div").filter(".price_"+ array[i]).show();
                }else{
                    document.getElementById('price_'+array[i]).checked=false;
                    $("div").filter(".price_"+ array[i]).hide();
                }
            }

            for (y = 0; y < arraypax.length; y++){
                document.getElementById('pax_'+arraypax[y]).checked=false;
            }
            $("#count").html(count);
        }else{
            for (i = 0; i < array.length; i++){
                count++;
                $("div").filter(".price_"+ array[i]).show();
            }
            $("#count").html(count);
        }
    }


    function filterpax(id){
        var isChecked = document.getElementById('pax_'+id).checked;
        var array = [<?php echo '"'.implode('","', $pax_array).'"' ?>];
        var arrayprice = [<?php echo '"'.implode('","', $price_array).'"' ?>];
        var i,x,y;
        var count = 0;
        if(isChecked == true) {
            for (i = 0; i < array.length; i++){
                if(array[i] == id) {
                    count++;
                    $("div").filter(".pax_" + array[i]).show();
                }else{
                    $("div").filter(".pax_" + array[i]).hide();
                }
            }
            for (x = 0; x < arrayprice.length; x++){
                document.getElementById('price_'+arrayprice[x]).checked=false;
            }
            $("#count").html(count);
        }else{
            for (i = 0; i < array.length; i++){
                count++;
                $("div").filter(".pax_" + array[i]).show();
            }
            $("#count").html(count);
        }
    }
</script>
