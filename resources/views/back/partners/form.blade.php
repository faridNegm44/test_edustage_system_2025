<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
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
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="name">اسم الشريك</label>
                            <i class="fas fa-star require_input"></i>
                            <div>
                                <input type="text" class="form-control dataInput" placeholder="اسم الشريك" id="name" name="name">
                            </div>
                            <bold class="text-danger" id="errors-name" style="display: none;"></bold>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="phone">موبايل الشريك</label>
                            <div>
                                <input type="number" class="form-control dataInput numValid" placeholder="موبايل الشريك" id="phone" name="phone">
                            </div>
                            <bold class="text-danger" id="errors-phone" style="display: none;"></bold>
                        </div>
                    
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="status">حالة الشريك</label>
                            <div>
                                <select id="status" name="status" class="form-control">
                                    <option value="1">نشط</option>
                                    <option value="0">غير نشط</option>
                                </select>
                            </div>
                            <bold class="text-danger" id="errors-status" style="display: none;"></bold>
                        </div>
                    </div>
                    
                    <div class="row row-xs">                       

                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label for="email">ايميل الشريك</label>
                            <div>
                                <input type="email" class="form-control dataInput" placeholder="ايميل الشريك" id="email" name="email">
                            </div>
                            <bold class="text-danger" id="errors-email" style="display: none;"></bold>
                        </div>

                        <div class="col-lg-8 col-md-12">
                            <label for="address">عنوان الشريك</label>
                            <div>
                                <input type="text" class="form-control dataInput" placeholder="عنوان الشريك" id="address" name="address">
                            </div>
                            <bold class="text-danger" id="errors-address" style="display: none;"></bold>
                        </div>

                        {{--<div class="col-lg-3 col-md-6 col-sm-12">
                            <label for="first_money">الرصيد الإفتتاحي للشريك
                                <i class="fas fa-info-circle text-dark" data-bs-toggle="tooltip" title="💰 يُرجى إدخال الرصيد الافتتاحي للشريك. لا يمكن تعديله لاحقًا إلا من خلال إجراء تسوية مالية."></i>
                            </label>
                            <i class="fas fa-star require_input"></i>
                            <div>
                                <input type="number" class="form-control dataInput" id="first_money" name="first_money" placeholder="الرصيد الإفتتاحي للشريك">
                            </div>
                            <bold class="text-danger" id="errors-first_money" style="display: none;"></bold>
                        </div>--}}
                        
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <label for="commission_percentage">نسبة للشريك
                                <i class="fas fa-info-circle text-dark" data-bs-toggle="tooltip" title="📈 يجب إدخال نسبة الشريك. يجب أن تكون أكبر من 0 وتُكتب كنسبة مئوية (مثال: 10% أو 25%)."></i>
                            </label>
                            <i class="fas fa-star require_input"></i>
                            <div>
                                <input type="number" class="form-control dataInput" id="commission_percentage" name="commission_percentage" placeholder="نسبة للشريك">
                            </div>
                            <bold class="text-danger" id="errors-commission_percentage" style="display: none;"></bold>
                        </div>
                        
                        <div class="col-lg-6">
                            <label for="notes">ملاحظات</label>
                            <div>    
                                <input type="text" class="form-control dataInput" placeholder="ملاحظات" id="notes" name="notes">
                            </div>
                            <bold class="text-danger" id="errors-notes" style="display: none;"></bold>
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
