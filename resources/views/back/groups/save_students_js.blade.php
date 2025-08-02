<script>
    $(document).ready(function () {
        $("#modalStudents #saveModalStudents").click(function(e){
            e.preventDefault();
            document.querySelector('#modalStudents #saveModalStudents').disabled = true;        
            document.querySelector('#modalStudents .spinner_request').setAttribute("style", "display: inline-block;");
            

            let selectedStudents = [];
            $('#modalStudents table tbody tr').each(function () {
                if ($(this).find('.check_item').is(':checked')) {
                    selectedStudents.push({
                        student_id: $(this).closest('tr').find('.check_item').val(),
                        discount: $(this).closest('tr').find('.student_discount_table').val()
                    });
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let formData = new FormData($('#modalStudents #formModalStudents')[0]);
            formData.append('students', JSON.stringify(selectedStudents));

            $.ajax({
                url: `{{ url($pageNameEn) }}/store_students_to_group`,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                beforeSend:function () {
                    $('#formModalStudents [id^=errors]').text('');
                },
                error: function(res){
                    $.each(res.responseJSON.errors, function (index , value) {
                        $(`#formModalStudents #errors-${index}`).css('display' , 'block').text(value);
                    });               
                    
                    document.querySelector('#modalStudents #saveModalStudents').disabled = false;
                    document.querySelector('#modalStudents .spinner_request').style.display = 'none';                

                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
                },
                success: function(res){

                    document.querySelector('#modalStudents #saveModalStudents').disabled = false;
                    document.querySelector('#modalStudents .spinner_request').style.display = 'none';

                    if(res.founded){
                        alertify
                        .dialog('alert')
                        .set({transition:'slide',message: `
                            <div style="text-align: center;font-weight: bold;">
                                <p style="color: red;font-size: 18px;margin-bottom: 10px;">خطأ <i class="fas fa-exclamation-triangle" style="margin: 0px 3px;"></i></p>
                                <p>تمت إضافة هذه المجموعة من قبل لنفس المدرس ونفس نظام الحساب ونفس الباقة</p>
                            </div>
                        `, 'basic': true})
                        .show();  

                    }else{
                        $('#example1').DataTable().ajax.reload( null, false );                
                        $('#modalStudents').modal('hide');
                    
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.success("تمت تعديل طلاب المجموعة بنجاح");
                    }

                }
            });
        });

    });

</script>