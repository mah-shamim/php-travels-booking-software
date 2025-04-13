<!DOCTYPE html>
<html>
    <!--
    Product:        PHPTRAVELS
    Copyright:      2012 - 2021 @ phptravels.com
    License:        https://phptravels.com/terms-and-conditions/
    Purchase:       https://phptravels.com/order
    Demo:           https://phptravels.com/demo
    -->
    <head>
    <meta charset="utf-8">
    <title><?php echo $page_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="PHPTRAVELS">
    <base href="<?php echo base_url(); ?>" />
    <script>var base_url = '<?php echo base_url(); ?>'; </script>
    <script src="<?php echo base_url(); ?>assets/include/pace/pace.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/include/pace/dataurl.css" rel="stylesheet" />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>uploads/global/favicon.png">
    <link href="<?php echo base_url(); ?>assets/include/loading/loading.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/fa.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet">
    <?php if(empty($dontload)){ ?><script src="<?php echo base_url(); ?>assets/include/ckeditor/ckeditor.js"></script><?php } ?>
    <script src="<?php echo base_url();?>assets/js/jquery-1.11.2.js"></script>
    <link href="<?php echo base_url(); ?>assets/include/alert/css/alert.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/include/alert/themes/default/theme.css" rel="stylesheet" />
    <script src="<?php echo base_url();?>assets/include/alert/js/alert.js"></script>
    <script src="<?php echo base_url();?>assets/include/jquery-form/jquery.form.min.js"></script>
    <!--[if lte IE 8]>
    <script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/excanvas.min.js"></script>
    <![endif]-->
    <link href="<?php echo base_url(); ?>assets/include/select2/select2.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/include/select2/select2-default.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/include/select2/select2.min.js"></script>
    <style>.wrapper .main { margin-top: 55px; } @media screen and (max-width: 480px) { .wrapper .main { margin-top: 100px; } }</style>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-hover-dropdown.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/panels.js"></script>
    <script src="<?php echo base_url(); ?>assets/include/highcharts/highcharts.js"></script>

    <style>
     body{background:#fff;padding-top:40px}
    .header{display:none}
    .footer{display:none}
    .gotop{display:none}
    .navbar-btn{box-shadow:none;outline:none!important;border:0}
    .line{width:100%;height:1px;border-bottom:1px dashed #ddd;margin:40px 0}
    .wrapper{display:flex;align-items:stretch}
    #sidebar{border-right: 1px solid #e5e9ef;min-width:250px;max-width:250px;background-color:#F4F5F7;transition:all .3s;position:fixed;height:100%;z-index:1100;overflow-y:auto;height:100vh}
    #sidebar a,#sidebar a:hover,#sidebar a:focus{color:inherit}
    #sidebar.active{margin-left:-300px}
    #sidebar .sidebar-header{background:#fff;height: 64px;}
    #sidebar .sidebar-header { padding: 15px 10px 5px 10px; margin-bottom: 15px; border-bottom: 1px solid rgba(255, 255, 255, 0.08); }
    /*#sidebar ul.components{padding:5px 0;border-bottom:1px solid rgba(238,238,238,.18)}*/
    #sidebar ul p{color:#fff;padding:10px}
    #sidebar ul li a{ position: relative; -webkit-transition: all .2s ease-in-out; -o-transition: all .2s ease-in-out; transition: all .2s ease-in-out; padding: 8px 0px; font-size: 13px; display: block; text-transform: uppercase; text-decoration: none; padding-left: 55px!important;}
    #sidebar ul li a:hover{background:#005bea;color:#fff}
    /*#sidebar ul li a:hover::before{top: 0px; left: 0px; border-left:4px solid #fff; height: 100%;} */
    #sidebar ul li.active>a,a[aria-expanded="true"]{background:#005bea;color:#fff !important}
    #sidebar ul li.active>a,a[aria-expanded="true"] i{color:#fff !important}
    #sidebar a[data-toggle="collapse"]{position:relative}
    #sidebar a[aria-expanded="false"]::before,#sidebar a[aria-expanded="true"]::before{top: 10px;color: #b2b2b2; content: '\e259'; display: block; position: absolute; right: 25px; font-family: 'Glyphicons Halflings'; font-size: 0.7em;}
    #sidebar a[aria-expanded="true"]::before{content:'\e260'}
    #sidebar ul ul a{font-size:.9em!important;padding-left:25px!important;background:#253858;font-weight:100;color: rgba(240,245,250,0.7) !important; font-weight: 300; text-transform: capitalize;}
    #sidebar ul ul a:hover{background: #091E42; color: #4C9AFF !important; }
    #sidebar a{font-weight:700}
    #sidebar i{margin-top:5px;color:#000;position:absolute;left:25px;font-size:15px}
    ul.CTAs{padding:14px}
    ul.CTAs a{text-align:center!important;font-size:.9em!important;display:block;border-radius:3px;text-align:center;padding-left:15px!important}
    a.download{background:#fff;color:#7386d5}
    a.article{background:#0031bc!important;color:#fff!important;border:2px solid #0031bc}
    a.article:hover{background:#fff!important;color:#0031bc!important;border:2px solid #0031bc}
    #content{background: #fff;`padding:0;min-height:100vh;width:100%;transition:all .3s;overflow-y: hidden; /* Hide vertical scrollbar */ overflow-x: hidden; /* Hide horizontal scrollbar */}
    @media(max-width:768px){#sidebar{margin-left:-300px}
    #sidebar.active{margin-left:0}
    #sidebarCollapse span{display:none}
    #content{padding:20px!important}
    .navbar .container-fluid{padding:0 15px 15px 0!important}
    }
    .navbar-default{height:64px;color:rgba(0,0,0,.87);/*box-shadow:0 3px 14px 2px rgba*/(0,0,0,.12)}
    .navbar-brand { color: #fff !important; height: 45px; min-width: 64px!important; padding: 12px;position:relative }
    .navbar-brand:hover { background: #F0F0F0; color: rgba(245, 246, 255, 0.87); }
    .navbar-nav>li>a{padding-top:12px;padding-bottom:12px;}
    .root{background-image: radial-gradient(circle farthest-side at center bottom,#3056d3,#02269e 150%);color:#fff;padding:35px 0}
    .root i{position:absolute;font-size:32px!important;top:88px;background:rgba(0,0,0,.25882352941176473);padding:17px;border-radius:42px;width:66px;color:#fff!important;text-align:center;margin-left:0}
    .root strong{text-transform:uppercase;letter-spacing:1px;position:relative;margin-bottom:0;display:block;font-size:14px}
    .root p{margin-left:90px;margin-top:-5px;position:relative;margin-bottom:0;font-weight:100;font-size:10px}
    .root a{text-decoration:none}
    .go_left{padding:0 15px 15px 0!important;transition:all .3s}
    .p15{padding:0px!important}
    #content{padding-left:250px}
    .liline li{border-bottom:1px solid #e5e5e5}
    .dropdown .badge{background-color:#ffae1a}
    .dropdown .hides{font-size:9px;letter-spacing:1px}
    a{overflow:hidden}
    .btn{text-transform:uppercase;letter-spacing:0;overflow:hidden;position:relative;-webkit-transition:all .2s ease;-moz-transition:all .2s ease;-o-transition:all .2s ease;transition:all .2s ease;z-index:0}
    .ink{display:block;position:absolute;background:rgba(255,255,255,.3);border-radius:100%;-webkit-transform:scale(0);-moz-transform:scale(0);-o-transform:scale(0);transform:scale(0)}
    .animate{-webkit-animation:ripple .65s linear;-moz-animation:ripple .65s linear;-ms-animation:ripple .65s linear;-o-animation:ripple .65s linear;animation:ripple .65s linear}
    @-webkit-keyframes ripple{100%{opacity:0;-webkit-transform:scale(2.5)}
    }@-moz-keyframes ripple{100%{opacity:0;-moz-transform:scale(2.5)}
    }@-o-keyframes ripple{100%{opacity:0;-o-transform:scale(2.5)}
    }@keyframes ripple{100%{opacity:0;transform:scale(2.5)}
    }
    #social-sidebar-menu ul ul li a{background: #000; color: #fff;}
    </style>

    <script>
    (function($){jQuery.expr[':'].Contains=function(a,i,m){return(a.textContent||a.innerText||"").toUpperCase().indexOf(m[3].toUpperCase())>=0};function FilterMenu(list){var input=$(".filtertxt");$(input).change(function(){var filter=$(this).val();if(filter){$(list).parent().addClass('open');$(list).addClass('in').prop('aria-expanded','true').slideDown();$(list).find('li:Contains('+filter+')').addClass('active');$(list).find('li:not(:Contains('+filter+'))').removeClass('active');$(list).find('li:Contains('+filter+')').show();$(list).find('li:not(:Contains('+filter+'))').hide();$('#social-sidebar-menu').find('li:Contains('+filter+')').show();$('#social-sidebar-menu').find('li:not(:Contains('+filter+'))').hide()}else{$(list).parent().removeClass('open');$(list).removeClass('in').prop('aria-expanded','false').slideUp();$(list).find('li').removeClass('active');$('#social-sidebar-menu').find('li').show()}}).keyup(function(){$(this).change()})}
    $(function(){FilterMenu($("#social-sidebar-menu ul"))})}(jQuery))
    </script>

    <script>
    /* Ripple Effect */
    $(function(){var ink,d,x,y;$("a, button,.ripple").click(function(e){if($(this).find(".ink").length===0){$(this).prepend("<span class='ink'></span>")}
    ink=$(this).find(".ink");ink.removeClass("animate");if(!ink.height()&&!ink.width()){d=Math.max($(this).outerWidth(),$(this).outerHeight());ink.css({height:d,width:d})}
    x=e.pageX-$(this).offset().left-ink.width()/2;y=e.pageY-$(this).offset().top-ink.height()/2;ink.css({top:y+'px',left:x+'px'}).addClass("animate")})});
    </script>
    </head>
    <body>
    <div class="bodyload">
    <div class="rotatingDiv"></div>
    </div>

    <!-- page load effect -->
    <script>
    setTimeout(function() { $('.bodyload').fadeOut(); }, 500);

    // delegate all clicks on "a" tag (links)
    $(document).on("click", ".social-sidebar a,.loadeffect a", function () {
    var newUrl = $(this).attr("href");

    // veryfy if the new url exists or is a hash
    if (!newUrl || newUrl[0] === "#") { location.hash = newUrl; return; }
    $('.bodyload').fadeIn();
    location = newUrl;
    // prevent the default browser behavior.
    return false;
    });

    </script>
    <?=demo_header();?>
    <?php include 'head.php'; ?>
    <div class="wrapper">
    <!--<nav id="sidebar" style="top:0;">
    <?php //include 'sidebar.php'; ?>
    </nav>-->
    <div id="content" style="padding: 0px;">
        <nav class="navbar navbar-default navbar-fixed-top" style="margin-top: 40px; z-index: 1000; top: 0; height: 38px; background: #1f1f1f; color: #fff; width: 100%; margin-left: 0px; border: transparent;">
            <div class="container-fluid">
                <!--<div id="">
                <a id="sidebarCollapse" class="hideSidebar navbar-brand" href="javascript:void(0)" style="position:relative"><i class="fa fa-bars"></i></a>
                </div>-->
                <div class="collapse navbar-collapse" id="nav">
                    <ul class="nav navbar-nav">
                        <li>
                          <a style="margin-left:-12px" href="../" target="_blank"><i class="fa fa-laptop"></i> &nbsp;View Website </a>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <!--<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <div class="btn btn-danger btn-sm"
                                     style="margin-top: -10px; height: 30px; margin-bottom: -14px; border-radius: 0px;">
                                    <i class="fa fa-bell"></i><?php echo $_SESSION["otadata"]->pending_supplier; ?>
                                    Alerts
                                </div>
                            </a>
                        </li>-->
                        <li id="account" class=""><a href="<?php echo base_url().$this->uri->segment(1);?>/profile"><i class="fa fa-user-circle-o"></i> Account</a></li>
                        <li id="logout" class="active"><a href="<?php echo base_url().$this->uri->segment(1);?>/logout"><strong><i class="fa fa-sign-out"></i> Logout</strong></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div style="margin-top:40px"></div>
        <script>
            function pending_accounts() {
                $('li.pending_accounts').hide();
            }
            $(document).ready(function () {
                $("#sidebarCollapse").on("click", function () {
                    $("#sidebar").toggleClass("active");
                    $(".container-fluid").toggleClass("go_left");
                    $("#content").toggleClass("p15");
                    $(this).toggleClass("active");
                });
            });
        </script>
        <script>
        $(function () {
        $('[data-toggle="tooltip"]').tooltip() })
        </script>