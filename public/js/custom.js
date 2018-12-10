
 /* jQuery Pre loader
  -----------------------------------------------*/
$(window).on('load',function(){
    $('.preloader').fadeOut(0); // set duration in brackets
});


 /* Google Map
-----------------------------------------------*/
// var map = '';
// var center;

// function initialize() {
//     var mapOptions = {
//       zoom: 16,
//       center: new google.maps.LatLng(13.758468, 100.567481),
//       scrollwheel: false
//     };

//     map = new google.maps.Map(document.getElementById('map-canvas'),  mapOptions);

//     google.maps.event.addDomListener(map, 'idle', function() {
//         calculateCenter();
//     });

//     google.maps.event.addDomListener(window, 'resize', function() {
//         map.setCenter(center);
//     });
// }

// function calculateCenter() {
//   center = map.getCenter();
// }

// function loadGoogleMap(){
//     var script = document.createElement('script');
//     script.type = 'text/javascript';
//     script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' + 'callback=initialize';
//     document.body.appendChild(script);
// }

// $(function(){
//   loadGoogleMap();
// });


/* Istope Portfolio
-----------------------------------------------*/
jQuery(document).ready(function($){

  $('[data-toggle="tooltip"]').tooltip();
  if ( $('.iso-box-wrapper').length > 0 ) {

      var $container  = $('.iso-box-wrapper'),
        $imgs     = $('.iso-box img');

      $container.imagesLoaded(function () {

        $container.isotope({
        layoutMode: 'fitRows',
        itemSelector: '.iso-box'
        });

        $imgs.on('load',function(){
          $container.isotope('reLayout');
        })

      });

      //filter items on button click

      $('.filter-wrapper li a').on('click', function(){

          var $this = $(this), filterValue = $this.attr('data-filter');

      $container.isotope({
        filter: filterValue,
        animationOptions: {
            duration: 0,
            easing: 'linear',
            queue: false,
        }
      });

      // don't proceed if already selected

      if ( $this.hasClass('selected') ) {
        return false;
      }

      var filter_wrapper = $this.closest('.filter-wrapper');
      filter_wrapper.find('.selected').removeClass('selected');
      $this.addClass('selected');

        return false;
      });

  }

});


 /* Navigation Bar
  -----------------------------------------------*/
$(document).ready(function() {
    "use strict";

    // Navbar Sticky


    var cycle = $("input[type=radio][name='billing_cycle']:checked").val();
    if(cycle=='monthly'){
      $('.monthly_preference').show();
    }else {
      $('.monthly_preference').hide();
    }


    (function() {
        var docElem = document.documentElement,
            didScroll = false,
            stickynav = 50;
            document.querySelector( '.nav-container' );
        function init() {
            window.addEventListener( 'scroll', function() {
                if( !didScroll ) {
                    didScroll = true;
                    setTimeout( scrollPage, 0 );
                }
            }, false );
        }

        function scrollPage() {
            var sy = scrollY();
            if ( sy >= stickynav ) {
                $( '.nav-container' ).addClass('sticky');
            }
            else {
                $( '.nav-container' ).removeClass('sticky');
            }
            didScroll = false;
        }

        function scrollY() {
            return window.pageYOffset || docElem.scrollTop;
        }
        init();
    })();

});


