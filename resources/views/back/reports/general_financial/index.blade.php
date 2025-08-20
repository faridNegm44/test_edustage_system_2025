
@extends('back.layouts.app')

@section('title')
    {{ $pageNameAr }}
@endsection

@section('header')
    <style>
        .ajs-success, .ajs-error{
            min-width: 500px !important;
        }
    </style>
@endsection

@section('footer')  
    <script>       
        // remove all errors when close modal
        $('.modal').on('hidden.bs.modal', function(){
            $('form [id^=errors]').text('');
        });
        


        // cancel enter button 
        $(document).keypress(function (e) {
            if(e.which == 13){
                e.preventDefault();  
            }
        });

        // selectize
        $('.selectize').selectize({
            hideSelected: true
        });

        // flatpickr
        flatpickr(".datePicker", {
            dateFormat: "d-m-Y",
            defaultDate: new Date()
        });
    </script>


    <script>
    </script>

    {{-- start when click to button form submit--}}
    <script>
        $(document).on('submit', 'form', function(e) {
            e.preventDefault();

            const from = $('#from').val();
            const to = $('#to').val();
            if(!from || !to){
                alertify.set('notifier','position', 'top-center');
                alertify.set('notifier','delay', 4);
                alertify.error('⚠️  📚 حدد تاريخ البداية 📅 والنهاية قبل عرض التقرير');

                return false;
            }else{
                $("form").find('input[name="_token"]').remove();
                let formData = $("form").serialize();
                let printUrl = "{{ url('report/general-financial/result/pdf') }}?" + formData;
    
                window.location.href = printUrl;
            }
        });
    </script>
    {{-- end when click to button form submit --}}
@endsection


@section('content')
    <div class="container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header text-danger" style="display: block !important;text-align: center;margin-bottom: 15px;">
            <h4 class="content-title mb-5 my-auto">{{ $pageNameAr }}</h4>
        </div>
        <!-- breadcrumb -->

        @if (session('notFound'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('notFound') }}

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="float: left;font-size: 30px;">&times;</span>
                </button>
            </div>
        @endif
        
        <div class="card bg bg-primary" style="padding: 20px 0 !important;">
            <div class="card-body">
                <form>
                    @csrf
                    <div class="row justify-content-center">                    
                                        
                        <div class="col-md-2">
                            <div>
                                <input type="text" class="form-control dataInput datePicker" placeholder="من" id="from" name="from" required>
                            </div>
                            <bold class="text-danger" id="errors-from" style="display: none;"></bold>
                        </div>    
                        
                        <div class="col-md-2">
                            <div>
                                <input type="text" class="form-control dataInput datePicker" placeholder="الي" id="to" name="to" required>
                            </div>
                            <bold class="text-danger" id="errors-to" style="display: none;"></bold>
                        </div>    

                        <div class="col-md-2">
                            <div>
                                <button type="submit" class="btn btn-warning-gradient btn-block" style="height: 30px;padding: 0 20px !important;">عرض</button>
                            </div>
                            <bold class="text-danger" id="errors-to" style="display: none;"></bold>
                        </div>    
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

