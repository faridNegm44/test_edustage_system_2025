<script>
    $(document).ready(function () {
        $(".modal #save").click(function(e){
            e.preventDefault();
            document.querySelector('.modal #save').disabled = true;        
            document.querySelector('.spinner_request').setAttribute("style", "display: inline-block;");

            
            $.ajax({
                url: "{{ url($pageNameEn) }}/store",
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
                    document.querySelector('.modal #save').disabled = false;
                    document.querySelector('.spinner_request').style.display = 'none';                

                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
                },
                success: function(res){
                    document.querySelector('.modal #save').disabled = false;
                    document.querySelector('.spinner_request').style.display = 'none';

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

                        $('#TheYear, #TheMat', '#LangType').each(function() {
                            $(this)[0].selectize.clear();
                        });

                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.success("تمت الإضافة بنجاح! ✔️🎯");
                    }

                }
            });
        });

    });

</script>