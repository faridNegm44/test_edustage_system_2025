<script>
    ///////////////////////////////// edit /////////////////////////////////
    $(document).on("click" , "#example1 tr .edit" ,function(){
        const res_id = $(this).attr("res_id");
        var birth_date = flatpickr(".datePicker");

        $.ajax({
            url: `{{ url($pageNameEn) }}/edit/${res_id}`,
            type: 'GET',
            dataType: 'json',
            beforeSend: function(){
                $(".dataInput").val('');
            },
            success: function(res){
                // user
                $(`.modal form #name`).val(res.user.name);
                $(`.modal form #email`).val(res.user.email);
                $(`.modal form #user_role`).val(res.user.user_role);
                $(`.modal form #user_status`).val(res.user.user_status);
                $(`.modal form #active`).val(res.user.active);
                
                // userInAdminTable
                $(`.modal form #gender`).val(res.userInAdminTable.gender);
                $(`.modal form #phone`).val(res.userInAdminTable.phone);
                $(`.modal form #nat_id`).val(res.userInAdminTable.nat_id);
                $(`.modal form #address`).val(res.userInAdminTable.address);
                $(`.modal form #notes`).val(res.userInAdminTable.notes);
                $(`.modal form #image_preview_form`).attr('src', `{{ url('back/images/users') }}/${res.userInAdminTable.image}`);
                birth_date.setDate(res.userInAdminTable.birth_date, true); 

                document.querySelector("#res_id").value = res.user.id;
                document.querySelector("#image_hidden").value = res.userInAdminTable.image;
                document.querySelector("#image_preview_form").src = `{{ url('back/images/users') }}/${res.userInAdminTable.image}`;
                
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 2);
                alertify.success("تم استدعاء البيانات بنجاح 🔄✨");
            }
        });

    });


    


    ///////////////////////////////// update /////////////////////////////////
    $(".modal #update").click(function(e){
        e.preventDefault();
        document.querySelector('.modal #update').disabled = true;        
        document.querySelector('.spinner_request2').setAttribute("style", "display: inline-block;");

        const res_id = $(".modal form #res_id").val();
        
        $.ajax({
            url: `{{ url($pageNameEn) }}/update/${res_id}`,
            type: 'POST',
            processData: false,
            contentType: false,
            data: new FormData($('.modal #form')[0]),
            beforeSend:function () {
                $('form [id^=errors]').text('');
            },
            error: function(res){
                $.each(res.responseJSON.errors, function (index , value) {
                    $(`form #errors-${index}`).css('display' , 'block').text(value);
                });               
                
                document.querySelector('.modal #update').disabled = false;
                document.querySelector('.spinner_request2').style.display = 'none';                

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
            },
            success: function(res){

                $('#example1').DataTable().ajax.reload( null, false );
                $(".modal form bold[class=text-danger]").css('display', 'none');
        
                $(".dataInput").val('');
                $('.dataInput:first').select().focus();

                document.querySelector('.modal #update').disabled = false;
                document.querySelector('.spinner_request2').style.display = 'none';
                
                $('.modal').modal('hide');

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.success("تم التعديل بنجاح! ✔️🎯");

            }
        });
    });
</script>