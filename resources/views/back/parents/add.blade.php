<script>
    $(document).ready(function () {
        $("#exampleModalCenter #save").click(function(e){
            e.preventDefault();
            document.querySelector('#exampleModalCenter #save').disabled = true;        
            document.querySelector('.spinner_request').setAttribute("style", "display: inline-block;");

            $.ajax({
                url: "{{ url($pageNameEn) }}/store",
                type: 'POST',
                processData: false,
                contentType: false,
                data: new FormData($('#exampleModalCenter #form')[0]),
                beforeSend:function () {
                    $('form [id^=errors]').text('');
                },
                error: function(res){
                    $.each(res.responseJSON.errors, function (index , value) {
                        $(`form #errors-${index}`).css('display' , 'block').text(value);
                    });               
                    
                    $('.dataInput:first').select().focus();
                    document.querySelector('#exampleModalCenter #save').disabled = false;
                    document.querySelector('.spinner_request').style.display = 'none';                

                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
                },
                success: function(res){
                    $('#example1').DataTable().ajax.reload( null, false );
                    $("#exampleModalCenter form bold[class=text-danger]").css('display', 'none');
            
                    $(".dataInput").val('');
                    $('.dataInput:first').select().focus();

                    document.querySelector('#exampleModalCenter #save').disabled = false;
                    document.querySelector('.spinner_request').style.display = 'none';

                    $('#NatID, #CityID').each(function() {
                        $(this)[0].selectize.clear();
                    });
                    
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.success("تمت الإضافة بنجاح! ✔️🎯");
                }
            });
        });
    });
</script>