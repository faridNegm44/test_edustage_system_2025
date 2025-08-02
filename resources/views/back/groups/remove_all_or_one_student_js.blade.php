<script>
    //start remove one students
    $(document).on('click', "#modalStudents .remove_one_student", function(e){
        e.preventDefault();
        const student_id = $(this).closest('tr').find('.check_item').val();
        const group_id = $('#modalStudents .group_id').val();

        $("#modalStudents .modal-footer").hide();
        document.querySelector('#modalStudents .spinner_request').setAttribute("style", "display: inline-block;");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        if (confirm('هل أنت متأكد أنك تريد حذف هذا الطالب من المجموعة؟')) {
            let formData = new FormData($('#modalStudents #formModalStudents')[0]);
            $.ajax({
                url: `{{ url($pageNameEn) }}/remove_one_student/${group_id}/${student_id}`,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(res){
                    $("#modalStudents .modal-footer").show();
                    document.querySelector('#modalStudents .spinner_request').style.display = 'none';
                    
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.success("تم حذف الطالب من المجموعة بنجاح");                    
                }
            });
            $(this).closest('tr').find('.check_item').prop('checked', false);
            $(this).closest('tr').find('.remove_one_student').remove();
        } else {
            return false;
        }
    });
    //end remove one students
    
    
    
    
    //start remove all students
    $(document).on('click', "#modalStudents .remove_all_student_tbl_groups_students", function(e){
        e.preventDefault();
        const group_id = $('#modalStudents .group_id').val();

        $("#modalStudents .modal-footer").hide();
        document.querySelector('#modalStudents .spinner_request').setAttribute("style", "display: inline-block;");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        if (confirm('هل أنت متأكد أنك تريد حذف حميع الطلاب لهذة المجموعة؟')) {
            let formData = new FormData($('#modalStudents #formModalStudents')[0]);
            const selected_count = $('#selected_count');
            const not_selected_count = $('#not_selected_count');

            $.ajax({
                url: `{{ url($pageNameEn) }}/remove_all_students_by_group/${group_id}`,
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(res){
                    $("#modalStudents .modal-footer").show();
                    document.querySelector('#modalStudents .spinner_request').style.display = 'none';
                    
                    not_selected_count.text( Number(selected_count.text()) + Number(not_selected_count.text()) );
                    selected_count.text(0);


                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 3);
                    alertify.success("تم حذف طلاب المجموعة بنجاح");                    
                }
            });

            $('.check_item').prop('checked', false);
            $('.remove_one_student').remove();
        } else {
            return false;
        }
    });
    //end remove all students

</script>