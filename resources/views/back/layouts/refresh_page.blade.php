<script>
    $(".refresh_page").click(function(){
        if(($(".content-right table tbody tr").length) > 0){
            alertify.confirm('انتبه <i class="fas fa-exclamation-triangle text-danger" style="margin: 0px 3px;font-size: 25px;"></i>', '<p class="text-danger text-center" style="font-weight: bold;line-height: 2;"> هناك فاتورة لم تحفظ بعد. هل تريد الإستمرار في تحـديث الصفحة والغاء حفظ الفاتورة الحالية</p>', function(){
                    location.reload();
                },function(){

                }).set({
                    labels:{
                        ok:"نعم <i class='fas fa-check text-success' style='margin: 0px 3px;'></i>",
                        cancel: "لاء <i class='fa fa-times text-light' style='margin: 0px 3px;'></i>"
                    }
                });
        }else{
            location.reload();
        }
    });
</script>