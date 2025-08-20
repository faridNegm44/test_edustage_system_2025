$("#duplicatedEmailsTableBody").empty();

res.duplicated_emails.forEach(function(user){
    let user_status = '';
    let user_link = '';

    if(user.user_status == 1){
        user_status = 'سوبر أدمن';
        user_link = "{{ url('users') }}";
    }else if(user.user_status == 2){
        user_status = 'موظف';
        user_link = "{{ url('users') }}";
    }else if(user.user_status == 3){
        user_status = 'ولي أمر';
        user_link = "{{ url('parents') }}";
    }else if(user.user_status == 4){
        user_status = 'مدرس';
        user_link = "{{ url('teachers') }}";
    }else if(user.user_status == 5){
        user_status = 'طالب';
        user_link = "{{ url('students') }}";
    }

    $("#duplicatedEmailsTableBody").append(`
        <tr>
            {{--<td>${user.id}</td>--}}
            <td style="font-size: 14px !important;">
                <a href="${user_link}" target="_blank">${user.name}</a>    
            </td>
            <td>${user_status}</td>
            <td>${user.email}</td>
        </tr>
    `);
});

$("#duplicatedEmailsModal").modal('show');

return false;