/*---------------------------------------------

[Table of Content]

01: Preloader
02: Header top bar menu
02: Responsive Mobile menu
03: Canvas menu open
04: Canvas menu close
05: Dashboard menu
06: window resize
07: Navbar offset top
08: Page scroll anchor menu
09: Back to top button
10: Hotel-card-carousel
11: Car-carousel
12: Trending-carousel
13: Gallery-carousel
14: Client logo
15: Testimonial-carousel
16: Fancybox for video
17: Fancybox for gallery
18: ripple-bg
19: Ui range slider
20: Filer uploader
21: Daterangepicker
22: Bootstrap select picker
23: Bootstrap tooltip
24: Add multiple flight function
25: multi-flight-remove
26: Google map
27: Guests Dropdown
28: mobile dropdown menu
29: Sub menu open
----------------------------------------------*/

(function ($) {
    "use strict";
    var $window = $(window);

    $window.on('load', function () {
        var $document = $(document);
        var $dom = $('html, body');
        var preloader = $('#preloader');
        var dropdownMenu = $('.main-menu-content .dropdown-menu-item');
        var isMenuOpen = false;
        var topNav = document.querySelector('.header-menu-wrapper');
        var scrollTopBtn = $('#back-to-top');
        var scrollLink = $('#single-content-nav .scroll-link');
        var hotelCardCarousel = $('.hotel-card-carousel');
        var hotelCardCarouselTwo = $('.hotel-card-carousel-2');
        var cardImgCarousel = $('.card-img-carousel');
        var carCarousel = $('.car-carousel');
        var trendingCarousel = $('.trending-carousel');
        var galleryCarousel = $('.gallery-carousel');
        var clientCarousel = $('.client-logo');
        var testimonialCarousel = $('.testimonial-carousel');
        var testimonialCarouselTwo = $('.testimonial-carousel-2');
        var fancyVideo = $('[data-fancybox="video"]');
        var fancyGallery = $('[data-fancybox="gallery"]');
        var rippleBg = $('.ripple-bg');
        var masonryGrid = $('.grid-masonry');
        var rangeSlider = $('#slider-range');
        var rangeSliderAmount = $('#amount');
        var rangeSliderTwo = $('#slider-range2');
        var rangeSliderAmountTwo = $('#amount2');
        var fileUploaderInput = $('#filer_input');
        var dateRangePicker = $('input[name="daterange"]');
        var dateRangePickerTwo = $('input[name="daterange-single"]');
        var bootstrapSelectMenu = $('.select-contain-select');
        var numberCounter = $('.counter');
        var fullWidthSlider = $('.full-width-slider');
        var url = window.location.href;
        var domain = url.split('/');
        var price = domain[domain.length - 3];
        var chars = price.split('-');

        /* ======= Preloader ======= */
        preloader.delay('180').fadeOut(200);

        /*=========== Header top bar menu ============*/
        $document.on('click', '.down-button', function () {
            $(this).toggleClass('active');
            $('.header-top-bar').slideToggle(200);
        });

        /*=========== Responsive Mobile menu ============*/
        $document.on('click', '.menu-toggler', function () {
            $(this).toggleClass('active');
            $('.main-menu-content').slideToggle(200);
        });

        /*=========== Dropdown menu ============*/
        dropdownMenu.parent('li').children('a').append(function() {
            return '<button class="drop-menu-toggler" type="button"><i class="la la-angle-down"></i></button>';
        });

        /*=========== Dropdown menu ============*/
        $document.on('click', '.main-menu-content .drop-menu-toggler', function() {
            var Self = $(this);
            Self.parent().parent().children('.dropdown-menu-item').toggle();
            return false;
        });

        /*=========== Sub menu ============*/
        $('.main-menu-content .dropdown-menu-item .sub-menu').parent('li').children('a').append(function() {
            return '<button class="sub-menu-toggler" type="button"><i class="la la-plus"></i></button>';
        });

        /*=========== Dropdown menu ============*/
        $document.on('click', '.main-menu-content .dropdown-menu-item .sub-menu-toggler', function() {
            var Self = $(this);
            Self.parent().parent().children('.sub-menu').toggle();
            return false;
        });

        /*=========== Canvas menu open ============*/
        $document.on('click', '.user-menu-open', function () {
            $('.user-canvas-container').addClass('active');
        });

        /*=========== Canvas menu close ============*/
        $document.on('click', '.side-menu-close', function () {
            $('.user-canvas-container, .sidebar-nav').removeClass('active');
        });

        /*=========== Dashboard menu ============*/
        $document.on('click', '.menu-toggler', function () {
            $('.sidebar-nav').toggleClass('active');
        });

        /*=========== When window will resize then this action will work ============*/
        $window.on('resize', function () {
            if ($window.width() > 991) {
                $('.main-menu-content').show();
                $('.dropdown-menu-item').show();
                $('.sub-menu').show();
                $('.header-top-bar').show();
            }else {
                if (isMenuOpen) {
                    $('.main-menu-content').show();
                    $('.dropdown-menu-item').show();
                    $('.sub-menu').show();
                    $('.header-top-bar').show();
                }else {
                    $('.main-menu-content').hide();
                    $('.dropdown-menu-item').hide();
                    $('.sub-menu').hide();
                    $('.header-top-bar').hide();
                }
            }
        });

        /*=========== Navbar offset top ============*/
        if($(topNav).length) {
            var topOfNav = topNav.offsetTop;
        }

        $window.on('scroll', function () {

            if ($window.scrollTop() >= topOfNav) {
                document.body.style.paddingTop = topNav.offsetHeight + 'px';
                document.body.classList.add('fixed-nav');
            }
            else {
                document.body.style.paddingTop = '0px';
                document.body.classList.remove('fixed-nav');
            }

            //back to top button control
            if ($window.scrollTop() > 500) {
                $(scrollTopBtn).addClass('active');
            } else {
                $(scrollTopBtn).removeClass('active');
            }

            //page scroll position
            findPosition();

        });

        /*========== Page scroll ==========*/

        scrollLink.on('click',function(e){
            var target = $($(this).attr('href'));

            $($dom).animate({
                scrollTop:target.offset().top
            },600);

            $(this).addClass('active');

            e.preventDefault();
        });

        function findPosition (){
            $('.page-scroll').each(function(){
                if(($(this).offset().top - $(window).scrollTop()) < 20){
                    scrollLink.removeClass('active');
                    $('#single-content-nav').find('[data-scroll="'+ $(this).attr('id') +'"]').addClass('active');
                }
            });
        }

        /*===== Back to top button ======*/
        $document.on("click", "#back-to-top", function() {
            $($dom).animate({
                scrollTop: 0
            }, 800);
            return false;
        });

        /*==== Hotel-card-carousel =====*/
        if ($(hotelCardCarousel).length) {
            $(hotelCardCarousel).owlCarousel({
                loop: true,
                items: 4,
                nav: true,
                dots: true,
                smartSpeed: 700,
                autoplay: false,
                active: true,
                margin: 30,
                navText: ['<i class="la la-angle-left"></i>', '<i class="la la-angle-right"></i>'],
                responsive : {
                    // breakpoint from 0 up
                    0 : {
                        items: 1
                    },
                    // breakpoint from 991 up
                    768 : {
                        items: 2
                    },
                    // breakpoint from 992 up
                    992 : {
                        items: 3
                    },
                    // breakpoint from 1441 up
                    1441 : {
                        items: 4
                    }
                }
            });
        }

        /*==== Hotel-card-carousel 2 =====*/
        if ($(hotelCardCarouselTwo).length) {
            $(hotelCardCarouselTwo).owlCarousel({
                loop: true,
                items: 3,
                nav: true,
                dots: true,
                smartSpeed: 700,
                autoplay: false,
                active: true,
                margin: 30,
                navText: ['<i class="la la-angle-left"></i>', '<i class="la la-angle-right"></i>'],
                responsive : {
                    // breakpoint from 0 up
                    0 : {
                        items: 1
                    },
                    // breakpoint from 991 up
                    768 : {
                        items: 2
                    },
                    // breakpoint from 992 up
                    992 : {
                        items: 3
                    },
                }
            });
        }

        /*==== card-img-carousel =====*/
        if ($(cardImgCarousel).length) {
            $(cardImgCarousel).owlCarousel({
                loop: true,
                items: 1,
                nav: true,
                dots: true,
                smartSpeed: 700,
                autoplay: false,
                active: true,
                margin: 30,
                navText: ['<i class="la la-angle-left"></i>', '<i class="la la-angle-right"></i>']
            });
        }

        /*==== Car-carousel =====*/
        if ($(carCarousel).length) {
            $(carCarousel).owlCarousel({
                loop: true,
                items: 3,
                nav: true,
                dots: true,
                smartSpeed: 700,
                autoplay: false,
                active: true,
                margin: 30,
                navText: ['<i class="la la-angle-left"></i>', '<i class="la la-angle-right"></i>'],
                responsive : {
                    // breakpoint from 167 up
                    0 : {
                        items: 1
                    },
                    // breakpoint from 768 up
                    768 : {
                        items: 2
                    },
                    // breakpoint from 992 up
                    992 : {
                        items: 3
                    }
                }
            });
        }

        /*==== Trending-carousel =====*/
        if ($(trendingCarousel).length) {
            $(trendingCarousel).owlCarousel({
                loop: true,
                items: 3,
                nav: true,
                dots: true,
                smartSpeed: 700,
                autoplay: false,
                margin: 30,
                navText: ['<i class="la la-long-arrow-left"></i>', '<i class="la la-long-arrow-right"></i>'],
                responsive : {
                    // breakpoint from 0 up
                    0 : {
                        items: 1
                    },
                    // breakpoint from 768 up
                    768 : {
                        items: 2
                    },
                    // breakpoint from 992 up
                    992 : {
                        items: 3
                    }
                }
            });
        }

        /*==== Gallery-carousel =====*/
        if ($(galleryCarousel).length) {
            $(galleryCarousel).owlCarousel({
                loop: true,
                items: 1,
                nav: true,
                dots: true,
                smartSpeed: 700,
                margin: 20,
                navText: ['<i class="la la-long-arrow-left"></i>', '<i class="la la-long-arrow-right"></i>']
            });
        }

        /*==== Client logo =====*/
        if ($(clientCarousel).length) {
            $(clientCarousel).owlCarousel({
                loop: true,
                items: 6,
                nav: false,
                dots: false,
                smartSpeed: 700,
                autoplay: true,
                responsive : {
                    // breakpoint from 0 up
                    0 : {
                        items: 1
                    },
                    // breakpoint from 425 up
                    425 : {
                        items: 2
                    },
                    // breakpoint from 480 up
                    480 : {
                        items: 2
                    },
                    // breakpoint from 767 up
                    767 : {
                        items: 4
                    },
                    // breakpoint from 992 up
                    992 : {
                        items: 6
                    }
                }
            });
        }

        /*==== testimonial-carousel =====*/
        if ($(testimonialCarousel).length) {
            $(testimonialCarousel).owlCarousel({
                loop: true,
                items: 2,
                nav: true,
                dots: false,
                smartSpeed: 700,
                autoplay: false,
                margin: 30,
                navText: ['<i class="la la-angle-left"></i>', '<i class="la la-angle-right"></i>'],
                responsive : {
                    // breakpoint from 0 up
                    0 : {
                        items: 1
                    },
                    // breakpoint from 900 up
                    900 : {
                        items: 2
                    }

                }
            });
        }

        /*==== testimonial-carousel-2 =====*/
        if ($(testimonialCarouselTwo).length) {
            $(testimonialCarouselTwo).owlCarousel({
                loop: true,
                items: 3,
                nav: true,
                dots: true,
                smartSpeed: 700,
                autoplay: false,
                margin: 30,
                navText: ['<i class="la la-long-arrow-left"></i>', '<i class="la la-long-arrow-right"></i>'],
                responsive : {
                    // breakpoint from 0 up
                    0 : {
                        items: 1
                    },
                    // breakpoint from 768 up
                    768 : {
                        items: 2
                    },
                    // breakpoint from 992 up
                    992 : {
                        items: 3
                    }
                }
            });
        }

        /*==== Fancybox for video =====*/
        if ($(fancyVideo).length) {
            $(fancyVideo).fancybox({
                buttons: [
                    "share",
                    "fullScreen",
                    "close"
                ]
            });
        }

        /*==== Fancybox for gallery =====*/
        if ($(fancyGallery).length) {
            $(fancyGallery).fancybox({
                buttons: [
                    "share",
                    "slideShow",
                    "fullScreen",
                    "download",
                    "thumbs",
                    "close"
                ]
            });
        }

        /*====  Ripple-bg =====*/
        if ($(rippleBg).length) {
            $(rippleBg).ripples({
                resolution: 500,
                dropRadius: 20,
                perturbance: 0
            });
        }

        if ($(masonryGrid).length) {
            $(masonryGrid).masonry({});
        }

        /*======= ui price range slider ========*/
        if ($(rangeSlider).length) {
            $(rangeSlider).slider({
                range: true,
                min: 0,
                max: 1000,
                values: [ 40, 800 ],
                slide: function( event, ui ) {
                    $(rangeSliderAmount).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                }
            });
        }
        $(rangeSliderAmount).val( "$" + $(rangeSlider).slider( "values", 0 ) +
            " - $" + $(rangeSlider).slider( "values", 1 ) );

        /*======= ui price range slider 2 ========*/
        if ($(rangeSliderTwo).length) {

            $(rangeSliderTwo).slider({

                range: true,
                min: 0,
                max:20,
                values: [ 0, 20 ],
                slide: function( event, ui ) {
                    $(rangeSliderAmountTwo).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                }
            });
        }

        $(rangeSliderAmountTwo).val( "$" + $(rangeSliderTwo).slider( "values", 0 ) +
            " - $" + $(rangeSliderTwo).slider( "values", 1 ) );


        /*==== Filer uploader =====*/
        if ($(fileUploaderInput).length) {
            $(fileUploaderInput).filer({
                limit: 10,
                maxSize: 100,
                showThumbs: true
            });
        }

        /*==== counter =====*/
        if(numberCounter.length) {
            numberCounter.countTo({
                speed: 1200
            });
        }

        /*==== Bootstrap tooltip =====*/
        if ($('[data-toggle="tooltip"]').length) {
            $('[data-toggle="tooltip"]').tooltip();
        }

        /*==== When you will click the add another flight btn then this action will be work =====*/
        $document.on('click', '.add-flight-btn', function () {

            if ( $('.multi-flight-field').length < 5 ) { 
            $('.multi-flight-field:last').clone().insertAfter('.multi-flight-field:last');
            }
            // init date picker with every new clone
            $('.dp').datepicker({ format: 'dd-mm-yyyy', onRender: function(date) { return date.valueOf() < now.valueOf() ? 'disabled' : ''; } }).on('changeDate', function(ev){ $(this).datepicker('hide'); });

            $('.autocomplete-airport').each(function(){var ac=$(this);ac.on('click',function(e){e.stopPropagation()}).on('focus keyup',search).on('keydown',onKeyDown);var wrap=$('<div>').addClass('autocomplete-wrapper').insertBefore(ac).append(ac);var list=$('<div>').addClass('autocomplete-results troll').on('click','.autocomplete-result',function(e){e.preventDefault();e.stopPropagation();selectIndex($(this).data('index'),ac)}).appendTo(wrap);var counter=0;counter++;$(".autocomplete-wrapper").addClass("_"+counter);$(".autocomplete-airport").focus(function(){$(ac).toggleClass("yes");$(".autocomplete-result").closest(".autocomplete-results").addClass("in")})});$(document).on('mouseover','.autocomplete-result',function(e){var index=parseInt($(this).data('index'),10);if(!isNaN(index)){$(this).attr('data-highlight',index)}}).on('click',clearResults);function clearResults(){results=[];numResults=0;$('.autocomplete-results').empty()}
            function selectIndex(index,autoinput){if(results.length>=index+1){autoinput.val(results[index].iata+" - "+results[index].name+" - "+results[index].city);clearResults()}}
            var results=[];var numResults=0;var selectedIndex=-1;function search(e){if(e.which===38||e.which===13||e.which===40){return}
            var ac=$(e.target);var list=ac.next();if(ac.val().length>0){results=_.take(fuse.search(ac.val()),7);numResults=results.length;var divs=results.map(function(r,i){return'<div class="autocomplete-result" data-index="'+i+'">'+'<div><i class="mdi mdi-flight-takeoff"></i><b>'+r.iata+'</b><strong> '+r.name+'</strong></div>'+'<div class="autocomplete-location">'+r.city+', '+r.country+'</div>'+'</div>'});selectedIndex=-1;list.html(divs.join('')).attr('data-highlight',selectedIndex)}else{numResults=0;list.empty()}}
            function onKeyDown(e){var ac=$(e.currentTarget);var list=ac.next();switch(e.which){case 38:selectedIndex--;if(selectedIndex<=-1){selectedIndex=-1}
            list.attr('data-highlight',selectedIndex);break;case 13:selectIndex(selectedIndex,ac);break;case 9:selectIndex(selectedIndex,ac);e.stopPropagation();return;case 40:selectedIndex++;if(selectedIndex>=numResults){selectedIndex=numResults-1}
            list.attr('data-highlight',selectedIndex);break;default:return}
            e.stopPropagation();e.preventDefault()}
            var counter=0;$(".autocomplete-wrapper").each(function(){counter++;var self=$(this);self.addClass("row_"+counter);var tdCounter=0;self.find('.autocomplete-results').each(function(index){$(".autocomplete-wrapper").find(".autocomplete-results").addClass("intro")})});$('.ro-select').filter(function(){var $this=$(this),$sel=$('<ul>',{'class':'ro-select-list'}),$wr=$('<div>',{'class':'ro-select-wrapper'}),$inp=$('<input>',{type:'hidden',name:$this.attr('name'),'class':'ro-select-input'}),$text=$('<div>',{'class':'ro-select-text ro-select-text-empty',text:$this.attr('placeholder')});$opts=$this.children('option');$text.click(function(){$sel.show()});$opts.filter(function(){var $opt=$(this);$sel.append($('<li>',{text:$opt.text(),'class':'ro-select-item'})).data('value',$opt.attr('value'))});$sel.on('click','li',function(){$text.text($(this).text()).removeClass('ro-select-text-empty');$(this).parent().hide().children('li').removeClass('ro-select-item-active');$(this).addClass('ro-select-item-active');$inp.val($this.data('value'))});$wr.append($text);$wr.append($('<i>',{'class':'fa fa-caret-down ro-select-caret'}));$this.after($wr.append($inp,$sel));$this.remove()})
 
            $(this).closest('.multi-flight-wrap').find('.multi-flight-field:last').children('.multi-flight-delete-wrap').show();

        });

                

        /*=========== multi-flight-remove ============*/
        $document.on('click', '.multi-flight-remove', function() {
            console.log("removed");
            
            $('.multi-flight-remove').closest('.multi-flight-wrap').find('.multi-flight-field').not(':first').last().remove();
        });

        /*====  mobile dropdown menu  =====*/
        $document.on('click', '.toggle-menu > li .toggle-menu-icon', function (e) {
            e.preventDefault();
            $(this).closest('li').siblings().removeClass('active').find('.toggle-drop-menu, .dropdown-menu-item').slideUp(200);
            $(this).closest('li').toggleClass('active').find('.toggle-drop-menu, .dropdown-menu-item').slideToggle(200);
            return false;
        });

        /*====== Dropdown btn ======*/
        $('.dropdown-btn').on('click', function (e) {
            e.preventDefault();
            $(this).next('.dropdown-menu-wrap').slideToggle(300);
            e.stopPropagation();
        });

        /*====== When you click on the out side of dropdown menu item then its will be hide ======*/
        $document.on('click', function(event){
            var $trigger = $('.dropdown-contain');
            if($trigger !== event.target && !$trigger.has(event.target).length){
                $('.dropdown-menu-wrap').slideUp(300);
            }
        });

        $('.progressbar-line').each(function(){
            $(this).find('.progressbar-line-item').animate({
                width:$(this).attr('data-percent')
            },6000);
        });

        if ($(fullWidthSlider).length) {
            $(fullWidthSlider).owlCarousel({
                center: true,
                items: 2,
                nav: true,
                dots: false,
                loop: true,
                margin: 10,
                smartSpeed: 500,
                navText: ['<i class="la la-long-arrow-left"></i>', '<i class="la la-long-arrow-right"></i>'],
                responsive:{
                    0:{
                        items:1,
                        autoplay: true
                    },
                    576:{
                        items:2
                    }
                }
            });
        }


    });

})(jQuery);

