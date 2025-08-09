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
                <input type="hidden" id="res_id" value="" />               

                <div class="bg-info-transparent" style="padding: 15px 30px !important;">
                    <div class="row row-xs">  
                      
                      <div class="col-12">
                        <label for="TheDate">تاريخ الدفع</label>    
                        <i class="fas fa-star require_input"></i>                          
                        <div>
                          <input type="text" id="TheDate" name="TheDate" class="dataInput text-center datePicker form-control" placeholder="تاريخ الدفع" />
                        </div>
                        <bold class="text-danger" id="errors-TheDate" style="display: none;"></bold>
                      </div>

                      <div class="col-12">
                        <label for="TeacherID">المدرس</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                          <select id="TeacherID" name="TeacherID" class="selectize dataInput">
                              <option value="" selected disabled>اختر مدرس</option>
                              @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->ID }}">{{ $teacher->ID }} - {{ $teacher->TheName }}</option>
                              @endforeach
                          </select>
                        </div>
                        <bold class="text-danger" id="errors-TeacherID" style="display: none;"></bold>
                      </div>    
                      
                      <div class="col-12">
                        <label for="TheType">نوع العملية</label>
                        <div>    
                            <select name="TheType" class="form-control TheType" id="TheType">
                              <option value="سلفة">سلفة</option>
                              <option value="تسديد حساب">تسديد حساب</option>
                              <option value="خصم">خصم</option>
                            </select>
                        </div>
                        <bold class="text-danger" id="errors-TheType" style="display: none;"></bold>
                      </div> 

                      <div class="col-12">
                        <label for="ThePayType">طريقة الدفع</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                          <select id="ThePayType" name="ThePayType" class="form-control dataInput">
                              <option value="" selected disabled>اختر طريقة دفع</option>
                              <option value="حساب البنك الأهلي المصري">حساب البنك الأهلي المصري</option>
                              <option value="حساب بنك مصر">حساب بنك مصر</option>
                              <option value="حساب البريد المصري">حساب البريد المصري</option>
                              <option value="حساب بنك CIB">حساب بنك CIB</option>
                              <option value="فودافون كاش">فودافون كاش</option>
                              <option value="تسليم نقدي">تسليم نقدي</option>
                              <option value="غير ذلك">غير ذلك</option>
                          </select>
                        </div>
                        <bold class="text-danger" id="errors-ThePayType" style="display: none;"></bold>
                      </div>                                                  

                      <div class="col-12">
                        <label for="WalletID">المحفظة</label>
                        <i class="fas fa-star require_input"></i>                      
                        <div>
                          <select id="WalletID" name="WalletID" class="form-control dataInput">
                              <option value="" selected disabled>اختر محفظة</option>
                              @foreach ($wallets as $wallet)
                                <option value="{{ $wallet->WalletID }}">{{ $wallet->WalletID }} - {{ $wallet->WalletName }}</option>
                              @endforeach
                          </select>
                        </div>
                        <bold class="text-danger" id="errors-WalletID" style="display: none;"></bold>
                      </div>  
                     
                      <div class="col-12">
                        <label for="TheAmount">المبلغ</label>    
                        <i class="fas fa-star require_input"></i>                          
                        <div>
                          <input type="number" id="TheAmount" name="TheAmount" class="text-center form-control focus_input" placeholder="المبلغ" value="0" style="font-size: 20px !important;"/>
                        </div>
                        <bold class="text-danger" id="errors-TheAmount" style="display: none;"></bold>
                      </div>

                      <div class="col-12">
                        <label for="TheNotes">ملاحظات</label>        
                        <div>
                          <textarea id="TheNotes" name="TheNotes" class="dataInput form-control" rows="2" placeholder="ملاحظات"></textarea>
                        </div>
                        <bold class="text-danger" id="errors-TheNotes" style="display: none;"></bold>
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
