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
                    success: function(){
                        console.log(1);
                        $('.x-cart-notification').addClass('bring-forward appear loading');
                        setTimeout(function(){
                            $('.x-cart-notification').addClass('added');
                        }, 1400)
                        setTimeout(function(){
                            $('.x-cart-notification').removeClass('bring-forward appear loading added');
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
            
            $(document).on('click', ".increment-quantity", function(e) {
                $.ajax({
                    url: "/customer-user/increment-quantity",
                    type: "POST",
                    dataType:'json',
                    context: this,
                    data: {product_id: $(this).attr("data-product_id"), user_id : $(this).attr("data-user_id")},
                    success: function(){
                        console.log(1);
                        $('.x-cart-notification').addClass('bring-forward appear loading');
                        setTimeout(function(){
                            $('.x-cart-notification').addClass('added');
                        }, 1400)
                        setTimeout(function(){
                            $('.x-cart-notification').removeClass('bring-forward appear loading added');
                        }, 2800)

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
                        $('.rating-form').append('<img style="width:60px;" src="/img/ajax-loader1.gif" >');
                        setTimeout(function(){
                            $('.rating-form').empty();
                            $('.rating-form').append('<p style="font-size: 20px" > Thanks for submitting your feedback</p>');
                        }, 1800)

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
                        $('.comments-list').append('<div class="new-comment"><img style="width:30px;" src="/img/ajax-loader1.gif"> </div>');
                        setTimeout(function(){
                            $('.new-comment').empty();
                            $('.new-comment').append( ($('.hidden-button').attr('data-user_name')) + ": " +  $('.comment-body').val());
                        }, 1800)

                    },
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
                var productIdArr = document.querySelectorAll('.cart-product-qty')[0].getAttribute('data-product_id');
                console.log(productIdArr);
                var cartId  =document.querySelectorAll('.cart-product-qty')[0].getAttribute('data-cart_id');
                console.log(cartId)
          
                $.ajax({
                    url: "/customer-user/update-cart",
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
        });
    