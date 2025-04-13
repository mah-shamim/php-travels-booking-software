<style>
*{margin:0;padding:0;-webkit-box-sizing:border-box;box-sizing:border-box}
body{font-family:sans-serif}
.pt_outer{padding:20px;background-color:#eee;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}
.pt_outer.pt_row-view .pt_inner-box{margin-bottom:15px;border-top-right-radius:7px;border-bottom-right-radius:7px;-webkit-box-flex:0;-ms-flex:0 0 100%;flex:0 0 100%;width:100%}
.pt_outer.pt_row-view{-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column}
.pt_inner-box{position:relative;background-color:#fff;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-shadow:2px 7px 26px -8px rgba(0,0,0,0.39);box-shadow:2px 7px 26px -8px rgba(0,0,0,0.39)}
.pt_image{min-height:200px;background-position:center center;background-size:cover;background-repeat:no-repeat;padding:10px;-webkit-box-flex:0;-ms-flex:0 0 25%;flex:0 0 25%;}
.pt_image span{display:inline-block;background:red;padding:8px 10px;border-radius:20px;color:#fff}
.pt_row-view .pt_content{padding:25px;-webkit-box-flex:0;-ms-flex:0 0 75%;flex:0 0 75%;max-width:75%;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;position:relative}
.pt_rating{color:#f0ad4e;margin-right:10px}
.pt_review-rating{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;margin-top:15px;-ms-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between}
.pt_d-flex{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center}
.pt_right-side{-webkit-box-flex:0;-ms-flex:0 0 25%;flex:0 0 25%;width:25%}
.pt_left-side{-webkit-box-flex:0;-ms-flex:0 0 75%;flex:0 0 75%;width:75%;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column}
.pt_left-side h3{margin-left:10px}
.pt_left-side del{color:#dc5959;margin-left:auto}
.pt_location{color:#8e8e8e;font-size:14px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;margin-top:25px}
.pt_location span:first-child{margin-left:auto;margin-right:20px}
.pt_nav{list-style:none;display:-webkit-box;display:-ms-flexbox;display:flex}
.pt_nav li{color:#8e8e8e;font-size:14px;margin-left:10px}
.pt_nav li:not(:last-child){border-right:1px solid #8e8e8e;padding-right:10px}
.pt_bottom-side{margin-top:auto;display:-webkit-box;display:-ms-flexbox;display:flex}
.pt_bottom-side strong{margin-left:auto}
@media screen and (max-width:768px){.pt_outer.pt_row-view .pt_inner-box{-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column}
.pt_outer.pt_row-view .pt_inner-box .pt_image{max-width:100%}
.pt_row-view .pt_content{max-width:100%;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;padding:20px;position:relative;-webkit-box-flex:0;-ms-flex:0 0 100%;flex:0 0 100%}
.pt_row-view .pt_right-side{width:100%;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:reverse;-ms-flex-direction:column-reverse;flex-direction:column-reverse}
.pt_row-view.pt_left-side{width:100%}
.pt_row-view .pt_review-rating{margin-top:0;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;margin-bottom:10px;margin-top:25px}
.pt_row-view .pt_price{position:absolute;width:150px;background:#fff;top:-22px;padding:10px;border-radius:50px;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-shadow:2px 7px 26px -8px rgba(0,0,0,0.39);box-shadow:2px 7px 26px -8px rgba(0,0,0,0.39)}
.pt_row-view .pt_left-side .pt_price del{margin-left:0}
.pt_row-view .pt_location span:first-child{margin-left:0}
.pt_row-view .pt_location{margin-bottom:40px}
.pt_row-view .pt_location:after{content:"";position:absolute;width:100%;height:1px;background-color:#eee;top:10rem;left:0}
.pt_row-view .pt_nav li{font-size:12px}
.pt_row-view .pt_nav li:first-child{margin-left:0}
.pt_row-view .pt_bottom-side strong{margin-left:0;font-size:12px}
.pt_row-view .pt_bottom-side{-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;margin-top:0}
.pt_row-view .pt_bottom-side .pt_nav{margin-top:15px;-ms-flex-wrap:wrap;flex-wrap:wrap}
}.pt_outer.pt_grid{-webkit-box-orient:horizontal;-webkit-box-direction:normal;-ms-flex-direction:row;flex-direction:row}
.pt_outer.pt_grid .pt_inner-box{-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;border-bottom-right-radius:7px;border-bottom-left-radius:7px;-webkit-box-flex:unset!important;-ms-flex:unset!important;flex:unset!important;width:auto!important;margin-bottom:0}
.pt_grid .pt_image{max-width:100%}
.pt_grid .pt_content{max-width:100%;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;padding:20px;position:relative;-webkit-box-flex:unset;-ms-flex:unset;flex:unset}
.pt_grid .pt_right-side{width:100%;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:reverse;-ms-flex-direction:column-reverse;flex-direction:column-reverse}
.pt_grid .pt_left-side{width:100%}
.pt_grid .pt_review-rating{margin-top:0;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:flex-start;margin-bottom:10px;margin-top:25px}
.pt_grid .pt_price{position:absolute;width:150px;background:#fff;top:-22px;padding:10px;border-radius:50px;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-shadow:2px 7px 26px -8px rgba(0,0,0,0.39);box-shadow:2px 7px 26px -8px rgba(0,0,0,0.39)}
.pt_grid .pt_left-side .pt_price del{margin-left:0}
.pt_grid .pt_location span:first-child{margin-left:0}
.pt_grid .pt_location{margin-bottom:40px}
.pt_grid .pt_location:after{content:"";position:absolute;width:100%;height:1px;background-color:#eee;top:10rem;left:0}
.pt_grid .pt_nav li{font-size:12px}
.pt_grid .pt_nav li:first-child{margin-left:0}
.pt_grid .pt_bottom-side strong{margin-left:0;font-size:12px}
.pt_grid .pt_bottom-side{-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;margin-top:0}
.pt_grid .pt_bottom-side .pt_nav{margin-top:15px;-ms-flex-wrap:wrap;flex-wrap:wrap}
a:link{text-decoration: none!important;color:#444444;}
.rating-symbol-background{display:none}

</style>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">        <title><?=$page_title?></title>
    </head>
    <body>
        <div class="pt_outer pt_row-view pt_gri">
            <?php foreach ($supplier as $data){?>
            <a href="<?=$data->slug?>" style="width:100%" target="_blank">
            <div class="pt_inner-box">
                <div
                    class="pt_image"
                    style="background-image: url('<?=$data->thumbnail;?>')"
                    >
                    <?php if(!empty($data->discount)){?><span><?=$data->discount?>% off</span><?php } ?>
                </div>
                <div class="pt_content">
                    <div class="pt_right-side">
                        <a href="<?=$data->slug?>"><h3><?=$data->title?></h3></a>
                        <div class="pt_review-rating">
                            <p class="pt_rating">
                                <?=$data->stars?>
                            </p>
                        </div>
                    </div>
                    <div class="pt_left-side">
                        <div class="pt_d-flex pt_price">
                            <del>$1500</del>
                            <h3><?=$data->currSymbol."".$data->price;?></h3>
                        </div>
                        <div class="pt_location">
                            <?php if(!empty($data->tourDays)){?><span>&#9906; <?=$data->tourDays?> Day </span><?php } ?>
                            <span>&#9906; <?=$data->location?> </span>
                        </div>
                    </div>
                </div>
            </div>
            </a>
            <?php } ?>
        </div>
    </body>
</html>