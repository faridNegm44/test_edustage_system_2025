<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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

                      {{------------------------ start right ----------------------}}
                      <div class="col-md-6 card bg-secondary-transparent" style="padding: 0 20px 12px;"> 
                         <div class="row">
                          <div class="col-12">
                            <label for="TheDate">تاريخ الدفع</label>
                            <i class="fas fa-star require_input"></i>
                            <div>
                                <input type="text" class="form-control datePicker" placeholder="تاريخ الدفع" id="TheDate" name="TheDate">
                            </div>
                            <bold class="text-danger" id="errors-TheDate" style="display: none;"></bold>
                          </div>

                          <div class="col-12">
                            <label for="TheNotes">ملاحظات</label>
                            <div>
                              <textarea class="form-control dataInput" placeholder="ملاحظات" id="TheNotes" name="TheNotes" rows="6"></textarea>
                            </div>
                            <bold class="text-danger" id="errors-TheNotes" style="display: none;"></bold>
                          </div>
                          
                        </div>
                      </div>
                      {{------------------------ end right ----------------------}}


                      {{------------------------ start left ----------------------}}
                      <div class="col-md-6 card bg-info-transparent" style="padding: 0 20px 12px;"> 
                         <div class="row">
                          <div class="col-12">
                            <label for="PartnerID">الشركاء</label>
                            <div>    
                                <select name="PartnerID" class="selectize PartnerID" id="PartnerID">
                                    <option value="" disabled selected>اختر شريك</option>
                                    @foreach ($partners as $partner)
                                      <option value="{{ $partner->id }}">{{ $partner->name }}</option>                                      
                                    @endforeach
                                </select>
                            </div>
                            <bold class="text-danger" id="errors-PartnerID" style="display: none;"></bold>
                          </div>
                          
                          <div class="col-12">
                            <label for="WalletID">المحفظة</label>
                            <div>    
                                <select name="WalletID" class="selectize WalletID" id="WalletID">
                                    <option value="" disabled selected>اختر محفظة</option>
                                    @foreach ($wallets as $wallet)
                                      <option value="{{ $wallet->WalletID }}">{{ $wallet->WalletName }}</option>                                      
                                    @endforeach
                                </select>
                            </div>
                            <bold class="text-danger" id="errors-WalletID" style="display: none;"></bold>
                          </div>
                          
                          <div class="col-12">
                            <label for="TheAmount">الميلغ</label>
                            <i class="fas fa-star require_input"></i>
                            <div>
                                <input type="number" class="form-control dataInput" placeholder="الميلغ" id="TheAmount" name="TheAmount" style="font-size: 20px !important;text-align: center;" min="1">
                            </div>
                            <bold class="text-danger" id="errors-TheAmount" style="display: none;"></bold>
                          </div>    

                        </div>
                      </div>
                      {{------------------------ end left ----------------------}}
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
