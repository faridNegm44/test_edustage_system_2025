<script>
    ///////////////////////////////// update /////////////////////////////////
    $(".modal #update").click(function(e){
        e.preventDefault();
        document.querySelector('.modal #update').disabled = true;
        document.querySelector('.spinner_request2').setAttribute("style", "display: inline-block;");

        $.ajax({
            url: `{{ url($pageNameEn) }}/update`,
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

                //location.reload();

                document.querySelector('.modal #update').disabled = false;
                document.querySelector('.spinner_request2').style.display = 'none';

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.error("حدث خطأ ما ⚠️ يرجى المحاولة مرة أخرى 🔄");
            },
            success: function(res){
                $(".modal form bold[class=text-danger]").css('display', 'none');
                $(".modal").modal('hide');
                
                location.reload();

                document.querySelector('.modal #update').disabled = false;
                document.querySelector('.spinner_request2').style.display = 'none';

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.success("تم التعديل بنجاح! ✔️🎯");
            }
        });
    });
</script>
