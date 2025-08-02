@if (auth()->user()->role_relation->admins_change_password == 1 )
    <form class="" id="form" enctype="multipart/form-data">
        @csrf

            <p style="font-weight: bold;color: rgb(76, 76, 161);padding: 5px 10px;">
                @lang('app.name'):
                @if (app()->getLocale() == 'en')
                    {{ $find['name_en'] }}
                @elseif (app()->getLocale() == 'ar')
                    {{ $find['name_ar'] }}
                @endif
            </p>
            <div class="form_bordred_sections">
                <div class="form-group mb-3">
                    <div class="row">

                        <div class="col-md-4">
                            <label for="old_password">{{ trans('app.old_password') }}</label>
                            <i class="fas fa-star require_input"></i>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control" placeholder="{{ trans('app.old_password') }}" id="old_password" name="old_password">
                            </div>
                            <bold class="text-danger" id="errors-old_password" style="display: none;"></bold>
                        </div>

                        <div class="col-md-4">
                            <label for="new_password">{{ trans('app.new_password') }}</label>
                            <i class="fas fa-star require_input"></i>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control" placeholder="{{ trans('app.new_password') }}" id="new_password" name="new_password">
                            </div>
                            <bold class="text-danger" id="errors-new_password" style="display: none;"></bold>
                        </div>

                        <div class="col-md-4">
                            <label for="confirmed_password">{{ trans('app.confirmed_password') }}</label>
                            <i class="fas fa-star require_input"></i>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control" placeholder="{{ trans('app.confirmed_password') }}" id="confirmed_password" name="confirmed_password">
                            </div>
                            <bold class="text-danger" id="errors-confirmed_password" style="display: none;"></bold>
                        </div>

                    </div>
                </div>
            </div>

            <br />

            <button type="button" id="save" class="btn btn-secondary btn-rounded waves-effect waves-light mb-2 me-2" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fas fa-times me-1"></i>
                @lang('app.close')
            </button>

            <button type="button" id="update_password" class="btn btn-dark btn-rounded waves-effect waves-light mb-2 me-2">
                <i class="fas fa-save me-1"></i>
                @lang('app.save')
            </button>
    </form>
@else
    <h4 class="text-center" style="margin: 100px auto;">
        لاتمتلك الصلاحيات لرؤيه محتوي الصفحة
        <img src="{{ url('back/images/rej2.png') }}" style="width: 80px;height: 78px;position: relative;bottom: 7px;bo"/>
    </h4>
@endif


<script>
    $("#offcanvasWithBothOptions .offcanvas-title").text("@lang('app.change_password')").css("color", "#FFF");
    $("#offcanvasWithBothOptions .offcanvas-header").css("background", "#000");

    $(document).ready(function(){
        $('.select2').select2({
            dropdownParent: $('#offcanvasWithBothOptions'),
        });
    });

    $("#offcanvasWithBothOptions #update_password").click(function(e){
        e.preventDefault();
        var id = {{ $find['id'] }};

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ url('admin/admins/change_password') }}"+'/'+id,
            type: 'POST',
            processData: false,
            contentType: false,
            data: new FormData($('#offcanvasWithBothOptions #form')[0]),
            success: function(res){

                $("#offcanvasWithBothOptions").offcanvas('hide');
                $('#datatable').DataTable().ajax.reload( null, false );

                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.success("@lang('app.Completed Change Password Successfully')");

            },
            error: function(res){
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.error("@lang('app.there is something wrong')");

                if(res.responseJSON.errors.old_password){
                    $("form #errors-old_password").css('display' , 'block').text(res.responseJSON.errors.old_password);
                }else{
                    $("form #errors-old_password").text('');
                }
                if(res.responseJSON.errors.new_password){
                    $("form #errors-new_password").css('display' , 'block').text(res.responseJSON.errors.new_password);
                }else{
                    $("form #errors-new_password").text('');
                }
                if(res.responseJSON.errors.confirmed_password){
                    $("form #errors-confirmed_password").css('display' , 'block').text(res.responseJSON.errors.confirmed_password);
                }else{
                    $("form #errors-confirmed_password").text('');
                }
            }
        });
    });


    ///////////////////////////////// Edit By Button Enter /////////////////////////////////
    $("#form").keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var id = {{ $find['id'] }};

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ url('admin/admins/change_password') }}"+'/'+id,
                type: 'POST',
                processData: false,
                contentType: false,
                data: new FormData($('#offcanvasWithBothOptions #form')[0]),
                success: function(res){

                    $("#offcanvasWithBothOptions").offcanvas('hide');
                    $('#datatable').DataTable().ajax.reload( null, false );

                    $(".all_jobs").load(" .all_jobs");
                    $(".active_jobs").load(" .active_jobs");
                    $(".not_active_jobs").load(" .not_active_jobs");

                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 4);
                    alertify.success("@lang('app.Completed Update Successfully')");

                },
                error: function(res){
                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 4);
                    alertify.error("@lang('app.there is something wrong')");

                    if(res.responseJSON.errors.email){
                        $("form #errors-email").css('display' , 'block').text(res.responseJSON.errors.email);
                    }else{
                        $("form #errors-email").text('');
                    }
                    if(res.responseJSON.errors.password){
                        $("form #errors-password").css('display' , 'block').text(res.responseJSON.errors.password);
                    }else{
                        $("form #errors-password").text('');
                    }
                    if(res.responseJSON.errors.confirmed_password){
                        $("form #errors-confirmed_password").css('display' , 'block').text(res.responseJSON.errors.confirmed_password);
                    }else{
                        $("form #errors-confirmed_password").text('');
                    }
                }
            });
        }
    });
</script>
