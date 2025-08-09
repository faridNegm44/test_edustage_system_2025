<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
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
                <input type="hidden" id="res_id" value="" />               

                <div class="bg-info-transparent" style="padding: 15px 30px !important;">
                    <div class="row row-xs">  
                      
                      {{-- start right --}}
                        <div class="col-lg-7 " style="padding: 0 15px !important;">
                          
                          <div class="row">
                            <div class="col-lg-6">
                              <label for="TheDate">تاريخ الدفع</label>    
                              <i class="fas fa-star require_input"></i>                          
                              <div>
                                <input type="text" id="TheDate" name="TheDate" class="dataInput text-center datePicker form-control" placeholder="تاريخ الدفع" />
                              </div>
                              <bold class="text-danger" id="errors-TheDate" style="display: none;"></bold>
                            </div>
    
                            <div class="col-lg-6">
                              <label for="ParentID">ولي الأمر</label>
                              <i class="fas fa-star require_input"></i>
                              <div>
                                <select id="ParentID" name="ParentID" class="selectize dataInput">
                                    <option value="" selected disabled>اختر ولي أمر</option>
                                    @foreach ($parents as $parent)
                                      <option value="{{ $parent->ID }}">{{ $parent->ID }} - {{ $parent->TheName0 }}</option>
                                    @endforeach
                                </select>
                              </div>
                              <bold class="text-danger" id="errors-ParentID" style="display: none;"></bold>
                            </div>    
                          </div>       
                          

                          <div class="row">
                            <div class="col-lg-6">
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
                                    <option value="CowPay">CowPay</option>
                                    <option value="غير ذلك">غير ذلك</option>
                                </select>
                              </div>
                              <bold class="text-danger" id="errors-ThePayType" style="display: none;"></bold>
                            </div>                                                  

                            <div class="col-lg-6">
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
                          </div>                        

                          <div class="row">     
                            <div class="col-lg-4">
                              <label for="status">الحالة</label>
                              <div>    
                                  <select name="status" class="form-control status" id="status">
                                      <option value="مؤكد">مؤكد</option>
                                      <option value="غير مؤكد">غير مؤكد</option>
                                  </select>
                              </div>
                              <bold class="text-danger" id="errors-status" style="display: none;"></bold>
                            </div> 

                            <div class="col-lg-4">
                              <label for="sender_name">اسم المرسل</label>   
                              <i class="fas fa-star require_input"></i>                         
                              <div>
                                <input type="text" id="sender_name" name="sender_name" class="dataInput form-control" placeholder="اسم المرسل"  />
                              </div>
                              <bold class="text-danger" id="errors-sender_name" style="display: none;"></bold>
                            </div>    

                            <div class="col-lg-4">
                              <label for="invoice_number">رقم الوصل</label>  
                              <div>
                                <input type="text" id="invoice_number" name="invoice_number" class="dataInput form-control" placeholder="رقم الوصل" />
                              </div>
                              <bold class="text-danger" id="errors-invoice_number" style="display: none;"></bold>
                            </div>    
                          </div>

                          <div class="row">                             
                            <div class="col-lg-4">
                              <label for="currency">العملة</label>   
                              <i class="fas fa-star require_input"></i>                         
                              <div>
                                <select id="currency" name="currency" class="form-control dataInput">
                                    <option value="جنية مصري" selected>جنية مصري</option>
                                    <option value="دولار">دولار</option>
                                    <option value="يورو">يورو</option>
                                    <option value="ريال سعودي">ريال سعودي</option>
                                    <option value="دينار كويتي">دينار كويتي</option>
                                </select>
                              </div>
                              <bold class="text-danger" id="errors-currency" style="display: none;"></bold>
                            </div>    

                            <div class="col-lg-4">
                              <label for="TheAmount">المبلغ بالعملة</label>  
                              <i class="fas fa-star require_input"></i>                          
                              <div>
                                <input type="number" id="TheAmount" name="TheAmount" class="dataInput text-center form-control" placeholder="المبلغ بالعملة" value="0">
                              </div>
                              <bold class="text-danger" id="errors-TheAmount" style="display: none;"></bold>
                            </div>    

                            <div class="col-lg-4">
                              <label for="expense_price">سعر الصرف</label>  
                              <div>
                                <input type="number" id="expense_price" readonly name="expense_price" class="dataInput text-center form-control" placeholder="سعر الصرف" value="1">
                              </div>
                              <bold class="text-danger" id="errors-expense_price" style="display: none;"></bold>
                            </div>    

                            <div class="col-lg-4">
                              <label for="transfer_expense">مصاريف تحويل</label>  
                              <div>
                                <input type="number" id="transfer_expense" name="transfer_expense" class="dataInput text-center form-control" placeholder="مصاريف تحويل" value="0">
                              </div>
                              <bold class="text-danger" id="errors-transfer_expense" style="display: none;"></bold>
                            </div>    

                            <div class="col-lg-4">
                              <label for="amount_by_currency">المبلغ النهائي</label>  
                              <div>
                                <input type="number" id="amount_by_currency" name="amount_by_currency" class="dataInput text-center form-control" placeholder="المبلغ النهائي" value="0">
                              </div>
                              <bold class="text-danger" id="errors-amount_by_currency" style="display: none;"></bold>
                            </div>    

                            <div class="col-lg-4">
                              <label for="image">ملف اثبات</label>  
                              <div>
                                <input type="file" id="image" name="image" class="dataInput form-control" />
                              </div>
                              <bold class="text-danger" id="errors-image" style="display: none;"></bold>
                            </div>    
                          </div>
                        </div>
                      {{-- end right --}}


                      {{-- start left --}}
                        <div class="col-lg-5 " style="padding: 0 15px !important;">                                         
                          <div>
                            <label for="TheNotes">ملاحظات ولي الأمر</label>        
                            <div>
                              <textarea id="TheNotes" name="TheNotes" class="dataInput form-control" rows="2" placeholder="ملاحظات ولي الأمر"></textarea>
                            </div>
                            <bold class="text-danger" id="errors-TheNotes" style="display: none;"></bold>
                          </div>

                          <div>
                            <label for="admin_notes">ملاحظات الإدارة</label>        
                            <div>
                              <textarea id="admin_notes" name="admin_notes" class="dataInput form-control" rows="2" placeholder="ملاحظات الإدارة"></textarea>
                            </div>
                            <bold class="text-danger" id="errors-admin_notes" style="display: none;"></bold>
                          </div>

                          <label class="text-bold" style="margin: 10px;">هدية الشهر</label>
                          <br>
                          <small class="alert alert-danger">🤔🎁 هل حصل ولي الأمر على هدية؟</small>
                          <div class="row" style="border: 1px solid red;border-radius: 5px;margin: 0;padding: 10px 0;">
                            <div class="col-6">
                              <label for="hasGift"> 🤔 لة هدية؟</label>
                              <div>
                                <select id="hasGift" name="hasGift" class="dataInput form-control">
                                  <option value="لاء" >لاء</option>                                
                                  <option value="نعم" >نعم</option>
                                </select>
                              </div>
                              <bold class="text-danger" id="errorshasGift" style="display: none;"></bold>
                            </div>
                            
                            <div class="col-6" id="giftSection" style="display: none;">
                              <label for="gift"> 🎁مبلغ الهدية</label>
                              <div>
                                <input type="number" id="gift" name="gift" class="dataInput form-control text-center" placeholder="مبلغ الهدية" value="0">
                              </div>
                              <bold class="text-danger" id="errorsgift" style="display: none;"></bold>
                            </div>
                          </div>
                        </div>
                      {{-- end left --}}
                        
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
