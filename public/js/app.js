/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


 $(document).ready(function(){
           $(document).on('click', ".add-to-wishlist", function(e) {
                $.ajax({
                    url: "/customer-user/add-to-wish-list",
                    type: "POST",
                    dataType:'json',
                    context: this,
                    data: {product_id: $(this).attr("data-product_id"), user_id : $(this).attr("data-user_id")},
                    success: function(){
                        console.log(1);
                        $(this).text('Remove from wish list').removeClass('add-to-wishlist btn-primary').addClass('remove-from-wishlist btn-danger');                     

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        console.log(xhr);
                        console.log(ajaxOptions);
                        console.log(thrownError);
                     } 
                 });
           
            });
           $(document).on('click', ".remove-from-wishlist", function(e) {
               var editing = $(e.target).attr("data-editing");
               
               $.ajax({
                    url: "/customer-user/remove-from-wish-list",
                    type: "POST",
                    dataType:'json',
                    context: this,
                    data: {'product_id': $(this).attr("data-product_id"), 'user_id': $(this).attr("data-user_id")},
                    success: function(json){
                        console.log(json);
                        $(this).text('add to wish list').addClass('add-to-wishlist btn-primary').removeClass('remove-from-wishlist btn-danger');
                        if(editing) {
                            $($(e.target).parent().parent()).hide("drop", 750, function() {
                                $(this).remove();
                            });
                        }
                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        console.log(xhr);
                        console.log(ajaxOptions);
                        console.log(thrownError);
                     }
                        

                });

                 
            });
            
            /*$(".delete-from-wishlisl-redirect").click(function() {
                $.redirect("/customer-user/remove-from-wish-list",
                    )
            });*/
            
            $(document).on('click', ".add-to-cart", function(e) {
                $.ajax({
                    url: "/customer-user/add-to-cart",
                    type: "POST",
                    dataType:'json',
                    context: this,
                    data: {product_id: $(this).attr("data-product_id"), user_id : $(this).attr("data-user_id")},
                    success: function(data){
                        //data=JSON.parse(data);
                        console.log(data)
                        if (data['success'] =='fail') {
                            alert("out of stock")
                        }
                        else {
                            console.log(1);
                            $('.x-cart-notification').addClass('bring-forward appear loading');
                            setTimeout(function(){
                                $('.x-cart-notification').addClass('added');
                            }, 1400)
                            setTimeout(function(){
                                $('.x-cart-notification').removeClass('bring-forward appear loading added');
                            }, 2800)
                            $(this).removeClass('add-to-cart').addClass('increment-quantity')
                        }

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        console.log(xhr);
                        console.log(ajaxOptions);
                        console.log(thrownError);
                     }
           
                });
            });
            
            $(document).on('click', ".increment-quantity", function(e) {
                $.ajax({
                    url: "/customer-user/increment-quantity",
                    type: "POST",
                    dataType:'json',
                    context: this,
                    data: {product_id: $(this).attr("data-product_id"), user_id : $(this).attr("data-user_id")},
                    success: function(data){
                        console.log(data)
                        if (data['success'] =='fail') {
                            alert("out of stock")
                        }
                        else {
                            console.log(1);
                            $('.x-cart-notification').addClass('bring-forward appear loading');
                            setTimeout(function(){
                                $('.x-cart-notification').addClass('added');
                            }, 1400)
                            setTimeout(function(){
                                $('.x-cart-notification').removeClass('bring-forward appear loading added');
                            }, 2800)
                        }

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        console.log(xhr);
                        console.log(ajaxOptions);
                        console.log(thrownError);
                     }

                    
                
           
                });
            
             });
             var ratingValue;
            $(document).on('change', '[type*="radio"]', function(e) {
                ratingValue = $(this).attr('value');
                $('.submit-rate-button').removeAttr('disabled');
            });
            $(document).on('click', ".submit-rate-button", function(e) {

                $.ajax({
                    url: "/customer-user/put-rate",
                    type: "POST",
                    dataType:'json',
                    context: this,
                    data: {product_id: $(this).attr("data-product_id"), user_id : $(this).attr("data-user_id"), rating : ratingValue},
                    success: function(){
                        $('.rating-form').empty();
                        $('.rating-form').append('<div style="text-align:center;margin-top:20px;"><img style="width:25px;" src="/img/ajax-loader1.gif" ></div>');
                        setTimeout(function(){
                            $('.rating-form').empty();
                            $('.rating-form').append('<div style="margin-top: 20px;" class="alert alert-success"> Thanks for submitting your feedback</div>');
                        }, 1800)
                        setTimeout(function(){
                            location.reload();
                        }, 2600)
                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        console.log(xhr);
                        console.log(ajaxOptions);
                        console.log(thrownError);
                     } 
                 });

            });
            $(document).on('click', ".comment-submit-btn", function(e) {
                $.ajax({
                    url: "/customer-user/add-comment",
                    type: "POST",
                    dataType:'json',
                    context: this,
                    data: {product_id: $('.hidden-button').attr("data-product_id"), user_id : $('.hidden-button').attr("data-user_id"), comment_body : $('.comment-body').val() },
                    success: function(data){
                        console.log(data)
                        $('.comments-list').append('<div style="text-align:center" class="new-comment"><img style="width:25px;" src="/img/ajax-loader1.gif"> </div>');
                        setTimeout(function(){
                            location.reload()
                        },2000) },
//                            $('.new-comment').empty();
//                            $('.new-comment').append( ($('.hidden-button').attr('data-user_name')) + ": " +  $('.comment-body').val());
//                        }, 1800)
                    error:function (xhr, ajaxOptions, thrownError){
                        console.log(xhr);
                        console.log(ajaxOptions);
                        console.log(thrownError);
                     } 
                 });

            });
            $(document).on('click', ".remove-from-cart", function(e) {
                $.ajax({
                    url: "/customer-user/remove-from-cart",
                    type: "POST",
                    dataType:'json',
                    context: this,
                    data: {product_id: $(this).attr("data-product_id"), cart_id : $(this).attr("data-cart_id")},
                    success: function(){
                        console.log(1);
                        $('.x-cart-notification').addClass('bring-forward appear loading');
                        setTimeout(function(){
                            $('.x-cart-notification').addClass('added');
                        }, 1400)
                        setTimeout(function(){
                            $('.x-cart-notification').removeClass('bring-forward appear loading added');
                            location.reload();
                        }, 2800)
                        $(this).removeClass('add-to-cart').addClass('increment-quantity')

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        console.log(xhr);
                        console.log(ajaxOptions);
                        console.log(thrownError);
                     }
           
                });
            });
            
            $(document).on('change', ".cart-product-qty", function(e) {
                $('.update-cart-button').removeAttr('disabled');
            });
            $(document).on('click', ".update-cart-button", function(e) {
                var selected = $('.cart-product-qty');
                var productQty = document.querySelectorAll('.cart-product-qty');
                var productIdArrLen = productQty.length;
                var productArr = [];
                for (var i=0; i < productIdArrLen; i++) {
                    productArr.push({ 'product_id' : productQty[i].getAttribute("data-product_id") , 'product_quantity':productQty[i].value  });   
                }
          
                $.ajax({
                    url: "/customer-user/update-cart",
                    type: "POST",
                    dataType:'json',
                    context: this,
                    data:{'productArr' : productArr, 'cart_id' : productQty[0].getAttribute("data-cart_id") },
                    success: function(){
                        console.log(1);
                        $('.x-cart-notification').addClass('bring-forward appear loading');
                        setTimeout(function(){
                            $('.x-cart-notification').addClass('added');
                        }, 1400)
                        setTimeout(function(){
                            $('.x-cart-notification').removeClass('bring-forward appear loading added');
                            location.reload();
                        }, 2800)
                        $(this).removeClass('add-to-cart').addClass('increment-quantity')

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        console.log(xhr);
                        console.log(ajaxOptions);
                        console.log(thrownError);
                     }
           
                });
            });
             $(document).on('change', "#coupon_code_input", function(e) {
                $('.apply-coupon-btn').removeAttr('disabled');
            });
            $(document).on('click', '.apply-coupon-btn', function(e){
                if ( $('#coupon_code_input').val() == $('.coupon-code-hidden').attr('data-coupon_code') ){
                    var discount = $('.coupon-code-hidden').attr('data-coupon_discount');
                    var subtotal = $('.coupon-code-hidden').attr('data-sub_total');
                     $('.coupon').empty();
                        $('.coupon').append('<div style="text-align:center" ><img style="width:25px;" src="/img/ajax-loader1.gif" ></div>');
                        setTimeout(function(){
                            $('.coupon').empty();
                            $('.coupon').append('<div class="alert-success" style="padding:12px;text-align:center;" > Coupon code is correct ! You can enjoy now the discount </p>');
                            $('.total-amount').empty();
                            $('.total-amount').append(((100 - discount) * subtotal)/100);
                        }, 1800)
                }
                else {
                    $('.coupon-err-msg').empty();
                    $('.coupon-err-msg').append("<div style='text-align:center' class='alert alert-danger'> Coupon code isn't correct </div>");
                }
            })
            $(document).on('click', '.checkout-button', function(e){
                console.log("aijf: " + $(this).attr('data-user_id') + "cart id : " + $(this).attr('data-cart_id'));
                $.ajax({
                    url: "/customer-user/checkout",
                    type: "POST",
                    dataType:'json',
                    data:{'totalAmount' : $('.total-amount').text(), 'subtotal' : $('.subtotal-amount').text() , 'cart_id' : $(this).attr('data-cart_id'), 'user_id' : $(this).attr('data-user_id')  },
                    success: function(){
                        console.log(1);
                        $('.x-cart-notification').addClass('bring-forward appear loading');
                        setTimeout(function(){
                            $('.x-cart-notification').addClass('added');
                        }, 1400)
                        setTimeout(function(){
                            $('.x-cart-notification').removeClass('bring-forward appear loading added');
                            location.reload();
                        }, 2800)
                        $(this).removeClass('add-to-cart').addClass('increment-quantity')

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        console.log(xhr);
                        console.log(ajaxOptions);
                        console.log(thrownError);
                     }
                })
            })
            
            $(".search").change(function() {
                $("form[name=search_form]").submit();
            });
        }); 
    