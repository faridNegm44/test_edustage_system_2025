<script>
    ///////////////////////////////// edit /////////////////////////////////
    $(document).on("click" , "#example1 tr .crm_info" ,function(){
        const parent_id = $(this).attr("parent_id");
       
        document.querySelector(".modal #parent_id").value = '';
        // $(".modal form .row").empty();
        $(".dataInput").text('');


        $.ajax({
            url: `{{ url($pageNameEn) }}/crm_info/${parent_id}`,
            type: 'GET',
            dataType: 'json',
            success: function(res){
                res.crmNames.forEach(crmName => {
                    $(`.modal #col${crmName.crmColumnNameId}`).text(crmName.crmColumnValuesValue);
                })

                document.querySelector(".modal-title").innerText = `CRM ( ${res.parent.TheName0} )`;
                document.querySelector(".modal #parent_id").value = res.parent.ID;
                
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 2);
                alertify.success("تمت جلب بيانات CRM ولي الأمر بنجاح");
            }
        });

    });


    


    ///////////////////////////////// update /////////////////////////////////
    $(document).on("click" , ".modal .save" ,function(e){
        e.preventDefault();
        document.querySelector('.spinner_request').setAttribute("style", "display: inline-block;");

        const parent_id = $(".modal form #parent_id").val();

        $.ajax({
            url: `{{ url($pageNameEn) }}/crm_info_update/${parent_id}`,
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
                
                document.querySelector('.spinner_request').style.display = 'none';                

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
            },
            success: function(res){
                $(".modal form bold[class=text-danger]").css('display', 'none');        
                document.querySelector('.spinner_request').style.display = 'none';
                
                $(".dataInput").val('');
                $('.modal').modal('hide');

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.success("تم تعديل بيانات CRM ولي الأمر بنجاح");
            }
        });
    });
</script>