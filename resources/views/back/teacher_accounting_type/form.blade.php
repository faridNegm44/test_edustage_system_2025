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

                <div class="bg-info-transparent" style="padding: 15px 30px !important;">
                    <div class="row row-xs"> 
                      <div class="col-12">
                        <label for="teacher">المدرس</label>
                        <div>    
                            <select name="teacher" class="selectize teacher" id="teacher">
                              @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->ID }}">{{ $teacher->TheName }}</option>  
                              @endforeach
                            </select>
                        </div>
                        <bold class="text-danger" id="errors-teacher" style="display: none;"></bold>
                      </div> 

                      <div class="col-md-4 col-12">
                        <label for="static_value">قيمة ثابتة</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                            <input type="number" class="form-control dataInput" placeholder="قيمة ثابتة" id="static_value" name="static_value" min="0">
                        </div>
                        <bold class="text-danger" id="errors-static_value" style="display: none;"></bold>
                      </div>    
                      
                      <div class="col-md-4 col-12">
                        <label for="percentage_value">نسبة %</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                            <input type="number" class="form-control dataInput" placeholder="نسبة %" id="percentage_value" name="percentage_value" min="0">
                        </div>
                        <bold class="text-danger" id="errors-percentage_value" style="display: none;"></bold>
                      </div>                          
                      
                      <div class="col-md-4 col-12">
                        <label for="tax">ضريبة</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                            <input type="number" class="form-control dataInput" placeholder="ضريبة" id="tax" name="tax" min="0">
                        </div>
                        <bold class="text-danger" id="errors-tax" style="display: none;"></bold>
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
