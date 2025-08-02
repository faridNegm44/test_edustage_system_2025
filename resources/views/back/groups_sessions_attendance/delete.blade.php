<script>
    $(document).on("click" , "table .delete" ,function(e){
        e.preventDefault();
        let res_id = $(this).attr("res_id");
        let TheDate = $(this).attr("TheDate");

        alertify.confirm(
            'تحذير !! <i class="fas fa-exclamation-triangle text-warning" style="margin: 0px 3px;"></i>',
            `<div style="text-align: center;">
                <p style="font-weight: bold;">
                    هل انت متأكد من حذف الحصة المسجلة بتاريخ
                    <p style="color: red;font-weight:bold;margin-top:10px;">${TheDate}</p>
                </p>
            </div>`,
        function(){
            // send request to delete recorded times
            $.ajax({
                url: `{{ url($pageNameEn) }}/destroy/${res_id}`,
                type: 'get',
                success: function(res){
                    
                    if(res.founded){
                        alertify
                                .dialog('alert')
                                .set({transition:'slide',message: `
                                    <div style="text-align: center;font-weight: bold;">
                                        <p style="color: red;font-size: 18px;margin-bottom: 10px;">خطأ <i class="fas fa-exclamation-triangle" style="margin: 0px 3px;"></i></p>
                                        <p>لايمكن حذف السجل.</p>
                                    </div>
                                `, 'basic': true})
                                .show();  
                    }else{
                        $('#example1').DataTable().ajax.reload( null, false );

                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 4);
                        alertify.success("🗑️ تم حذف الحصة بنجاح ✅");
                    }
                }
            });

        }, function(){

        }).set({
            labels:{
                ok:"نعم <i class='fas fa-check text-success' style='margin: 0px 3px;'></i>",
                cancel: "لاء <i class='fa fa-times text-light' style='margin: 0px 3px;'></i>"
            }
        });
    });
</script>
