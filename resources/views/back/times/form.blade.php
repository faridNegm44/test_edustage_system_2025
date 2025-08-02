<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"></h5>
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
                      <div class="col-md-12">
                        <label for="time">الوقت</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                            <input type="text" class="form-control datePicker dataInput" placeholder="الوقت" id="time" name="time" value="">
                        </div>
                        <bold class="text-danger" id="errors-time" style="display: none;"></bold>
                      </div>    
                      
                      <div class="col-md-12">
                        <label for="am_pm">صباحاً/مساءاً</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                            <select id="am_pm" name="am_pm" class="form-control">
                              <option value="ص" selected>صباحاً</option>
                              <option value="م">مساءاً</option>
                            </select>
                        </div>
                        <bold class="text-danger" id="errors-am_pm" style="display: none;"></bold>
                      </div>        
                      
                      <div class="col-md-12">
                        <label for="order">الترتيب</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                            <input type="number" class="form-control dataInput" placeholder="الترتيب" id="order" name="order" value="{{ $lastOrder == null ? 1 : ($lastOrder['order']+1) }}">
                        </div>
                        <bold class="text-danger" id="errors-order" style="display: none;"></bold>
                      </div>                                                                                                                                                 
                    </div>
                </div>

                <div class="modal-footer">                                               
                    <button type="button" id="save" class="btn btn-primary btn-rounded" style="display: none;">
                      حفظ
                      <span class="spinner-border spinner-border-sm spinner_request" role="status" aria-hidden="true"></span>
                    </button>

                    <button type="button" id="update" class="btn btn-success btn-rounded" style="display: none;">
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
