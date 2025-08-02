<script>
    $(document).on("click" , "#datatable tr .delete" ,function(e){
        e.preventDefault();
        var row_id = $(this).attr("row_id");


    alertify.confirm('تحذير !!', 'هل أنت متأكد من حذف هذا المستخدم ؟',
        function(){
            $.ajax({
                url: "{{ url('admin/admins/destroy') }}"+'/'+row_id,
                type: "get",
                success: function(){
                    $('#datatable').DataTable().ajax.reload( null, false );

                    alertify.set('notifier','position', 'top-center');
                    alertify.set('notifier','delay', 4);
                    alertify.error("تم الحذف بنجاح");
                },
                error: function(){

                }
            }); // end ajax

        }, // function success
        function(){
            alertify.set('notifier','position', 'bottom-right');
            alertify.set('notifier','delay', 4);
            alertify.error("تم إلغاء الحذف");
        }); // function error
    });
</script>