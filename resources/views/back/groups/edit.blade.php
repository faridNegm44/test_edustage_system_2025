<script>
    ///////////////////////////////// edit /////////////////////////////////
    $(document).on("click" , "#example1 tr .edit" ,function(){
        const res_id = $(this).attr("res_id");

        $.ajax({
            url: `{{ url($pageNameEn) }}/edit/${res_id}`,
            type: 'GET',
            dataType: 'json',
            beforeSend: function(){
                $(".dataInput").val('');
            },
            success: function(res){
                $.each(res , function(index, value){                    
                    $(`.editForm form #${index}`).val(value);
                });
                $(`.editForm form #res_id`).val(res_id);
                
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 2);
                alertify.success("تم استدعاء البيانات بنجاح 🔄✨");
            }
        });
    });



    ///////////////////////////////// update /////////////////////////////////
    $(".editForm #update").click(function(e){
        e.preventDefault();
        document.querySelector('.editForm #update').disabled = true;        
        document.querySelector('.editForm  .spinner_request2').setAttribute("style", "display: inline-block;");

        const res_id = $(".editForm form #res_id").val();

        $.ajax({
            url: `{{ url($pageNameEn) }}/update/${res_id}`,
            type: 'POST',
            processData: false,
            contentType: false,
            data: new FormData($('.editForm #form')[0]),
            beforeSend:function () {
                $('form [id^=errors]').text('');
            },
            error: function(res){
                $.each(res.responseJSON.errors, function (index , value) {
                    $(`form #errors-${index}`).css('display' , 'block').text(value);
                });               
                
                document.querySelector('.editForm #update').disabled = false;
                document.querySelector('.editForm  .spinner_request2').style.display = 'none';                

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
            },
            success: function(res){
                document.querySelector('.editForm #update').disabled = false;
                document.querySelector('.editForm  .spinner_request2').style.display = 'none';

                $('#example1').DataTable().ajax.reload( null, false );
                $(".editForm form bold[class=text-danger]").css('display', 'none');
        
                $(".dataInput").val('');
                $('.dataInput:first').select().focus();
                
                $('.editForm').modal('hide');

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.success("تم التعديل بنجاح! ✔️🎯");                   
            }
        });
    });
</script>