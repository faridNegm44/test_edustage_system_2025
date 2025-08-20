<script>

    ///////////////////////////////// edit /////////////////////////////////
    $(document).on("click" , "#example1 tr .crm_info" ,function(){
        const parent_id = $(this).attr("parent_id");

        //$("#crmModal form textarea").val('');
        //$("#crmModal form .columnId").val('');

        $.ajax({
            url: `{{ url($pageNameEn) }}/crm_info/${parent_id}`,
            type: 'GET',
            dataType: 'json',
            beforeSend: function(){
                $("#crmModal #parent_id").val('');
                $("#crmModal form textarea").val('');
                $("#crmModal form .columnId").val('');
            },
            success: function(res){
                document.querySelector("#crmModal #exampleModalLongTitle")
                        .innerText = `CRM ( ${res.parent.TheName0} )`;

                $('#crmModal #form #parent_id').val(res.parent.ID);
                
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 2);
                alertify.success("✅ تمت جلب بيانات CRM ولي الأمر بنجاح 🎉");

                res.crmNames.forEach(crmName => {
                    $(`#crmModal #col${crmName.crmColumnNameId}`).val(crmName.crmColumnValuesValue);
                });

                res.crmNamesEmpty.forEach(crmEmpty => {
                    $(`#crmModal #col2${crmEmpty.id}`).val(crmEmpty.id);
                });
            }
        });
    });


    


    ///////////////////////////////// update /////////////////////////////////
    $(document).on("click" , "#crmModal .save" ,function(e){
        e.preventDefault();
        $("#overlay_page").show();
        document.querySelector('.spinner_request').setAttribute("style", "display: inline-block;");

        const parent_id = $("#crmModal #parent_id").val();

        $.ajax({
            url: `{{ url($pageNameEn) }}/crm_info_update/${parent_id}`,
            type: 'POST',
            processData: false,
            contentType: false,
            data: new FormData($('#crmModal #form')[0]),
            beforeSend:function () {
                $('form [id^=errors]').text('');
            },
            error: function(res){
                $.each(res.responseJSON.errors, function (index , value) {
                    $(`form #errors-${index}`).css('display' , 'block').text(value);
                });               
                
                $("#overlay_page").hide();                

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
            },
            success: function(res){
                $("#overlay_page").hide();
                $("#crmModal form bold[class=text-danger]").css('display', 'none');        
                
                $('#crmModal').modal('hide');
                //location.reload();

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.success("✅ تم تعديل بيانات CRM ولي الأمر بنجاح 🎉");
            }
        });
    });
</script>