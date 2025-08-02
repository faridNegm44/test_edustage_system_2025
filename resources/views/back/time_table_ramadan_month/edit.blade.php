{{-- ///////////////////////////////// edit ///////////////////////////////// --}}
<script>
    $(document).ready(function () {
        const times = document.querySelector('#editForm #times');
        const btn_get_available_times = $("#editForm .btn_get_available_times");

        $(btn_get_available_times).click(function(e){
            e.preventDefault();

            $.ajax({
                url: `{{ url($pageNameEn) }}/get_available_times_to_edit_form`,
                type: 'GET',
                processData: false,
                contentType: false,
                data: $("#editForm").serialize(),
                beforeSend:function () {
                    $("#editForm #times option").remove();
                    document.querySelector('#editForm .btn_get_available_times').disabled = true;
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
                            $("#editForm #times").append(`
                                <option value="${time.time}-${time.am_pm}">${time.time}-${time.am_pm}</option>
                            `)
                        }
                    });

                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 4);
                    alertify.success("تمت جلب مواعيد الحصص المتاحة");

                    document.querySelector('#editForm .btn_get_available_times').disabled = false;

                }
            });
        });

    });
</script>




{{-- start when click to DBclick open modal + send ajax req to get the info to this course --}}
@if (auth()->user()->user_status != 4)
    <script>
        const selectAllTh = document.querySelectorAll('tbody th');
        const editModal = new bootstrap.Modal(document.getElementById('editModal'));

        selectAllTh.forEach(element=> {
            element.addEventListener('DBlclick', function(){
                const thtInnerText = this.innerText;
                const group_id = this.dataset.group_id;
                const group_to_colspan = this.dataset.group_to_colspan;

                if(thtInnerText){
                    editModal.show();

                    const displayModalBody = document.querySelector('#editModal .modal-body');
                    displayModalBody.style.display = 'none';

                    $.ajax({
                        url: `{{ url($pageNameEn) }}/edit/${group_id}/${group_to_colspan}`,
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        beforeSend:function () {
                            $('form [id^=errors]').text('');
                            $('#editModal #recorded_times option').remove();
                        },
                        error: function(res){

                        },
                        success: function(res){
                            //console.log(res.findTimesTimeTable[0].class_type);
                            displayModalBody.style.display = 'block';

                            const resFindTimesTimeTable = res.findTimesTimeTable;

                            const groupId = $('#editModal #group_id')[0].selectize;
                            groupId.setValue(resFindTimesTimeTable[0]['group_id']);

                            $('#editModal #day').val(resFindTimesTimeTable[0]['day']);
                            $('#editModal #room_id').val(resFindTimesTimeTable[0]['room_id']);
                            $('#editModal #class_type').val(resFindTimesTimeTable[0]['class_type']);
                            $('#editModal #user').val(resFindTimesTimeTable[0]['user']);
                            $('#editModal #notes').val(resFindTimesTimeTable[0]['notes']);
                            $('#editModal #date').text(resFindTimesTimeTable[0]['date']);


                            // These results are specific hidden inputs
                                $('#editModal #day_res').val(resFindTimesTimeTable[0]['day']);
                                $('#editModal #room_res').val(resFindTimesTimeTable[0]['room_id']);
                                $('#editModal #user_res').val(resFindTimesTimeTable[0]['user']);
                                $('#editModal #group_to_colspan_res').val(resFindTimesTimeTable[0]['group_to_colspan']);
                            // These results are specific hidden inputs


                            resFindTimesTimeTable.forEach(element => {
                                const recorded_times = $('#editModal #recorded_times');
                                recorded_times.append(`
                                    <option value="${element.id}">${element.times}</option>
                                `);

                                $('#editModal #recorded_times_hidden').val(res.implodePlukTimes);
                            })


                            alertify.set('notifier','position', 'top-center');
                            alertify.set('notifier','delay', 3);
                            alertify.success("تم جلب بيانات الحصة بنجاح");
                        }
                    });
                }
            });
        })
    </script>

