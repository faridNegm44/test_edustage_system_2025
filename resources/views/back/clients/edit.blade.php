{{-- Edit --}}
<script>
    $(document).on("click" , "#datatable tr .edit" ,function(){
        const row_id = $(this).attr("row_id");

        $.ajax({
            url: `{{ url($pageNameEn.'/edit') }}/${row_id}`,
            type: 'GET',
            dataType: 'json',
            beforeSend:function () {
                $("#spinner-div").show();
            },
            success: function(res){

                $.each(res , function (index, value) {

                    if (index === 'id'){
                        $(".offcanvas form #row_id").val(value);
                    }

                    if ($(`.offcanvas form #${index}`).hasClass('select2')){
                        $(`.offcanvas form #${index}`).val(value).trigger('change');
                    }
                    else {
                        $(`.offcanvas form #${index}`).val(value);
                    }

                });

                $('#password , #confirmed_password').val(
                    res['password_text']
                );


                // $(".offcanvas form #note").val(res['note']);
                // $(".offcanvas form .status").val(res['status']);
            },
            complete:function () {
                $("#spinner-div").hide();
            }
        });

    });


    // Update
    ///////////////////////////////// update when click to footer button /////////////////////////////////
    $("#offcanvasWithBothOptions #update").click(function(e){
        e.preventDefault();
        const row_id = $(".offcanvas form #row_id").val();

        $.ajax({
            url: `{{ url($pageNameEn.'/update') }}/${row_id}`,
            type: 'POST',
            processData: false,
            contentType: false,
            data: new FormData($('#offcanvasWithBothOptions #form')[0]),
            beforeSend:function () {
                $('form [id^=errors]').text('');
            },
            error: function(res){
                alertify.set('notifier','position', 'bottom-right');
                alertify.set('notifier','delay', 4);
                alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");

                $.each(res['responseJSON']['errors'] , function (index , value) {

                    $(`form #errors-${index}`).css('display' , 'block').text(value);

                });

                // if(res['responseJSON']['errors']['start']){
                //     $("form #errors-start").css('display' , 'block').text(res['responseJSON']['errors']['start']);
                // }else{
                //     $("form #errors-start").text('');
                // }
                // if(res['responseJSON']['errors']['end']){
                //     $("form #errors-end").css('display' , 'block').text(res['responseJSON']['errors']['end']);
                // }else{
                //     $("form #errors-end").text('');
                // }
                // if(res['responseJSON']['errors']['branch']){
                //     $("form #errors-branch").css('display' , 'block').text(res['responseJSON']['errors']['branch']);
                // }else{
                //     $("form #errors-branch").text('');
                // }
            },
            success: function(){
                $("#offcanvasWithBothOptions").offcanvas('hide');
                $('#datatable').DataTable().ajax.reload( null, false );
                // $("#offcanvasWithBothOptions form bold[class=text-danger]").css('display', 'none');

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.success("تم التعديل بنجاح! ✔️🎯");

            }
        });
    });
</script>