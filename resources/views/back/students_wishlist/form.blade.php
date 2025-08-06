<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
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
              <input type="hidden" id="student_id" value="" />               

              <div class="bg-info-transparent" style="padding: 15px 30px !important;">
                  <div class="row row-xs">                 
                    <div class="col-md-6 col-12">
                      <label for="ThePackage">الباقة</label>
                      <div>
                        <select id="ThePackage" name="ThePackage" class="form-control">
                          <option value="باقة التوفير">باقة التوفير</option>
                          <option value="باقة 1 طالب">باقة 1 طالب</option>
                          <option value="باقة 2 طالب">باقة 2 طالب</option>
                          <option value="باقة 3-6 طالب">باقة 3-6 طالب</option>
                        </select>
                      </div>
                      <bold class="text-danger" id="errors-ThePackage" style="display: none;"></bold>
                    </div>  
                    
                    <div class="col-md-6 col-12">
                      <label for="TheTime">الفترة</label>
                      <div>
                        <select id="TheTime" name="TheTime" class="form-control">
                          <option value="صباحاً">صباحاً</option>
                          <option value="مساءاً">مساءاً</option>
                        </select>
                      </div>
                      <bold class="text-danger" id="errors-TheTime" style="display: none;"></bold>
                    </div>  



                    <div class="col-12">
                      <label for="YearID">الصفوف والمواد الدراسية</label>
                      <i class="fas fa-star require_input"></i>
                      <div>
                        <select id="YearID" name="YearID" class="selectize">
                            <option selected disabled></option>
                            @foreach ($subjects as $subjects)
                              <option value="{{ $subjects->ID }}">{{ $subjects->ID }} - الصف: {{ $subjects->TheYear }} - المادة: {{ $subjects->TheMat }}</option>
                            @endforeach
                        </select>
                      </div>
                      <bold class="text-danger" id="errors-YearID" style="display: none;"></bold>
                    </div>           
                     
                    <div class="col-12">
                      <label for="TheNotes">ملاحظات</label>
                      <div>
                        <textarea class="form-control dataInput" placeholder="ملاحظات" id="TheNotes" name="TheNotes" rows="3"></textarea>
                      </div>
                      <bold class="text-danger" id="errors-TheNotes" style="display: none;"></bold>
                    </div>    
                    
                  </div>
              </div>

              <div class="modal-footer">                                               
                <button type="button" id="save" class="btn btn-primary btn-rounded" style="display: none;">
                  حفظ الرغبة
                  <span class="spinner-border spinner-border-sm spinner_request" role="status" aria-hidden="true"></span>
                </button>
                  
                <button id="closeModal" type="button" class="btn btn-outline-secondary btn-rounded" data-dismiss="modal">اغلاق</button>
              </div> 

          </form>            
      </div>
    </div>
  </div>
</div>
