<script>
    $(document).on("click" , "table .delete" ,function(e){
        e.preventDefault();
        let parent_id = $(this).attr("parent_id");
        let parent_name = $(this).attr("parent_name");

        alertify.confirm(
            'تحذير !! <i class="fas fa-exclamation-triangle text-warning" style="margin: 0px 3px;"></i>',
            `<div style="text-align: center;">
                <p style="font-weight: bold;">
                    ⚠️ هل أنت متأكد من حذف ولي الأمر 🗑️
                    <p style="color: red;font-weight: bold;">${parent_name}</p>
                </p>
            </div>`,
        function(){
            // send request to delete recorded times
            $.ajax({
                url: `{{ url($pageNameEn) }}/destroy/${parent_id}`,
                type: 'get',
                success: function(res){
                    if(res.foundedData){
                        alertify
                                .dialog('alert')
                                .set({transition:'slide',message: `
                                    <div style="text-align: center;font-weight: bold;">
                                        <p style="color: red;font-size: 18px;margin-bottom: 10px;">خطأ <i class="fas fa-exclamation-triangle" style="margin: 0px 3px;"></i></p>
                                        <p>${res.foundedData}</p>
                                    </div>
                                `, 'basic': true})
                                .show();  
                    }else{
                        $('#example1').DataTable().ajax.reload( null, false );

                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 4);
                        alertify.error("🗑️ تم حذف ولي الأمر بنجاح ❌");
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
