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

                const TheYear = $('#TheYear')[0].selectize;
                TheYear.setValue(res.TheYear);

                const TheMat = $('#TheMat')[0].selectize;
                TheMat.setValue(res.TheMat);

                const LangType = $('#LangType')[0].selectize;
                LangType.setValue(res.LangType);

                $("#res_id").val(res_id);
                
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
                document.querySelector('.modal #update').disabled = false;
                document.querySelector('.spinner_request2').style.display = 'none';

                if(res.founded){
                    alertify
                            .dialog('alert')
                            .set({transition:'slide',message: `
                                <div style="text-align: center;font-weight: bold;">
                                    <p style="color: red;font-size: 18px;margin-bottom: 10px;">خطأ <i class="fas fa-exclamation-triangle" style="margin: 0px 3px;"></i></p>
                                    <p>تمت إضافة هذه المادة من قبل لنفس الصف الدراسي</p>
                                </div>
                            `, 'basic': true})
                            .show();  
                }else{
                    $('#example1').DataTable().ajax.reload( null, false );
                    $(".modal form bold[class=text-danger]").css('display', 'none');
            
                    $(".dataInput").val('');
                    $('.dataInput:first').select().focus();
                    
                    $('.modal').modal('hide');

                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.success("تم التعديل بنجاح! ✔️🎯");
                }
                                
            }
        });
    });
</script>