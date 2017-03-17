/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


 $(document).ready(function(){
           $(document).on('click', ".add-to-wishlist", function(e) {
                $.ajax({
                    url: "/customer-user/add-to-wish-list",
                    type: "GET",
                    dataType:'json',
                    context: this,
                    data: {product_id: $(this).attr("data-product_id"), user_id : $(this).attr("data-user_id")},
                    success: function(){
                        console.log(1);
                        $(this).text('Remove wish list').removeClass('add-to-wishlist btn-primary').addClass('remove-from-wishlist btn-danger');                     

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        console.log(xhr);
                        console.log(ajaxOptions);
                        console.log(thrownError);
                     } 
                 });
           
            });
           $(document).on('click', ".remove-from-wishlist", function(e) {
               $.ajax({
                    url: "customer-user/remove-from-wish-list",
                    type: "POST",
                    dataType:'json',
                    context: this,
                    data: {'product_id': $(this).attr("data-product_id"), 'user_id': $(this).attr("data-user_id")},
                    success: function(json){
                        $(this).text('add to wish list').addClass('add-to-wishlist btn-primary').removeClass('remove-from-wishlist btn-danger');

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        console.log(xhr);
                        console.log(ajaxOptions);
                        console.log(thrownError);
                     }
                        

                });

                 
            });
            $(document).on('click', ".add-to-cart", function(e) {
                $.ajax({
                    url: "/customer-user/add-to-cart",
                    type: "GET",
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
                        $(this).removeClass('add-to-cart').addClass('update-cart')

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                        console.log(xhr);
                        console.log(ajaxOptions);
                        console.log(thrownError);
                     }
           
                });
            });
            
            $(document).on('click', ".update-cart", function(e) {
                $.ajax({
                    url: "/customer-user/update-cart",
                    type: "GET",
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
     
        });
    