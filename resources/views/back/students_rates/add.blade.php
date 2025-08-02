<script>
    $(document).ready(function () { // START DOC READY
        $(".modal #save").click(function(e){ // START CLICK BUTTON SAVE
            e.preventDefault();
            document.querySelector('.modal #save').disabled = true;        
            document.querySelector('.spinner_request').setAttribute("style", "display: inline-block;");


            {{--  let sumInputs = $('.sum-input');
            let isEmpty = true;

            sumInputs.each(function(){
                if (!$(this).val().trim()) {
                    $(this).css('border', '1px solid red');
                    document.querySelector('.modal #save').disabled = false;
                    document.querySelector('.spinner_request').style.display = 'none';

                    isEmpty = false;
                }else{
                    $(this).css('border', '1px solid green');
                    isEmpty = true;
                }
            });


            if(isEmpty){                
            }  --}}


            
            $.ajax({ // START AJAX REQ
                url: "{{ url('students_estimates/store') }}",
                type: 'POST',
                processData: false,
                contentType: false,
                data: new FormData($('.modal #form')[0]),
                beforeSend:function () {
                    $(".sum-input").css('border', '');
                    $("#errors-Eval_Month").css('display', 'none').text('');
                },
                error: function(res){         
                    // console.log(res.responseJSON.errors.Eval_Month);           
                    
                    $.each(res.responseJSON.errors, function (key) {
                        key = key.replace('.', '_');
                        $(`.${key}`).css('border', '1px solid red');

                        $('#errors-Eval_Month').css('display', 'block').text(res.responseJSON.errors.Eval_Month)
                    });
                    
                    document.querySelector('.modal #save').disabled = false;
                    document.querySelector('.spinner_request').style.display = 'none';                

                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
                },
                success: function(res){
                    document.querySelector('.modal #save').disabled = false;
                    document.querySelector('.spinner_request').style.display = 'none';

                    if(res.foundeGroupAndMonth){
                        alertify
                                .dialog('alert')
                                .set({transition:'slide',message: `
                                    <div style="text-align: center;font-weight: bold;">
                                        <p style="color: red;font-size: 18px;">خطأ <i class="fas fa-exclamation-triangle" style="margin: 0px 3px;"></i></p>
                                        <p>تم تقييم طلاب هذه المجموعة لهذا الشهر من قبل</p>
                                    </div>
                                `, 'basic': true})
                                .show();  
                    }else{
                        $('#example1').DataTable().ajax.reload( null, false );
                        $('.modal').modal('hide');
        
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.success("تمت اضافة تقيمات الطلاب بنجاح");
                    }
                }
            }); // END AJAX REQ

            




        });  // END CLICK BUTTON SAVE
    }); // END DOC READY

</script>