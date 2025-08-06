<div class="modal fade" id="crmModal" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
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
              <input type="hidden" id="parent_id" name="parent_id" value="" />               

              @foreach ($crmCategories as $crmCategory)
                  <div id="crmCateg_{{ $crmCategory->id }}">
                      <div class="categName">{{ $crmCategory->name }}</div>
                      
                      <div class="bg-info-transparent" style="padding: 15px 30px !important;">
                        <div class="row row-xs">
                          @foreach ($crmNamesEmpty as $crmName)
                              @if ($crmCategory->id == $crmName->category)                              

                                <div class="col-md-4">
                                    <label for="{{ $crmName->name_ar }}" style="color: red;">{{ $crmName->name_ar }}</label>
                                    <div>
                                        <textarea class="form-control dataInput" name="columnValue[]" id="col{{ $crmName->id }}" style="border-radius: 10px;font-size: 11px;font-weight: bold;" rows="4"></textarea>
                                    </div>
                                </div>
                                  
                              @endif
                          @endforeach
                        </div>                
                      </div>
                  </div>
              @endforeach

              

              <div class="modal-footer">                                               
                  <button type="button" class="btn btn-primary btn-rounded save">
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
