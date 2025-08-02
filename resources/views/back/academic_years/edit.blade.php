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
                    $(`.modal form #${index}`).val(value);
                });

                $("#start").flatpickr({
                    defaultDate: res.start, 
                });

                $("#end").flatpickr({
                    defaultDate: res.end, 
                });


                document.querySelector("#res_id").value = res_id;
                
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 2);
                alertify.success("تم استرجاع البيانات بنجاح");
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
                
                $('.dataInput:first').select().focus();
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
                $(".modal").modal('hide');

                document.querySelector('.modal #update').disabled = false;
                document.querySelector('.spinner_request2').style.display = 'none';

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.success("تم التعديل بنجاح! ✔️🎯");
            }
        });
    });
</script>