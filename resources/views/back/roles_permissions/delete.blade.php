{{--@if(auth()->user()->role_relation->permissions_delete == 1)--}}
    <script>
        $(document).on("click" , "table .delete" ,function(e){
            e.preventDefault();
            var loop_id = $(this).attr("loop_id");


        alertify.confirm('{{ trans('app.Warning') }}', '{{ trans('app.Are You Sure Of Delete') }}',
            function(){
                $.ajax({
                    url: "{{ url('admin/roles_permissions/destroy') }}"+'/'+loop_id,
                    type: "get",
                    success: function(){
                        $('#datatable').DataTable().ajax.reload( null, false );

                        alertify.set('notifier','position', 'top-center');
                        alertify.set('notifier','delay', 4);
                        alertify.error("@lang('app.Completed Delete Successfully')");
                    },
                    error: function(){

                    }
                }); // end ajax

            }, // function success
            function(){
                alertify.set('notifier','position', 'bottom-right');
                alertify.set('notifier','delay', 4);
                alertify.error("@lang('app.canceled')");
            }); // function error
        });
    </script>
{{--@else
    <script>
        $(document).on("click" , "table .delete" ,function(e){
            alertify.set('notifier','position', 'bottom-right');
            alertify.set('notifier','delay', 4);
            alertify.error("لاتمتلك الصلاحيات لإتمام عملية الحذف");
        });
    </script>
@endif--}}

