<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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

                        <div class="col-md-6">
                            <label for="category">القسم</label>
                            <i class="fas fa-star require_input"></i>
                            <div>
                              <select id="category" name="category" class="form-control dataInput">
                                <option value="" disabled selected>اختر قسم أولآ</option>
                                @foreach ($crm_categories as $item)
                                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            </div>
                            <bold class="text-danger" id="errors-category" style="display: none;"></bold>
                        </div>                        
                         
                        <div class="col-md-6">
                            <label for="order">ترتيب العنصر حسب المجموعة</label>
                            <i class="fas fa-star require_input"></i>
                            <div>
                                <input type="number" class="form-control dataInput" placeholder="ترتيب العنصر حسب المجموعة" id="order" name="order">
                            </div>
                            <bold class="text-danger" id="errors-order" style="display: none;"></bold>
                        </div>                                                               
                        
                        <div class="col-md-6">
                            <label for="name_ar">الإسم بالعربية</label>
                            <i class="fas fa-star require_input"></i>
                            <div>
                                <input type="text" class="form-control dataInput" placeholder="الإسم بالعربية" id="name_ar" name="name_ar">
                            </div>
                            <bold class="text-danger" id="errors-name_ar" style="display: none;"></bold>
                        </div>                        

                        <div class="col-md-6">
                          <label for="status">الحالة</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                              <select id="status" name="status" class="form-control">
                                <option value="1" selected>نشط</option>
                                <option value="0">معطل</option>
                              </select>
                          </div>
                          <bold class="text-danger" id="errors-status" style="display: none;"></bold>
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
