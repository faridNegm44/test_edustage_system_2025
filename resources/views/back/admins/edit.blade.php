<script>
    $(document).on("click" , "#datatable tr .edit" ,function(e){                
        const row_id = $(this).attr("row_id");

        $.ajax({
            url: "{{ url('admin/admins/edit') }}"+'/'+row_id,
            type: 'GET',
            success: function(res){                        
                console.log(res);
               
                $(".offcanvas form #row_id").val(res.id);
                $(".offcanvas form #name").val(res.name);
                $(".offcanvas form #email").val(res.email);
                $(".offcanvas form #user_name").val(res.user_name);
                $(".offcanvas form #address").val(res.address);
                $(".offcanvas form #nat_id").val(res.nat_id);
                $(".offcanvas form #birth_date").val(res.birth_date);
                $(".offcanvas form #phone").val(res.user_phone);                        
            },
        });

    });
</script>


{{-- Update  --}}
<script>
    ///////////////////////////////// update when click to footer button /////////////////////////////////
    $("#offcanvasWithBothOptions #update").click(function(e){
        e.preventDefault();
        const row_id = $(".offcanvas form #row_id").val();
        
        $.ajax({
            url: "{{ url('admin/admins/update') }}"+'/'+row_id,
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
                alertify.success("تم التعديل بنجاح! ✔️🎯");

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

    ///////////////////////////////// update By Button Enter /////////////////////////////////
    $("#form").keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            const row_id = $(".offcanvas form #row_id").val();

            $.ajax({
                url: "{{ url('admin/admins/update') }}"+'/'+id,
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
                    alertify.success("تم التعديل بنجاح! ✔️🎯");

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
        }
    });
</script>