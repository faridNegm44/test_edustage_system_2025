<script>
    $(".modal #save").click(function(e){
        e.preventDefault();

        $.ajax({
            url: "{{ url($pageNameEn) }}/store",
            type: 'POST',
            processData: false,
            contentType: false,
            data: new FormData($('.modal #form')[0]),
            beforeSend:function () {
                $('form [id^=errors]').text('');
            },
            error: function(res){
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");


                console.log(res.responseJSON.errors);

                $.each(res.responseJSON.errors, function (index , value) {
                    $(`form #errors-${index}`).css('display' , 'block').text(value);
                });
            },
            success: function(res){
                $(".modal").modal('hide');
                $('#datatable').DataTable().ajax.reload( null, false );
                $(".modal form bold[class=text-danger]").css('display', 'none');

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.success("تمت الإضافة بنجاح! ✔️🎯");

            }
        });
    });



</script>