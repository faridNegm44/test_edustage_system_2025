<script>
    const times = document.querySelector('#addForm #times');
    const btn_get_available_times = document.querySelector('#addForm .btn_get_available_times');

    $(btn_get_available_times).click(function(e){
        e.preventDefault();

        $.ajax({
            url: `{{ url($pageNameEn) }}/get_available_times_to_add_form`,
            type: 'GET',
            processData: false,
            contentType: false,
            data: $("#addForm").serialize(),
            beforeSend:function () {
                $("#addForm #times option").remove();

                document.querySelector('#addForm .btn_get_available_times').disabled = true;
            },
            error: function(res){
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
            },
            success: function(res){
                let times = res.times;
                let timesToTimeTable = res.timesToTimeTable;

                times.forEach(time => {
                    let isDuplicated = false;

                    timesToTimeTable.forEach(timeTimeTable => {
                        if((time.time+'-'+time.am_pm) == timeTimeTable.times){
                            isDuplicated = true;
                        }
                    });

                    if(!isDuplicated){
                        $("#addForm #times").append(`
                            <option value="${time.time}-${time.am_pm}">${time.time}-${time.am_pm}</option>
                        `)
                    }
                });

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.success("تمت جلب مواعيد الحصص المتاحة");

                document.querySelector('#addForm .btn_get_available_times').disabled = false;

            }
        });
    });
</script>


<script>
    $(document).ready(function () {
        $("#exampleModalCenter #save").click(function(e){
            e.preventDefault();

            document.querySelector('#exampleModalCenter #save').disabled = true;
            document.querySelector('#exampleModalCenter .spinner_request').setAttribute("style", "display: inline-block;");

            $.ajax({
                url: "{{ url($pageNameEn) }}/store",
                type: 'POST',
                processData: false,
                contentType: false,
                data: new FormData($('#exampleModalCenter form')[0]),
                beforeSend:function () {
                    $('form [id^=errors]').text('');
                },
                error: function(res){
                    $.each(res.responseJSON.errors, function(index, error) {
                        $(`form #errors-${index}`).css('display' , 'block').text(error);
                    });

                    document.querySelector('#exampleModalCenter #save').disabled = false;
                    document.querySelector('#exampleModalCenter .spinner_request').style.display = 'none';


                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄 أثناء حفظ الحصة");

                },
                success: function(res){
                    document.querySelector('#exampleModalCenter #save').disabled = false;
                    document.querySelector('#exampleModalCenter .spinner_request').style.display = 'none';

                    if(res.daysNotEqual){
                        alertify
                                .dialog('alert')
                                .set({transition:'slide',message: `
                                    <div style="text-align: center;font-weight: bold;">
                                        <p style="color: red;font-size: 18px;">خطأ <i class="fas fa-exclamation-triangle" style="margin: 0px 3px;"></i></p>
                                        <p>اختيارك لليوم ولتاريخ الحصة التعويضية غير متطابقين</p>
                                    </div>
                                `, 'basic': true})
                                .show();
                    }else{
                        // start after success remove all times and append this
                        $("#exampleModalCenter form #times option").remove();

                        $("#exampleModalCenter form #times").append(`
                            <option class="text-center text-danger" disabled style="margin-top: 60px;font-size: 13px;">اختر أولا الغرفة الدراسية واليوم والمستخدم</option>
                            <option class="text-center text-danger" disabled style="font-size: 13px;">لإظهار المواعيد المتاحة</option>
                        `)
                        // start after success remove all times and append this


                        $("#exampleModalCenter #group_id")[0].selectize.clear();


                        // $('#satDataTable').DataTable().ajax.reload();
                        $("#exampleModalCenter form bold[class=text-danger]").css('display', 'none');

                        $('.modal').modal('hide');

                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.success("تم اضافة الحصة بنجاح");

                        location.reload();
                    }
                }
            });
        });
    });
</script>
