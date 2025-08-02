<script>
    $("#offcanvasWithBothOptions #save").click(function(e){
        e.preventDefault();

        $.ajax({
            url: "{{url('admin/admins/store')}}",
            type: 'POST',
            processData: false,
            contentType: false,
            data: new FormData($('#offcanvasWithBothOptions #form')[0]),
            success: function(res){
                $("#offcanvasWithBothOptions").offcanvas('hide');
                $('#datatable').DataTable().ajax.reload( null, false );
                $("#offcanvasWithBothOptions form bold[class=text-danger]").css('display', 'none');
                
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.success("تمت الإضافة بنجاح! ✔️🎯");

            },
            error: function(res){
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");

                if(res.responseJSON.errors.name){
                    $("form #errors-name").css('display' , 'block').text(res.responseJSON.errors.name);
                }else{
                    $("form #errors-name").text('');
                }
                if(res.responseJSON.errors.user_name){
                    $("form #errors-user_name").css('display' , 'block').text(res.responseJSON.errors.user_name);
                }else{
                    $("form #errors-user_name").text('');
                }
                if(res.responseJSON.errors.phone){
                    $("form #errors-phone").css('display' , 'block').text(res.responseJSON.errors.phone);
                }else{
                    $("form #errors-phone").text('');
                }
                if(res.responseJSON.errors.password){
                    $("form #errors-password").css('display' , 'block').text(res.responseJSON.errors.password);
                }else{
                    $("form #errors-password").text('');
                }
                if(res.responseJSON.errors.confirmed_password){
                    $("form #errors-confirmed_password").css('display' , 'block').text(res.responseJSON.errors.confirmed_password);
                }else{
                    $("form #errors-confirmed_password").text('');
                }
                if(res.responseJSON.errors.nat_id){
                    $("form #errors-nat_id").css('display' , 'block').text(res.responseJSON.errors.nat_id);
                }else{
                    $("form #errors-nat_id").text('');
                }
                if(res.responseJSON.errors.email){
                    $("form #errors-email").css('display' , 'block').text(res.responseJSON.errors.email);
                }else{
                    $("form #errors-email").text('');
                }
            }
        });
    });


    ///////////////////////////////// Add By Button Enter /////////////////////////////////
    $("#form").keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        
            $.ajax({
                url: "{{url('admin/admins/store')}}",
                type: 'POST',
                processData: false,
                contentType: false,
                data: new FormData($('#offcanvasWithBothOptions #form')[0]),
                // data: $("#offcanvasWithBothOptions #form").serialize(),
                success: function(res){
                    $("#offcanvasWithBothOptions").offcanvas('hide');
                    $('#datatable').DataTable().ajax.reload( null, false );

                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 4);
                    alertify.success("@lang('app.Completed Added Successfully')");

                },
                error: function(res){
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 4);
                    alertify.error("@lang('app.there is something wrong')");

                    if(res.responseJSON.errors.name){
                        $("form #errors-name").css('display' , 'block').text(res.responseJSON.errors.name);
                    }else{
                        $("form #errors-name").text('');
                    }
                    if(res.responseJSON.errors.user_name){
                        $("form #errors-user_name").css('display' , 'block').text(res.responseJSON.errors.user_name);
                    }else{
                        $("form #errors-user_name").text('');
                    }
                    if(res.responseJSON.errors.phone){
                        $("form #errors-phone").css('display' , 'block').text(res.responseJSON.errors.phone);
                    }else{
                        $("form #errors-phone").text('');
                    }
                    if(res.responseJSON.errors.password){
                        $("form #errors-password").css('display' , 'block').text(res.responseJSON.errors.password);
                    }else{
                        $("form #errors-password").text('');
                    }
                    if(res.responseJSON.errors.confirmed_password){
                        $("form #errors-confirmed_password").css('display' , 'block').text(res.responseJSON.errors.confirmed_password);
                    }else{
                        $("form #errors-confirmed_password").text('');
                    }
                    if(res.responseJSON.errors.nat_id){
                        $("form #errors-nat_id").css('display' , 'block').text(res.responseJSON.errors.nat_id);
                    }else{
                        $("form #errors-nat_id").text('');
                    }
                    if(res.responseJSON.errors.email){
                        $("form #errors-email").css('display' , 'block').text(res.responseJSON.errors.email);
                    }else{
                        $("form #errors-email").text('');
                    }
                }
            });
        }
    });
</script>