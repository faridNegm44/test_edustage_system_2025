<script>
    $(document).on("click" , "table .delete" ,function(e){
    e.preventDefault();
    let res_id = $(this).attr("res_id");

    alertify.confirm('تحذير !!', 'هل أنت متأكد من الحذف ؟',
      function(){
          $.ajax({
              url: `{{ url('crm/columns_name/update/${res_id}') }}`,
              type: "get",
              success: function(){
                  $('#example1').DataTable().ajax.reload( null, false );

                  alertify.set('notifier','position', 'bottom-right');
                  alertify.set('notifier','delay', 4);
                  alertify.success("تم الحذف بنجاح");
              }
          });
      },
      function(){
          alertify.set('notifier','position', 'bottom-right');
          alertify.set('notifier','delay', 4);
          alertify.error("تم إلغاء الحذف");
      });
    });
</script>