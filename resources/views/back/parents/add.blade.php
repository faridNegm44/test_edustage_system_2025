<script>
    $(document).ready(function () {
        $("#exampleModalCenter #save").click(function(e){
            e.preventDefault();
            $("#overlay_page").show();
            

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

                    $('#overlay_page').hide();              

                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
                },
                success: function(res){

                    $('#example1').DataTable().ajax.reload( null, false );
                    $("#exampleModalCenter form bold[class=text-danger]").css('display', 'none');
                    $('#overlay_page').hide();

                    if(res.duplicated_emails){
                        @include('back.layouts.duplicated_emails_js')
                    }else{
                        $(".dataInput").val('');
                        $('.dataInput:first').select().focus();
    
                        $('#NatID, #CityID').each(function() {
                            $(this)[0].selectize.clear();
                        });
                        
                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.success("تمت الإضافة بنجاح! ✔️🎯");
                    }
                }
            });
        });
    });
</script>