@else
    <script>
        const selectAllTh = document.querySelectorAll('tbody th');
        const editModal = new bootstrap.Modal(document.getElementById('editModal'));

        selectAllTh.forEach(element=> {
            element.addEventListener('DBlclick', function(){
                const thtInnerText = this.innerText;
                const group_id = this.dataset.group_id;
                const group_to_colspan = this.dataset.group_to_colspan;

                if(thtInnerText){
                    editModal.show();

                    const displayModalBody = document.querySelector('#editModal .modal-body');
                    displayModalBody.style.display = 'none';

                    $.ajax({
                        url: `{{ url($pageNameEn) }}/edit/${group_id}/${group_to_colspan}`,
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        beforeSend:function () {
                            $('form [id^=errors]').text('');
                            $('#editModal #recorded_times option').remove();
                        },
                        error: function(res){

                        },
                        success: function(res){
                            if(res.findTimesTimeTable[0].class_type == 'أساسية' || res.findTimesTimeTable[0].class_type == 'محجوزة'){
                                $('#editModal .modal-title').text('ليس لديك صلاحيات لتعديل هذه الحصة');

                                alertify.set('notifier','position', 'top-center');
                                alertify.set('notifier','delay', 5);
                                alertify.error("ليس لديك صلاحيات لتعديل هذه الحصة");
                            }else{
                                $('#editModal .modal-title').text('تعديل بيانات حصة تعوضية');

                                displayModalBody.style.display = 'block';

                                const resFindTimesTimeTable = res.findTimesTimeTable;

                                const groupId = $('#editModal #group_id')[0].selectize;
                                groupId.setValue(resFindTimesTimeTable[0]['group_id']);

                                $('#editModal #day').val(resFindTimesTimeTable[0]['day']);
                                $('#editModal #room_id').val(resFindTimesTimeTable[0]['room_id']);
                                $('#editModal #class_type').val(resFindTimesTimeTable[0]['class_type']);
                                $('#editModal #user').val(resFindTimesTimeTable[0]['user']);
                                $('#editModal #notes').val(resFindTimesTimeTable[0]['notes']);
                                $('#editModal #date').text(resFindTimesTimeTable[0]['date']);

                                // These results are specific hidden inputs
                                    $('#editModal #day_res').val(resFindTimesTimeTable[0]['day']);
                                    $('#editModal #room_res').val(resFindTimesTimeTable[0]['room_id']);
                                    $('#editModal #user_res').val(resFindTimesTimeTable[0]['user']);
                                    $('#editModal #group_to_colspan_res').val(resFindTimesTimeTable[0]['group_to_colspan']);
                                // These results are specific hidden inputs


                                resFindTimesTimeTable.forEach(element => {
                                    const recorded_times = $('#editModal #recorded_times');
                                    recorded_times.append(`
                                        <option value="${element.id}">${element.times}</option>
                                    `);

                                    $('#editModal #recorded_times_hidden').val(res.implodePlukTimes);
                                })


                                alertify.set('notifier','position', 'top-center');
                                alertify.set('notifier','delay', 3);
                                alertify.success("تم جلب بيانات الحصة بنجاح");
                            }
                        }
                    });
                }
            });
        })
    </script>
@endif
{{-- end when click to DBclick open modal + send ajax req to get the info to this course --}}





{{-- ///////////////////////////////// update ///////////////////////////////// --}}
<script>
    $(document).ready(function () {
        $("#editForm #save").click(function(e){
            e.preventDefault();

            const recorded_times = $("#editForm #recorded_times option");
            const times = $("#editForm #times option");

            if(recorded_times.length > 0 && times.length > 0){
                // alertify.confirm('<span style="font-weight: bold;"></span>').set('basic', true);
                alert('غير مصرح  بوجود أوقات في كلتا القسمين قسم مواعيد الحصة المسجلة وقسم مواعيد الحصص المتاحة');
            }
            else{
                document.querySelector('#editForm #save').disabled = true;
                document.querySelector('#editForm .spinner_request').setAttribute("style", "display: inline-block;");

                const group_to_colspan = $("#group_to_colspan_res").val();


                $.ajax({
                    url: `{{ url($pageNameEn) }}/update/${group_to_colspan}`,
                    type: 'GET',
                    processData: false,
                    contentType: false,
                    data: $("#editForm").serialize(),
                    beforeSend:function () {
                        $('#editForm [id^=errors]').text('');
                    },
                    error: function(res){
                        $.each(res.responseJSON.errors, function(index, error) {
                            $(`#editForm #errors-${index}`).css('display' , 'block').text(error);
                        });

                        document.querySelector('#editForm #save').disabled = false;
                        document.querySelector('#editForm .spinner_request').style.display = 'none';

                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄 أثناء تعديل الحصة");
                    },
                    success: function(res){
                        $("#editForm bold[class=text-danger]").css('display', 'none');
                        document.querySelector('#editForm #save').disabled = false;
                        document.querySelector('#editForm .spinner_request').style.display = 'none';

                        $('#editModal').modal('hide');

                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 3);
                        alertify.success("تم تعديل الحصة بنجاح");

                        location.reload();
                    }
                });
            }

        });
    });
</script>
