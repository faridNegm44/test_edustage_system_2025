<script>
    $(document).on("click" , "table .delete" ,function(e){
        e.preventDefault();
        const Eval_GroupID = $(this).attr("Eval_GroupID");
        const Eval_Month = $(this).attr("Eval_Month");
        const GroupName = $(this).attr("GroupName");

        alertify.confirm(
            'تحذير !! <i class="fas fa-exclamation-triangle text-warning" style="margin: 0px 3px;"></i>', 
            `<div style="text-align: center;">
                <p style="font-weight: bold;">
                    هل انت متأكد من حذف تقيمات مجموعة 
                    <span style="color: red;">${GroupName} </span> 
                    لشهر <span style="color: red;">${Eval_Month}</span>
                </p>
            </div>`, 
        function(){ 
            // send request to delete recorded times
            $.ajax({
                url: `{{ url('students_estimates/destroy/${Eval_GroupID}/${Eval_Month}') }}`,
                type: 'get',
                error: function(res){                    
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
                },
                success: function(res){
                    $('#example1').DataTable().ajax.reload( null, false );

                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 4);
                    alertify.error("تم حذف تقيمات الطلاب لهذة المجموعة بنجاح");
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