<script>
    $(document).ready(function () {
        const removeRecordedTimesBtn = document.querySelector('#editForm #remove_recorded_times');

        removeRecordedTimesBtn.addEventListener('click', function(){               
            const recorded_times = $("#editForm #recorded_times").val();

            let selectedValues = [];
            let selectedTexts = [];
            
            $("#recorded_times option:selected").each(function(){
                selectedValues.push($(this).val());
                selectedTexts.push($(this).text());
            });

            if(recorded_times.length > 0){                    
                alertify.confirm(
                    'هل انت متأكد من الحذف ؟ <i class="fas fa-exclamation-triangle text-warning" style="margin: 0px 3px;"></i>', 
                    '<span class="text-center">عند التأكيد ب نعم سيتم حذف هذة المواعيد المختارة لهذا الجروب من قاعدة البيانات</span>', 
                function(){ 
                    // send request to delete recorded times
                    $.ajax({
                        url: `{{ url($pageNameEn) }}/remove_recorded_times`,
                        type: 'get',
                        data: {
                            values: selectedValues,
                            texts: selectedTexts,
                            notes: $("#editForm #notes").val(),
                        },
                        error: function(res){                    
                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 3);
                            alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
                        },
                        success: function(res){
                            // $('#satDataTable').DataTable().ajax.reload();

                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 5);
                            alertify.success("تم حذف المواعيد المسجلة لهذا الجروب بنجاح");

                            $("#recorded_times option").remove();
                            location.reload();                                        
                        }
                    });

                }, function(){ 

                }).set({
                    labels:{
                        ok:"نعم <i class='fas fa-check text-success' style='margin: 0px 3px;'></i>",
                        cancel: "لاء <i class='fa fa-times text-light' style='margin: 0px 3px;'></i>"
                    }
                });                    
            }else{
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.error("اختر موعد أو أكثر لإتمام الحذف");
            }


        });

    });
</script>