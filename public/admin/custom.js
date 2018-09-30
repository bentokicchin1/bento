$(document).ready(function($){
  $.ajaxSetup({
    beforeSend: function(xhr, type) {
        if (!type.crossDomain) {
            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
        }
    },
  });

  $('[data-toggle="tooltip"]').tooltip();

  $("#orderDate").datepicker({
    startDate:new Date(),
    autoclose : true,
    format : 'DD, d MM, yyyy'
  });

  $( "#orderDate,#orderTypeId" ).on( "change", function() {
    var orderTypeId = $("#orderTypeId").val();
    var orderDate = $("#orderDate").val();
    if(orderTypeId=='' || orderDate==''){
      return false;
    }
    $.ajax({
      type:'POST',
      url:'/admin/order/getDishList',
      data:{orderTypeId:orderTypeId, orderDate:orderDate},
      success:function(data){
        if (!$.trim(data.dishDetails)){
            $('#dishDetails').slideDown();
            $('#dishDetails').html("Please add menu for this day.");
        }
        else{
            $('#dishDetails').slideDown();
            $('#dishDetails').html(data.dishDetails);
            $('.dropdown').select2({
              width: '100%'
            });
        }
      },
      error:function(){
        console.error();
      }
    });
  });

  calculateTotal();


  $(".dishLists").on('change',function(){
      calculateTotal();
  });

  $('.otherDish').on('change',function(e) {
    calculateTotal();
  });

  $('.orderQuantity').on('change',function(e) {
    calculateTotal();
  });
  // $( "#user" ).on( "change", function() {
  //   var userId = $("#user").val();
  //   $.ajax({
  //     type:'GET',
  //     url:'/admin/order/getAddress',
  //     data:{userId:userId},
  //     success:function(data){
  //       if ($.trim(data.addressRadio)) {
  //           $('#addressRadio').html(data.addressRadio);
  //       }
  //       if($.trim(data.success)){
  //           $('#orderRequiredDetails').slideDown();
  //       }else if ($.trim(data.error)) {
  //           $('#orderRequiredDetails').slideUp();
  //           $('#dishDetails').slideUp();
  //       }
  //     },
  //     error:function(){
  //       console.error();
  //     }
  //   });
  // });

  function calculateTotal(){
      var orderTotal = 0;
      var dishTotal = 0;
      $(".dishLists").each(function() {
          var dishTypeName = $(this).attr('name');
          var quantity = parseInt($('[name="qty_'+dishTypeName+'"]').val());
          var basePrice = parseInt($('[name="basePrice_'+dishTypeName+'"]').val());
          if(!isNaN(quantity) && !isNaN(basePrice)){
            dishTotal = quantity * basePrice;
          }else{
            dishTotal = 0;
          }
          $('[name="price_'+dishTypeName+'"]').val(dishTotal);
          orderTotal = parseInt(orderTotal) + parseInt(dishTotal);
      });
      $(".otherDish").each(function() {
          var inputName = $(this).attr('name');
          var dishPriceName = inputName.replace('others_','');
          if ($('[name="'+inputName+'"]').is(':checked')) {
            orderTotal = parseInt(orderTotal) + parseInt($('[name="'+dishPriceName+'"]').val());
          }
      });
      // alert(orderTotal);
      $('#grandTotal').val(Math.round(orderTotal));
  }
});
