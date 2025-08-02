<script>
    $(document).ready(function () {
        const studentId = @json($studentInfo->ID);
    
        $(".modal #save").click(function(e){
            e.preventDefault();
            
            const matId = $("#YearID").val();
            if(matId){
                document.querySelector('.modal #save').disabled = true;        
                document.querySelector('.spinner_request').setAttribute("style", "display: inline-block;");

                $.ajax({
                    url: `{{ url($pageNameEn) }}/store/${studentId}/${matId}`,
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
                            alert(res.founded);
                        }else{
                            $('#example1').DataTable().ajax.reload( null, false );
                            $(".modal form bold[class=text-danger]").css('display', 'none');
                                            
                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 4);
                            alertify.success("✅ تمّت إضافة الرغبة إلى رغبات الطالب بنجاح 🎯📚");
                        }
                    }
                });

            }else{
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.error("⚠️ الرجاء اختيار مادة دراسية أولاً قبل حفظ الرغبة 📚");
            }
        });
    });
</script>