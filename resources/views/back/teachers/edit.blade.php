<script>
    ///////////////////////////////// edit /////////////////////////////////
    $(document).on("click" , "#example1 tr .edit" ,function(){
        const teacher_id = $(this).attr("teacher_id");
        
        $.ajax({
            url: `{{ url($pageNameEn) }}/edit/${teacher_id}`,
            type: 'GET',
            dataType: 'json',
            beforeSend: function(){
                $(".dataInput").val('');
            },
            success: function(res){

                $.each(res , function(index, value){                    
                    $(`#exampleModalCenter form #${index}`).val(value);
                });

                const NatID = $('#NatID')[0].selectize;
                NatID.setValue(res.NatID);

                const CityID = $('#CityID')[0].selectize;
                CityID.setValue(res.CityID);

                $("#teacher_id").val(teacher_id);
                $("#ThePass").val('');

                flatpickr("#TheBirthDate", {
                    defaultDate: res.TheBirthDate
                });
                
                flatpickr("#TheStatusDate", {
                    defaultDate: res.TheStatusDate
                });
                
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 2);
                alertify.success("تم استدعاء البيانات بنجاح 🔄✨");
            }
        });
    });


    


    ///////////////////////////////// update /////////////////////////////////
    $("#exampleModalCenter #update").click(function(e){
        e.preventDefault();
        document.querySelector('#exampleModalCenter #update').disabled = true;        
        document.querySelector('.spinner_request2').setAttribute("style", "display: inline-block;");

        const teacher_id = $("#exampleModalCenter #teacher_id").val();

        $.ajax({
            url: `{{ url($pageNameEn) }}/update/${teacher_id}`,
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
                
                document.querySelector('#exampleModalCenter #update').disabled = false;
                document.querySelector('.spinner_request2').style.display = 'none';                

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
            },
            success: function(res){
                document.querySelector('#exampleModalCenter #update').disabled = false;
                document.querySelector('.spinner_request2').style.display = 'none';

                $('#example1').DataTable().ajax.reload( null, false );
                $("#exampleModalCenter form bold[class=text-danger]").css('display', 'none');
        
                $(".dataInput").val('');                
                $('.modal').modal('hide');

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.success("تم التعديل بنجاح! ✔️🎯");
                                
            }
        });
    });
</script>