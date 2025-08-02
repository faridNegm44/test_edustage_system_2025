<script>
    $(document).on("click" , "table .take_attendance" ,function(e){
        e.preventDefault();
        let group_id = $(this).attr("group_id");
        
        $.ajax({
            type: 'get',
            url: `{{ url($pageNameEn) }}/take_attendance/${years_mat_id}/${group_id}`,
            beforeSend: function(){
                $('.modal-body').slideUp();
                $('#takeAttendance table tbody tr').remove();
                $('#count_students').text(0);
                $('#selected_count').text(0);
                $('#not_selected_count').text(0);
            },
            success: function(res){
                $('.modal-body').slideDown();

                if(res.findStudents && res.findStudents.length > 0){
                    $('#count_students').text(res.findStudents.length);
                    $('#selected_count').text(res.studentsChecked.length);
                    $('#not_selected_count').text((res.findStudents.length - res.studentsChecked.length));

                    $('#takeAttendance #left').slideDown();
                    $('#takeAttendance #no_students').fadeOut();


                    //console.log(res.findStudents);
                    //console.log(res.studentsChecked);


                    // start data right
                    $('#takeAttendance .group_id').val(res.group.ID);
                    $('#takeAttendance #group_name').val(res.group.GroupName);                
                    $('#takeAttendance #year_id').val(res.group.idSubject);
                    $('#takeAttendance #year_name').val(res.group.TheFullNameSubject);
                    $('#takeAttendance #ClassType').val(res.group.ClassType);
                    $('#takeAttendance #test_type').val(res.group.TheTestType);
                    $('#takeAttendance #GroupTeacherPayType').val(res.group.GroupTeacherPayType);

                    $('#takeAttendance #TeacherValue').val(res.group.GroupTeacherPayType == 'نسبة' ? res.percentage_value : res.GroupStaticValue);
                    $('#takeAttendance #TeacherTax').val(res.group.tax);
                    // end data right
    
                    console.log(res.studentsChecked);

                    $.each(res.findStudents, function(index, student) {
                        let isChecked = false;
                        let isDiscountValue = 0;

                        $.each(res.studentsChecked, function(stIndex, stValue) {
                            if (parseInt(student.studentId) === parseInt(stValue.stId)) {
                                isChecked = true;
                                isDiscountValue = stValue.DiscountValue;
                                return false;
                            }
                        });

                        $('#takeAttendance table tbody').append(`
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="check_item" ${isChecked ? "checked='checked'" : ""} value="${student.studentId}" name='StudentID[]' />
                                    <input type="hidden" class="form-control student_discount_table" value="0" name="DiscountValue[]" />
                                </td>
                                <td style="width: 40%;cursor: pointer;" class="student_td">
                                    ${student.studentName} ${student.parentName}
                                </td>
                                <td> <input type="number" class="form-control student_discount_table text-center" value="${isDiscountValue}" /></td>
                            </tr>
                        `);
                });

                }else{
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error("لايوجد طلاب مسجلين في الوقت الحالي لهذة المجموعة");

                    $('#takeAttendance #left').fadeOut();

                    $('#takeAttendance #no_students').fadeIn().text(`لايوجد طلاب مسجلين في الوقت الحالي لهذة المجموعة`);
                }
            }
        });
    });
</script>


<script>
    $('#takeAttendance #saveModalStudents').click(function(){

        $.ajax({
            url: `{{ url($pageNameEn) }}/store_students_to_group`,
            type: 'POST',
            processData: false,
            contentType: false,
            data: new FormData($('#takeAttendance #formModalStudents')[0]),
            //beforeSend: function(){
            //    $('#TeacherID')[0].selectize.clearOptions();
            //},
            success: function(res){

                if(res.teachers.length > 0){
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.success("تم استدعاء المدرسين بنجاح");
                    
                    $.each(res.teachers, function(index, value){
                        $('#TeacherID')[0].selectize.addOption({
                            value: value.teacherId,
                            text: value.teacherName
                        });
                    });
                }else{
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error("لا يوجد مدرسين مرتبطين بهذه المادة في الوقت الحالي");
                }

            }
        });
        
    });
</script>
