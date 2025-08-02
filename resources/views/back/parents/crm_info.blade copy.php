<script>
    ///////////////////////////////// edit /////////////////////////////////
    $(document).on("click" , "#example1 tr .crm_info" ,function(){
        const parent_id = $(this).attr("parent_id");
       
        document.querySelector(".modal #parent_id").value = '';
        $(".modal form .row").empty();


        $.ajax({
            url: `{{ url($pageNameEn) }}/crm_info/${parent_id}`,
            type: 'GET',
            dataType: 'json',
            beforeSend: function(){
                $(".dataInput").val('');
            },
            success: function(res){
                // console.log(res.crmNames);

                res.crmNamesEmpty.forEach(crmNameEmpty => {
                    $(`.modal .row`).append(`
                        <div class="col-md-6">
                            <label for="${crmNameEmpty.name_ar}">${crmNameEmpty.name_ar}</label>
                            <div>
                                <textarea class="form-control dataInput" name="columnValue[]" id="col${crmNameEmpty.id}" style="border-radius: 10px;" rows="3"></textarea>
                            </div>
                        </div>
                    `);
                })


                res.crmNames.forEach(crmName => {
                    $(`.modal .row #col${crmName.crmColumnNameId}`).text(crmName.crmColumnValuesValue);
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