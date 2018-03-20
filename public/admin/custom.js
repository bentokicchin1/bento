$(document).ready(function($){
  $.ajaxSetup({
    beforeSend: function(xhr, type) {
        if (!type.crossDomain) {
            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
        }
    },
  });

  $('.dropdown').select2({
    width: '100%'
  });

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

  $( "#user" ).on( "change", function() {
    var userId = $("#user").val();
    $.ajax({
      type:'GET',
      url:'/admin/order/getAddress',
      data:{userId:userId},
      success:function(data){
        if ($.trim(data.addressRadio)) {
            $('#addressRadio').html(data.addressRadio);
        }
        if($.trim(data.success)){
            $('#orderRequiredDetails').slideDown();
        }else if ($.trim(data.error)) {
            $('#orderRequiredDetails').slideUp();
            $('#dishDetails').slideUp();
        }
      },
      error:function(){
        console.error();
      }
    });
  });
});
