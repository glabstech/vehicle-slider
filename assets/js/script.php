<?php

  $carID = '';
  if( isset( $_GET['carid'] ) ) {
    $carID = $_GET['carid'];
  }

?>

(function($) {

    function JSONdata() {
      var l = window.location;
      var base_url = l.protocol + "//" + l.host;
      console.log(base_url);

        var url = base_url+"/wp-admin/admin-ajax.php?action=gltv_request_ajax&carid=<?php echo $carID; ?>";

        var gwapo = $.getJSON(url, function(data) {
            cars = data.cars;
            gltCarousel();
            carouselData();
            carouselInit();
            carouselBullets();
            clickUrl();
            clickColorSelector();
        });
    }

    function gltCarousel() {
        carSelected = 0;
        var carsNum = cars.length;

        $(document).on('click', '#next', function() {
          carsw = carsNum - 1;
          if (carSelected >= carsw) {
              carSelected = carsw;
          } else {
              carSelected++;
          }
          carouselProcess();
        });

        $(document).on('click', '#prev', function() {
          if (carSelected <= 0) {
              carSelected = 0;
          } else {
              carSelected--;
          }
          carouselProcess();
        });
    }

    function carouselData() {
        $('.header').remove();
        $('.buttons-wrapper').remove();
        $('.car-brand').remove();

        var $buttonPrev = "<button type='button' name='button' id='prev'>Prev Car</button>";
        var $buttonNext = "<button type='button' name='button' id='next'>Next Car</button>";
        var $buttons = $buttonPrev + $buttonNext;
        var $div = "<div class='buttons-wrapper'>"+$buttons+"</div>";
        var c_brand = (cars[carSelected]['car_name']);
        $($div).appendTo('.slider-area');
        $('<div class="car-brand">'+c_brand+'</div>').prependTo('.slider-area');

        for (var c = 0; c < cars[carSelected]['car_color_variations'].length; c++) {
            var c_1 = cars[carSelected].car_name;
            var c_name = (cars[carSelected]['car_color_variations'][c]['color_name']);
            var c_hex = (cars[carSelected]['car_color_variations'][c]['color_hex']);
            var c_car_image = (cars[carSelected]['car_color_variations'][c]['color_url']);
            var c_car_url = (cars[carSelected]['car_color_variations'][c]['color_url']);

            $fixture = $([
                "<div data-id='" + (carSelected + 1) + "'>",
                "<figure>",
                "<a href=" + c_car_url + " class='link-to-post'></a>",
                "<div class='img-wrap'>",
                "<img itemprop='image' src=" + c_car_url + ">",
                "</div>",
                "<figcaption>",
                "<div class='thumb-info'>",
                "<h4 itemprop='car_attr'>" + c_name + ' ' + c_1 + "</h4>",
                "<span itemprop='car_attr' data-color=" + c_name +" data-hex=" + '#'+c_hex + "></span>",
                "</div>",
                "</figcaption>",
                "</figure>",
                "</div>"
            ].join("\n"));
            $fixture.appendTo('#owl-demo')
        }

        // Hides Buttons if Only 1 Car Type
        if (cars.length == 1) {
            $('.slider-area button').hide();
        } else {
            $('.slider-area button').show();
        }
    }

    function carouselInit() {
        var carousel_type = cars[carSelected].carousel_type;

        $('#owl-demo').owlCarousel({
            loop: false,
            margin: 10,
            nav: false,
            singleItem:true,
            slideSpeed : 10,
            paginationSpeed : 10,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
        $('.owl-dots').wrap("<div class='owl-controls'></div>");

        if (carousel_type === 'Pop-up') {
            $('.owl-stage').hide();
            $('<div class="main-image"><img src=" ' + cars[carSelected].car_default_image + '"></div>').prependTo('.owl-stage-outer');
        }

    }

    function carouselReinit() {
        $('#owl-demo').owlCarousel('destroy');
        $('#owl-demo').html('');
    }

    function carouselBullets() {
        $("#owl-demo .owl-item").each(function(index) {
            var me = $(this);
            var color_name = me.find("span[itemprop='car_attr']").data("color");
            var color_hex = me.find("span[itemprop='car_attr']").data("hex");
            console.log(color_hex);
            var idx = me.index();

            //new owl carousel control support
            var bullet = $(me).closest('.owl-carousel').find('.owl-controls .owl-pagination .owl-page');
            bullet.eq(idx).find("span").css("background-color", color_hex);
            
            //old owl carousel control support
            bullet = $(me).closest('.owl-carousel').find('.owl-controls .owl-dots .owl-dot');
            bullet.eq(idx).find("span").css("background-color", color_hex);
        });
    }

    function clickUrl() {
        $('figure').click(function() {
            var urlRedirect = $('.owl-item.active').find('div').closest('figure').find('a').attr('href');
            alert(urlRedirect);
        });
    }

    function clickColorSelector() {
        var hasClose = $('.color-carousel-close').length;
        var isPopup = cars[carSelected].carousel_type;
        if (hasClose === 0 && isPopup === 'Pop-up') {
            $(".owl-controls .owl-dot").click(function() {
                $('.color-carousel-close').remove();
                $('<div class="color-carousel-close"><i class="ss-delete"></i></div>').prependTo('.owl-stage-outer');
                $('.owl-stage').show();
                $('.main-image').hide();
            });
        }
        $(document).on('click', '.color-carousel-close', function() {
            $('.owl-stage').hide();
            $('.main-image').show();
            carouselProcess();
            $(this).remove();
        });
    }

    function carouselProcess() {
        carouselReinit();
        carouselData();
        carouselInit();
        carouselBullets();
        clickUrl();
        clickColorSelector();
    }

    // INITIALIZATION
    $(document).ready(function() {
        JSONdata();
    });


}(window.jQuery || window.$));
