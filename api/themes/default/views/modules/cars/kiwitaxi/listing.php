<style>
.form-inner  label{
  position:static
}
.form-icon-left .icon-font{top:0}
</style>
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
                                            if(!empty($data['taxi'][0]['transfers'])) {
                                                foreach ($data['taxi'][0]['transfers'] as $key => $value) {
                                                    if (!empty($value['price'][strtolower($currencycode)]['cost'])) {
                                                        $price_convert = $value['price'][strtolower($currencycode)]['cost'];
                                                    } else {
                                                        $price_convert = round($value['price']['usd']['cost'] * $currencyrate);
                                                    }
                                                    if (!in_array($price_convert, $exits_value)) {
                                                        ?>
                                                        <div>
                                                            <input type="checkbox"
                                                                   id="price_<?= $price_convert; ?>"
                                                                   value="<?= $price_convert; ?>"
                                                                   onclick="filterprice(<?= $price_convert; ?>)"
                                                                   name="price">
                                                            <label><?= $price_convert; ?>
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
                                            <h5><?=lang('0199')?></h5>
                                        </div>
                                        <div class="box-content">
                                            <?php
                                            $baggage_array = array();
                                            if(!empty($data['taxi'][0]['transfers'])) {
                                                foreach ($data['taxi'][0]['transfers'] as $key => $value) {
                                                    if (!in_array($value['type']['baggage'], $baggage_array)) {
                                                        ?>
                                                        <div>
                                                            <input type="checkbox"
                                                                   id="baggage_<?= $value['type']['baggage']; ?>"
                                                                   value="<?= $value['type']['baggage']; ?>"
                                                                   onclick="filterbaggage(<?= $value['type']['baggage']; ?>)"
                                                                   name="baggage">
                                                            <label><?= $value['type']['baggage']; ?>
                                                                <small>(<?php
                                                                    echo $baggage[$value['type']['baggage']];
                                                                    ?>)
                                                                </small>
                                                            </label>
                                                        </div>
                                                    <?php }
                                                    $baggage_array[] = $value['type']['baggage'];
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
                                            if(!empty($data['taxi'][0]['transfers'])) {
                                                foreach ($data['taxi'][0]['transfers'] as $key => $value) {
                                                    if (!in_array($value['type']['pax'], $pax_array)) {
                                                        ?>
                                                        <div>
                                                            <input type="checkbox"
                                                                   id="pax_<?= $value['type']['pax']; ?>"
                                                                   onclick="filterpax(<?= $value['type']['pax'] ?>)">
                                                            <label><?= $value['type']['pax']; ?>
                                                                <small>(<?php
                                                                    echo $pax[$value['type']['pax']];
                                                                    ?>)
                                                                </small>
                                                            </label>
                                                        </div>
                                                    <?php }
                                                    $pax_array[] = $value['type']['pax'];
                                                }
                                            }else{lang('066');}
                                            ?>
                                        </div>
                                    </div>
                                    <!--<div class="sidebar-box">
                              <div class="box-title">
                                  <h5>Passengers</h5>
                              </div>
                              <div class="box-content">
                                  <?php
                                    $pax_array = array();
                                    foreach ($data['taxi'][0]['transfers'] as $key => $value) {
                                        if (!in_array($value['type']['pax'], $pax_array)) {
                                            ?>
                                          <div class="custom-control custom-checkbox">
                                              <input type="checkbox" class="custom-control-input"
                                                     id="filrerCarCategory-01_<?= $value['type']['pax']; ?>" value="" name="filrerCarCategory">
                                              <label class="custom-control-label"
                                                     for="filrerCarCategory-01"><?= $value['type']['pax']; ?>
                                                  <small class="text-muted font11">(<?php
                                            echo $pax[$value['type']['pax']];
                                            ?>)</small>
                                              </label>
                                          </div>
                                      <?php }
                                        $pax_array[] = $value['type']['pax'];
                                    }
                                    ?>
                              </div>
                              </div>-->
                                    <!--<div class="sidebar-box">
                                       <div class="box-title">
                                           <h5>Filer Select</h5>
                                       </div>
                                       <div class="box-content">
                                           <div class="form-group">
                                               <select  data-placeholder="Please select" class="chosen-the-basic form-control" tabindex="2">
                                                   <option value=""></option>
                                                   <option>1</option>
                                                   <option>2</option>
                                                   <option>3</option>
                                                   <option>4</option>
                                                   <option>5</option>
                                               </select>
                                           </div>
                                       </div>
                                       </div>
                                       <div class="sidebar-box">
                                       <div class="box-title">
                                           <h5>Filer Text</h5>
                                       </div>
                                       <div class="box-content">
                                           <p class="line-15">Park fat she nor does play deal our. Procured sex material his offering humanity laughing moderate can.</p>
                                       </div>
                                       </div>-->
                                </div>
                            </div>
                        </div>
                        <!--<div class="featured-contact-01 mt-40 mb-30 d-none d-md-block">
                           <h6>Need help? Call us on</h6>
                           <span class="phone-number"><i class="material-icons">phone</i> 1985 5524 145</span>
                           It's free to call from anywhere
                           </div>
                           <div class=" d-none d-lg-block">
                           <h6 class="text-uppercase letter-spacing-2 line-1 font500"><span>Why Book With Travel Material</span></h6>
                           <ul class="list-icon-data-attr font-ionicons">
                               <li data-content="&#xf383">Excited him now natural saw passage age explain.</li>
                               <li data-content="&#xf383">Farther so friends is detract do private.</li>
                               <li data-content="&#xf383">Procured is material his offering humanity laughing moderate can.</li>
                           </ul>
                           </div>
                           <div class="d-block d-lg-none">
                           <button type="buttom" class="btn btn-toggle btn-outline-primary btn-block collapsed collapsed-disapear" data-toggle="collapse" data-target="#filterResultCallapseOnMobile">Show Filter</button>
                           </div>-->
                    </aside>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="content-wrapper">
                        <div class="d-lg-flex mb-30 mb-lg-0">
                            <div>
                                <h3 class="heading-title float-none">
                                    <?=lang('0252')?> <?=lang('0612')?> <!--<span class="text-lowercase"></span> </span> <span class="text-primary">--> <?=lang('0291')?>
                                </h3>
                                <p style="font-size:16px" class="text-muted post-heading"><span id="count"><?php echo count($data['taxi'][0]['transfers']);?></span> <?=lang('0613')?> <small><?= $laoction_form;?> <strong><?=lang('0274')?></strong> <?=$laoction_to;?></small></p>
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
                        <?php if (!empty($data['taxi'][0]['transfers'] )) {?>
                            <div class="product-long-item-wrapper">
                                <?php foreach ($data['taxi'][0]['transfers'] as $key => $value){
                                    if(!empty($value['price'][strtolower($currencycode)]['cost'])){
                                        $price_convert = $value['price'][strtolower($currencycode)]['cost'];
                                    }else{
                                        $price_convert = round($value['price']['usd']['cost'] * $currencyrate);
                                    }
                                    $name = $value['type']['name'][$lang];
                                    if(!empty($name)){
                                        $car_name =  $name;
                                    }else{
                                        $car_name =  $value['type']['name']['en'];
                                    }
                                    ?>
                                    <form action="<?= site_url('taxi/checkout'); ?>" method="post" id="form_<?= $value['id'] ?>">
                                        <input type="hidden" value="<?php echo base_url().'uploads/images/kiwitaxi/'.str_replace(' ','_',strtolower($car_name)).'.jpg'; ?>" name="img"/>
                                        <input type="hidden" value="<?=$car_name ?>" name="name"/>
                                        <input type="hidden" value="<?=$laoction_to;?>" name="name_to"/>
                                        <input type="hidden" value="<?=$laoction_form;?>" name="name_form"/>
                                        <input type="hidden" value="<?=$value['price']['usd']['cost'];?>" name="usd"/>
                                        <input type="hidden" value="<?=$value['price'][strtolower($kiwitaxicurrency)]['cost'];?>" name="price"/>
                                        <input type="hidden" value="<?=$kiwitaxicurrencycode;?>" name="curr_code"/>
                                        <input type="hidden" value="<?=$value['id'];?>" name="transfer_id"/>
                                        </form>
                                    <div class="product-long-item price_<?= $price_convert;?> baggage_<?=$value['type']['baggage'];?> pax_<?=$value['type']['pax'];?>">
                                        <div class="row equal-height shrink-auto-md gap-15">
                                            <div class="col-12 col-shrink">
                                                <div class="image height-auto">
                                                    <img src="<?php echo base_url().'uploads/images/kiwitaxi/'.str_replace(' ','_',strtolower($car_name)).'.jpg'; ?>" alt="images" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-auto">
                                                <div class="col-inner d-flex flex-column">
                                                    <div class="content-top">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5><a><?=$car_name ?></a>
                                                                </h5>
                                                                <p class="location">
                                                                    <?php
                                                                    $carExamples = $value['type']['carExamples'][$lang];
                                                                    if(!empty($carExamples)){
                                                                        echo $carExamples;
                                                                    }else{
                                                                        echo $value['type']['carExamples']['en'];
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                            <div class="ml-auto">
                                                                <div class="price">
                                                                 <span class="text-secondary"><?php
                                                                     if(!empty($value['price'][strtolower($currencycode)]['cost'])){
                                                                         echo $value['price'][strtolower($currencycode)]['currency']['code']." ".$value['price'][strtolower($currencycode)]['cost'];
                                                                     }else{
                                                                         echo $currencycode." ".round($value['price']['usd']['cost'] * $currencyrate);
                                                                     }
                                                                     ;?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="content">
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
                                                    </div>
                                                    <div class="content-bottom mt-auto">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <ul class="meta-list ">
                                                                    <li><?= $value['type']['pax']; ?> <?=lang('0607')?></li>
                                                                    <li><?= $value['type']['baggage']; ?> <?=lang('0199')?></li>
                                                                </ul>
                                                            </div>
                                                            <div class="ml-auto">
                                                                <a href="javascript:void(0);" onclick="$('#form_<?= $value['id'] ?>').submit();" class="btn btn-primary btn-sm btn-wide"><?=lang('0142')?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else{lang('066'); } ?>
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
        var arraybaggage = [<?php echo '"'.implode('","', $baggage_array).'"' ?>];
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
            for (x = 0; x < arraybaggage.length; x++){
                document.getElementById('baggage_'+arraybaggage[x]).checked=false;
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

    function filterbaggage(id){
        var isChecked = document.getElementById('baggage_'+id).checked;
        var array = [<?php echo '"'.implode('","', $baggage_array).'"' ?>];
        var arrayprice = [<?php echo '"'.implode('","', $price_array).'"' ?>];
        var arraypax = [<?php echo '"'.implode('","', $pax_array).'"' ?>];
        var i,x,y;
        var count = 0;
        if(isChecked == true) {
            for (i = 0; i < array.length; i++){
                if(array[i] == id) {
                    count++;
                    document.getElementById('baggage_'+array[i]).checked;
                    $("div").filter(".baggage_" + array[i]).show();
                }else{
                    document.getElementById('baggage_'+array[i]).checked=false;
                    $("div").filter(".baggage_" + array[i]).hide();
                }
            }
            for (x = 0; x < arrayprice.length; x++){
                document.getElementById('price_'+arrayprice[x]).checked=false;
            }
            for (y = 0; y < arraypax.length; y++){
                document.getElementById('pax_'+arraypax[y]).checked=false;
            }
            $("#count").html(count);
        }else{
            for (i = 0; i < array.length; i++){
                count++;
                $("div").filter(".baggage_" + array[i]).show();
            }
            $("#count").html(count);
        }
    }

    function filterpax(id){
        var isChecked = document.getElementById('pax_'+id).checked;
        var array = [<?php echo '"'.implode('","', $pax_array).'"' ?>];
        var arrayprice = [<?php echo '"'.implode('","', $price_array).'"' ?>];
        var arraybaggage = [<?php echo '"'.implode('","', $baggage_array).'"' ?>];
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
            for (y = 0; y < arraybaggage.length; y++){
                document.getElementById('baggage_'+arraybaggage[y]).checked=false;
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
