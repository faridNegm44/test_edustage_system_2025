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

              <div class="pd-30 pd-sm-40 bg-gray-100">
                  <div class="row row-xs">                                     
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
                  </div>
              </div>

              <div class="modal-footer">                                               
                <button type="button" id="save" class="btn btn-primary btn-rounded" style="display: none;">
                  حفظ
                  <span class="spinner-border spinner-border-sm spinner_request" role="status" aria-hidden="true"></span>
                </button>
                  
                <button id="closeModal" type="button" class="btn btn-outline-secondary btn-rounded" data-dismiss="modal">اغلاق</button>
              </div> 

          </form>            
      </div>
    </div>
  </div>
</div>
