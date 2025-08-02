<script>
    ///////////////////////////////// edit /////////////////////////////////
    $(document).on("click" , "#example1 tr .edit" ,function(){
        const Eval_GroupID = $(this).attr("Eval_GroupID");
        const Eval_Month = $(this).attr("Eval_Month");

        $.ajax({
            url: `{{ url('students_estimates/edit/${Eval_GroupID}/${Eval_Month}') }}`,
            type: 'GET',
            dataType: 'json',
            beforeSend: function(){
                $('#estimate_table table tbody tr').remove();
            },
            success: function(res){
                console.log(res);

                $("#add_rate #top_section").slideUp();
                $("#add_rate #estimate_table").slideDown();

                $.each(res , function(index, value){                    
                    $('#estimate_table table tbody').append(`
                        <tr>
                            <td>${index+1}</td>
                            <td style="font-size: 13px;font-weight: bold;">
                                ${value.studentName} ${value.parentName}
                                <input type="hidden" value="${value.Eval_ID}" name="Eval_StudentIDEdit[]"/>
                                <input type="hidden" value="${value.matId}" name="Eval_Years_MatEdit"/>

                                <input type="hidden" id="Eval_GroupIDEdit" value="${value.Eval_GroupID}" name="Eval_GroupID"/>
                                <input type="hidden" id="Eval_MonthEdit" value="${value.Eval_Month}" name="Eval_Month"/>
                            </td>
                            <td>
                                <input type="number" class="form-control dataInput Eval_Att Eval_Att_${index} sum-input" placeholder="10" min="0" name="Eval_Att[]" value="${value.Eval_Att}"/>
                            </td>
                            <td>
                                <input type="number" class="form-control dataInput Eval_Part Eval_Part_${index} sum-input" placeholder="10" min="0" name="Eval_Part[]" value="${value.Eval_Part}">
                            </td>
                            <td>
                                <input type="number" class="form-control dataInput Eval_Eval Eval_Eval_${index} sum-input" placeholder="40" min="0" name="Eval_Eval[]" value="${value.Eval_Eval}">
                            </td>
                            <td>
                                <input type="number" class="form-control dataInput Eval_HW Eval_HW_${index} sum-input" placeholder="40" min="0" name="Eval_HW[]" value="${value.Eval_HW}">
                            </td>
                            <td>
                                <input type="number" readonly class="form-control dataInput Eval_Degree" placeholder="0" name="Eval_Degree[]" value="${value.Eval_Degree}">
                            </td>
                            <td>
                                <input type="text" class="form-control dataInput Eval_TeacherComment" placeholder="تعليق المدرس" name="Eval_TeacherComment[]" value="${value.Eval_TeacherComment === null ? '' : value.Eval_TeacherComment}">

                            </td>
                            <td>
                                <input type="text" class="form-control dataInput Eval_TeacherSugg" placeholder="ملاحظات المدرس" name="Eval_TeacherSugg[]" value="${value.Eval_TeacherSugg === null ?  '' : value.Eval_TeacherSugg}">

                            </td>
                        </tr>
                    `);
                });
                                
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 2);
                alertify.success("تمت جلب تقيمات الطلاب بنجاح");
                
                // focusedInput
                focusedInput();

                // bottom inputs
                chechIfValueBiggerThan('.Eval_Att', 0, 10);
                chechIfValueBiggerThan('.Eval_Part', 0, 10);
                chechIfValueBiggerThan('.Eval_Eval', 0, 40);
                chechIfValueBiggerThan('.Eval_HW', 0, 40);

                // sumRow
                sumRow();
            }
        });


    });


    


    ///////////////////////////////// update /////////////////////////////////
    $(".modal #update").click(function(e){
        e.preventDefault();
        document.querySelector('.modal #update').disabled = true;        
        document.querySelector('.spinner_request2').setAttribute("style", "display: inline-block;");

        const Eval_GroupID = $(".modal form #Eval_GroupIDEdit").val();
        const Eval_Month = $(".modal form #Eval_MonthEdit").val();


        $.ajax({
            url: `{{ url('students_estimates/update/${Eval_GroupID}/${Eval_Month}') }}`,
            type: 'POST',
            processData: false,
            contentType: false,
            data: new FormData($('.modal #form')[0]),
            beforeSend:function () {
                $(".sum-input").css('border', '');
            },
            error: function(res){
                $.each(res.responseJSON.errors, function (index , value) {
                    index = index.replace('.', '_');
                    $(`.${index}`).css('border', '1px solid red');
                });               
                
                document.querySelector('.modal #update').disabled = false;
                document.querySelector('.spinner_request2').style.display = 'none';                

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.error("حدث خطأ ما ⚠️ الرجاء المحاولة لاحقًا 🔄");
            },
            success: function(res){
                document.querySelector('.modal #update').disabled = false;
                document.querySelector('.spinner_request2').style.display = 'none';

                $('#example1').DataTable().ajax.reload( null, false );           
                $('.modal').modal('hide');

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 3);
                alertify.success("تم تعديل تقيمات الطلاب بنجاح");
            }
        });
    });
</script>