$(document).ready(function(){
    "use strict";
    
    console.log($('#area').val());
    if($('#area').val()  != ''){
       areaSectorRelation();
    }

    $('#area').change(function(){
        areaSectorRelation();
    });
    
    function areaSectorRelation(){
        var areaLocations = jQuery.parseJSON(locations);
        var area = $(this).val();
        if(area!=''){
            $('#sector').empty();
            var mySelect = $('#sector');
            mySelect.append(
                $('<option></option>').val('').html('--- Select --- ')
            );
            $.each(areaLocations, function(key, val) {
                if(val['area_id']==area){
                    mySelect.append(
                        $('<option></option>').val(val['id']).html(val['name'])
                    );
                }
            });
        }
    };

    $('input:radio[name=billing_cycle]').on('change',function() {
        if($(this).val()=='monthly'){
          $('.monthly_preference').show();
        }else{
          $('.monthly_preference').hide();
        }
    });

    $('.menu-container').each(function(index) {
        $(this).find('.circle').attr('menu-link', index);
        $(this).find('.list-menu').clone().appendTo('body').attr('menu-link', index);
    });

    $('.menu-container .circle').on('click',function() {
        var linkedVideo = $('section').closest('body').find('.list-menu[menu-link="' + $(this).attr('menu-link') + '"]');
        linkedVideo.toggleClass('reveal-modal');

    });

    $('section').closest('body').find('.close-iframe').on('click',function() {
        $(this).closest('.list-menu').toggleClass('reveal-modal');
    });

    /* wow
    -------------------------------*/
    new WOW({ mobile: false }).init();
    calculateTotal();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        calculateTotal();
    });

    var rules = new Object();
    var messages = new Object();
    $. each($("input[name='days[]']:checked"), function(){
        var inputName = $(this).val();
        rules['grandTotal_'+inputName] = { required:true,min: 45 };
        messages['grandTotal_'+inputName] = {required:'Please select dishes for tiffin', min: 'Min price for tiffin should be greater than 45Rs.' };
    });

    $(".readonly").on('keydown paste', function(e){
        e.preventDefault();
    });


    $('.ordersSelect').select2({
      minimumResultsForSearch: Infinity,
      width : '100%',
      height: '50px'
    });


    $(".dishLists").on('change',function(){
        var dishesData = jQuery.parseJSON(dishes);
        var dishTypeName = $(this).attr('name');
        var selectedDishId = $(this).val();

        var tabName = $(".tab-content div.active").attr('id');
        if(tabName!==undefined){
            var dayName = tabName.replace('tab_','');
            var dishType = dishTypeName.replace('_'+dayName,'');
            var property =  dayName[0].toUpperCase() + dayName.slice(1);
        }else{
            var property = 'dishData';
            var dishType = dishTypeName;
        }
        if(dishesData.hasOwnProperty(property)){
            $(dishesData[property]).each(function(key,dishList) {
              if(dishList['dishTypeName']==dishType){
                  $(dishList).each(function( key,dish) {
                      if(dish['dishPrice'].hasOwnProperty(selectedDishId)){
                        $("[name='basePrice_"+dishTypeName+"']").val(Math.round(dish['dishPrice'][selectedDishId]));
                        calculateTotal();
                        return true;
                      }
                  });
                }
            });
        }
    });

    var quantitiy=0;
    $('.quantity-right-plus').on('click',function(e) {
        e.preventDefault();
        var boxName = $(this).parent().parent().siblings().find('.input-number').attr('name');
        var quantity = parseInt($('[name="'+boxName+'"]').val());
        if(isNaN(quantity)){
          quantity = 1;
          $('[name="'+boxName+'"]').val(quantity);
        }else{
          $('[name="'+boxName+'"]').val(quantity + 1);
        }
        calculateTotal();
    });

    $('.quantity-left-minus').on('click',function(e) {
        e.preventDefault();
        var boxName = $(this).parent().parent().siblings().find('.input-number').attr('name');
        var quantity = parseInt($('[name="'+boxName+'"]').val());
        if(quantity>0){
          $('[name="'+boxName+'"]').val(quantity - 1);
        }
        calculateTotal();
    });

    $('.otherDish').on('change',function(e) {
      calculateTotal();
    });

    function calculateTotal(){
        var orderTotal = 0;
        var dishTotal = 0;
        var tabName = $(".tab-content div.active").attr('id');
        var dayName = (tabName!==undefined) ? tabName.replace('tab_','') : '';
        $(".dishLists").each(function() {
            var dishTypeName = $(this).attr('name');
            if((dishTypeName.includes(dayName) && dayName!='') || dayName==''){
              var quantity = parseInt($('[name="qty_'+dishTypeName+'"]').val());
              var basePrice = parseInt($('[name="basePrice_'+dishTypeName+'"]').val());
              if(!isNaN(quantity) && !isNaN(basePrice)){
                dishTotal = quantity * basePrice;
              }else{
                dishTotal = 0;
              }
              $('[name="price_'+dishTypeName+'"]').val(dishTotal);
              orderTotal = parseInt(orderTotal) + parseInt(dishTotal);
            }
        });
        $(".otherDish").each(function() {
          // alert("otherDish");
            var inputName = $(this).attr('name');
            if((inputName.includes(dayName) && dayName!='') || dayName==''){
              if(tabName!==undefined){
                var dishPriceName = inputName.replace('others_'+dayName+'_','');
              }else{
                var dishPriceName = inputName.replace('others_','');
              }
              if ($('[name="'+inputName+'"]').is(':checked')) {
                orderTotal = parseInt(orderTotal) + parseInt($('[name="'+dishPriceName+'"]').val());
              }
            }
        });
        if(dayName != ''){
          $('#grandTotal_'+dayName).val(Math.round(orderTotal));
        }else{
          $('#grandTotal').val(Math.round(orderTotal));
        }
    }


    $("input[name='days[]']").on('change',function (){
        calculateTotal();
        $(this).each(function (){
            var dayName = $(this).val();
            if($(this).prop('checked')==false){
                $(".otherDish").attr('disabled',true);
                $("input[name$='"+dayName+"']").attr('disabled',true);
                $("[name$='"+dayName+"']").attr('disabled',true);
                $(".quantity-right-plus").attr('disabled',true);
                $(".quantity-left-minus").attr('disabled',true); 
            }else{
                $(".otherDish").removeAttr('disabled');
                $("input[name$='"+dayName+"']").removeAttr('disabled');
                $("[name$='"+dayName+"']").removeAttr('disabled');
                $(".quantity-right-plus").removeAttr('disabled');
                $(".quantity-left-minus").removeAttr('disabled');
            }
        });

        $. each($("input[name='days[]']:checked"), function(){
            var inputName = $(this).val();
            rules['grandTotal_'+inputName] = { min: 45 };
            messages['grandTotal_'+inputName] = { min: 'Min price for tiffin should be greater than 45Rs.' };
        });
    });

    $('#subscribe').on('click',function(){
      $("#subscriptionForm").validate({
          rules: rules,
          messages: messages,
          errorPlacement: function(error, element) {
              error.appendTo(element);
          }
      });
    });

});
