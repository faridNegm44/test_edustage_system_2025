<script>
    $(document).on("click" , "#example1 tr .close_group" ,function(){
        let res_id = $('.closeGroupForm #res_id').val( $(this).attr("res_id") );
        let group_name = $('.closeGroupForm #group_name').val( $(this).attr("group_name") );

        $('.closeGroupForm #exampleModalLongTitle').html(`إغلاق مجموعة 
            <span class='text-danger'>${$(this).attr("group_name")}</span>
        نهائيا 🔐`);

    });



    // when close_group
    $(document).on("click" , ".closeGroupForm #update" ,function(e){
            e.preventDefault();
            let res_id = $('.closeGroupForm #res_id').val();
            let group_name = $('.closeGroupForm #group_name').val();

            alertify.confirm(
                'تحذير !! <i class="fas fa-exclamation-triangle text-warning" style="margin: 0px 3px;"></i>',
                `<div style="text-align: center;background: #303146;color: #fff;padding: 6px;">
                    <p style="padding: 5px;">
                        ⚠️ هل أنت متأكد من إغلاق المجموعة نهائيًا؟ 🔒
                        <p style="color: #fbba48;">${group_name}</p>
                    </p>
                    <p style="padding: 5px;">
                        لن تتمكن من تعديل أو استخدام هذه المجموعة بعد الإغلاق.
                    </p>
                </div>`,
            function(){
                
                // send request to delete recorded times
                $.ajax({
                    url: `{{ url($pageNameEn) }}/close_group/${res_id}`,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: new FormData($('.closeGroupForm #form')[0]),
                    beforeSend:function () {
                        $('.closeGroupForm form [id^=errors]').text('');
                    },
                    success: function(res){                      
                        $('#example1').DataTable().ajax.reload( null, false );
                        $('.closeGroupForm').modal('hide');

                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 4);
                        alertify.success("تم إغلاق المجموعة نهائيًا ✔️🎯");
                    },
                    error: function(res){
                        $.each(res.responseJSON.errors, function (index , value) {
                            $(`.closeGroupForm form #errors-${index}`).css('display' , 'block').text(value);
                        });               
                        
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
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