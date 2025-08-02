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
                if(res.notAuth){
                    alertify.dialog('alert')
                        .set({transition:'slide',message: `
                            <div style="text-align: center;font-weight: bold;">
                                <p style="color: #e67e22; font-size: 18px; margin-bottom: 10px;">
                                    صلاحية غير متوفرة 🔐⚠️
                                </p>
                                <p>${res.notAuth}</p>
                            </div>
                        `, 'basic': true})
                        .show();  
                    $(".modal").modal('hide');  

                }else{
                    document.querySelector("#res_id").value = res_id;
    
                    $.each(res , function(index, value){                    
                        $(`.modal form #${index}`).val(value);
                    });
                    
                    //$("#first_money").val(display_number_js(res.first_money));
                    //$("#first_money").attr('readonly', true);
                    $("#commission_percentage").val(display_number_js(res.commission_percentage));
    
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 2);
                    alertify.success("تم استرجاع البيانات بنجاح");
                }
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
                document.querySelector('.modal #update').disabled = false;
                document.querySelector('.spinner_request2').style.display = 'none';

                $('#example1').DataTable().ajax.reload( null, false );
                $(".modal form bold[class=text-danger]").css('display', 'none');
        
                $(".dataInput").val('');
                $(".modal").modal('hide');

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.success("تم التعديل بنجاح! ✔️🎯");
            }
        });
    });
</script>