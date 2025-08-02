<script>
    $(document).on("click" , "table .show_students" ,function(e){
        e.preventDefault();
        let years_mat_id = $(this).attr("years_mat_id");
        let group_id = $(this).attr("group_id");
        
        $.ajax({
            type: 'get',
            url: `{{ url($pageNameEn) }}/show_students/${years_mat_id}/${group_id}`,
            beforeSend: function(){
                $('.modal-body').slideUp();
                $('#modalStudents table tbody tr').remove();
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

                    $('#modalStudents #left').slideDown();
                    $('#modalStudents #no_students').fadeOut();


                    //console.log(res.findStudents);
                    //console.log(res.studentsChecked);


                    // start data right
                    $('#modalStudents .group_id').val(res.group.ID);
                    $('#modalStudents #group_name').val(res.group.GroupName);                
                    $('#modalStudents #year_id').val(res.group.idSubject);
                    $('#modalStudents #year_name').val(res.group.TheFullNameSubject);
                    $('#modalStudents #ClassType').val(res.group.ClassType);
                    $('#modalStudents #test_type').val(res.group.TheTestType);
                    $('#modalStudents #GroupTeacherPayType').val(res.group.GroupTeacherPayType);

                    if(res.group.GroupTeacherPayType == 'نسبة'){
                        $('#modalStudents #TeacherValuePercentageSection').show();
                        $('#modalStudents #TeacherValuePercentage').val(res.studentsChecked.length > 0 ? res.studentsChecked[0].TeacherValue : '');
                        
                        $('#modalStudents #TeacherValueStaticSection').hide();
                        $('#modalStudents #TeacherValueStatic').val('');

                    }else{
                        $('#modalStudents #TeacherValueStaticSection').show();
                        $('#modalStudents #TeacherValueStatic').val(res.group.GroupStaticValue);
                        
                        $('#modalStudents #TeacherValuePercentageSection').hide();
                        $('#modalStudents #TeacherValuePercentage').val('');
                    }



                    $('#modalStudents #TeacherTax').val(res.group.tax);

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

                        $('#modalStudents table tbody').append(`
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="check_item" ${isChecked ? "checked='checked'" : ""} value="${student.studentId}" name='StudentID' />                                                                    
                                </td>
                                <td class="text-center">
                                    ${
                                        isChecked 
                                        ? 
                                            `<button type="button" class='btn btn-sm btn-danger remove_one_student'><i class='fas fa-trash-alt'></i></button>`
                                        : 
                                            ""
                                    }
                                </td>
                                <td style="font-size: 13px !important;cursor: pointer;font-weight: bold;" class="student_td text-primary">
                                    ${student.studentId} - ${student.studentName} ${student.parentName}
                                    <input type="hidden" class="form-control student_id" value="0" name="student_id" value="${student.studentId}" />
                                </td>
                                <td> 
                                    <input type="number" class="form-control student_discount_table text-center" value="${isDiscountValue}" />
                                    <input type="hidden" class="form-control student_discount_table" value="0" name="DiscountValue" />    
                                </td>
                            </tr>
                        `);
                });

                }else{
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.error("لايوجد طلاب مسجلين في الوقت الحالي لهذة المجموعة");

                    $('#modalStudents #left').fadeOut();

                    $('#modalStudents #no_students').fadeIn().text(`لايوجد طلاب مسجلين في الوقت الحالي لهذة المجموعة`);
                }
            }
        });
    });
</script>
