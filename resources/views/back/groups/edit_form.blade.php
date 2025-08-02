<div class="modal fade editForm" id="editForm" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">تعديل</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
            <form class="" id="form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="res_id" value="" />               

                <div class="pd-30 pd-sm-40 bg-gray-100">
                    <div class="row row-xs">  
                      <div class="row">                        
                        
                        <div class="col-lg-4">
                          <label for="ID">رقم المجموعة</label>
                          <div>
                            <input type="text" id="ID" readonly class="dataInput form-control" placeholder="رقم المجموعة">
                          </div>
                          <bold class="text-danger" id="errors-ID" style="display: none;"></bold>
                        </div>  
                        
                        <div class="col-lg-8">
                          <label for="GroupName">اسم المجموعة</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                            <input type="text" id="GroupName" name="GroupName" class="dataInput form-control" placeholder="اسم المجموعة">
                          </div>
                          <bold class="text-danger" id="errors-GroupName" style="display: none;"></bold>
                        </div>  
                        
                        <div class="col-lg-12">
                          <label for="ClassNo1">حصص متوقعة</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                            <input type="text" id="ClassNo1" name="ClassNo1" class="dataInput form-control text-center" placeholder="حصص متوقعة" style="font-size: 20px !important;">
                          </div>
                          <bold class="text-danger" id="errors-ClassNo1" style="display: none;"></bold>
                        </div>  

                      </div>   
                    </div>
                </div>

                <div class="modal-footer">                                               
                    <button type="button" id="update" class="btn btn-primary btn-rounded">
                      تعديل
                      <span class="spinner-border spinner-border-sm spinner_request2" role="status" aria-hidden="true"></span>
                    </button>

                    <button id="closeModal" type="button" class="btn btn-outline-secondary btn-rounded" data-dismiss="modal">اغلاق</button>
                </div>

            </form>            
        </div>
      </div>
    </div>
</div>
