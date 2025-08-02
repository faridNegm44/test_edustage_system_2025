<script>
    $(document).on("click" , "#example1 tr .show" ,function(){
        const Eval_GroupID = $(this).attr("Eval_GroupID");
        const Eval_Month = $(this).attr("Eval_Month");

        $.ajax({
            url: `{{ url('students_estimates/show/${Eval_GroupID}/${Eval_Month}') }}`,
            type: 'GET',
            dataType: 'json',
            beforeSend: function(){
                $(`#exampleModalCenterShow table tbody tr`).remove();
                $('#Eval_Date span').text('');
                $('#Eval_GroupID span').text('');
                $('#Eval_Years_Mat span').text('');
                $('#Eval_Month span').text('');
                $('#Eval_Year span').text('');
                $("#exampleModalCenterShow .modal-title span").text('');
            },
            success: function(res){
                $.each(res , function(index, value){
                    $(`#exampleModalCenterShow table tbody`).append(`
                        <tr>
                            <th >${index+1}</th>
                            <th style="font-weight: bold;">${value.studentName} ${value.parentName}</th>
                            <th >${value.Eval_Att}</th>
                            <th >${value.Eval_Part}</th>
                            <th >${value.Eval_Eval}</th>
                            <th >${value.Eval_HW}</th>
                            <th >${value.Eval_Degree}</th>
                            <th style="font-size: 11px;font-weight: bold;" data-placement="top" data-toggle="tooltip" title="${value.Eval_TeacherComment === null ?  '' : value.Eval_TeacherComment}" >
                                ${value.Eval_TeacherComment === null ?  '' : value.Eval_TeacherComment.slice(0, 50)}
                            </th>
                            <th style="font-size: 11px;font-weight: bold;" data-placement="top" data-toggle="tooltip" title="${value.Eval_TeacherSugg === null ?  '' : value.Eval_TeacherSugg}" >
                                ${value.Eval_TeacherSugg === null ?  '' : value.Eval_TeacherSugg.slice(0, 50)}
                            </th>
                        </tr>

                    `);

                    $("#Eval_Date span").text(value.Eval_Date);
                    $("#Eval_GroupID span").text(value.GroupName);
                    $("#Eval_Years_Mat span").text(value.matFullName);
                    $("#Eval_Month span").text(value.Eval_Month);
                    $("#Eval_Year span").text(value.Eval_Year);

                    $("#exampleModalCenterShow .modal-title span").text(`${value.GroupName}`);
                });
            }
        });
    });
</script>
