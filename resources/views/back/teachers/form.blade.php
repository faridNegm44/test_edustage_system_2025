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
              <input type="hidden" id="teacher_id" value="" />               

              <div class="" style="padding: 15px 30px !important;">
                  <div class="row row-xs">                 

                     {{------------------------ start right ----------------------}}
                     <div class="col-md-4 card bg-secondary-transparent" style="padding: 0 20px 12px;"> 
                      <div class="row">
                        <div class="col-12">
                          <label for="TheName">اسم المدرس</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                              <input type="text" class="form-control dataInput" placeholder="اسم المدرس" id="TheName" name="TheName">
                          </div>
                          <bold class="text-danger" id="errors-TheName" style="display: none;"></bold>
                        </div>

                        <div class="col-12">
                          <label for="TheEmail">البريد الإلكتروني</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                              <input type="email" class="form-control dataInput" placeholder="البريد الإلكتروني" id="TheEmail" name="TheEmail">
                          </div>
                          <bold class="text-danger" id="errors-TheEmail" style="display: none;"></bold>
                        </div>  
  
                        <div class="col-12">
                          <label for="ThePass">الرقم السري</label>
                          <div>
                              <input type="password" class="form-control dataInput" placeholder="الرقم السري" id="ThePass" name="ThePass">
                          </div>
                          <bold class="text-danger" id="errors-ThePass" style="display: none;"></bold>                          
                        </div>  

                        <div class="col-12">
                          <label for="TheBirthDate">تاريخ المبلاد</label>
                          <div>
                              <input type="text" class="form-control datePicker dataInput" placeholder="تاريخ المبلاد" id="TheBirthDate" name="TheBirthDate">
                          </div>
                          <bold class="text-danger" id="errors-TheBirthDate" style="display: none;"></bold>
                        </div>
                        
                        <div class="col-12">
                          <label for="TheCurrentJob">العمل الحالي</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                              <input type="text" class="form-control dataInput" placeholder="العمل الحالي" id="TheCurrentJob" name="TheCurrentJob">
                          </div>
                          <bold class="text-danger" id="errors-TheCurrentJob" style="display: none;"></bold>
                        </div>

                      </div>
                    </div>
                    {{------------------------ end right ----------------------}}



                     {{------------------------ start left ----------------------}}
                     <div class="col-md-8 card bg-info-transparent" style="padding: 0 20px 12px;">
                      <div class="row">         

                        <div class="col-lg-3 col-12">
                          <label for="NatID">الجنسية</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                            <select id="NatID" name="NatID" class="selectize dataInput">
                                @foreach ($nats as $nat)
                                    <option value="{{ $nat->ID }}">{{ $nat->TheName }}</option>
                                @endforeach
                            </select>
                          </div>
                          <bold class="text-danger" id="errors-NatID" style="display: none;"></bold>
                        </div>    
                    
                        <div class="col-lg-3 col-12">
                          <label for="CityID">مكان الإقامة</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                            <select id="CityID" name="CityID" class="selectize dataInput">
                                @foreach ($cities as $citie)
                                    <option value="{{ $citie->ID }}">{{ $citie->TheCity }}</option>
                                @endforeach
                            </select>
                          </div>
                          <bold class="text-danger" id="errors-CityID" style="display: none;"></bold>
                        </div>

                        <div class="col-lg-3 col-12">
                          <label for="HaveEx">خبرة تدريس أونلاين</label>
                          <i class="fas fa-star require_input"></i>
                          <div>    
                              <select name="HaveEx" class="form-control HaveEx" id="HaveEx">
                                  <option value="نعم">نعم</option>
                                  <option value="لا">لا</option>
                              </select>
                          </div>
                          <bold class="text-danger" id="errors-HaveEx" style="display: none;"></bold>
                        </div> 

                        <div class="col-lg-3 col-12">
                          <label for="TheExNumber">سنوات الخبرة</label>
                          <div>
                              <input type="number" class="form-control dataInput" placeholder="سنوات الخبرة" id="TheExNumber" name="TheExNumber">
                          </div>
                          <bold class="text-danger" id="errors-TheExNumber" style="display: none;"></bold>
                        </div>
                    </div>

                      <div class="row row-xs">
                        <div class="col-lg-3 col-md-6 col-12">
                          <label for="ThePhone1">الموبايل</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                              <input type="text" class="form-control dataInput" placeholder="الموبايل" id="ThePhone1" name="ThePhone1">
                          </div>
                          <bold class="text-danger" id="errors-ThePhone1" style="display: none;"></bold>
                        </div>    
                        
                        <div class="col-lg-3 col-md-6 col-12">
                          <label for="ThePhone2">الواتساب</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                              <input type="text" class="form-control dataInput" placeholder="الواتساب" id="ThePhone2" name="ThePhone2">
                          </div>
                          <bold class="text-danger" id="errors-ThePhone2" style="display: none;"></bold>
                        </div>    
                        
                        <div class="col-lg-3 col-md-6 col-12">
                          <label for="TheStatusDate">تاريخ الحالة</label>
                          {{--<i class="fas fa-star require_input"></i>--}}
                          <div>
                              <input type="text" class="form-control datePicker dataInput" placeholder="تاريخ الحالة" id="TheStatusDate" name="TheStatusDate">
                          </div>
                          <bold class="text-danger" id="errors-TheStatusDate" style="display: none;"></bold>
                        </div>                          
                        
                        <div class="col-lg-3 col-md-6 col-12">
                          <label for="TheStatus">حالة التسجيل</label>
                          <i class="fas fa-star require_input"></i>
                          <div>    
                              <select name="TheStatus" class="form-control TheStatus" id="TheStatus">
                                  <option value="جديد">جديد</option>
                                  <option value="مفعل">مفعل</option>
                                  <option value="غير مفعل">غير مفعل</option>
                              </select>
                          </div>
                          <bold class="text-danger" id="errors-TheStatus" style="display: none;"></bold>
                        </div> 
                        
                        <div class="col-12">
                          <label class="text-bold" style="margin: 10px;">هل تتوفر المتطلبات التالية</label>
                          <div class="row" style="border: 1px solid red;border-radius: 5px;margin: 0;padding: 10px 0;">
                            <div class="col-lg-4 col-12">
                              <label for="HaveLap">حاسب الي</label>
                              <i class="fas fa-star require_input"></i>
                              <div>    
                                  <select name="HaveLap" class="form-control HaveLap" id="HaveLap">
                                      <option value="نعم">نعم</option>
                                      <option value="لا">لا</option>
                                  </select>
                              </div>
                              <bold class="text-danger" id="errors-HaveLap" style="display: none;"></bold>
                            </div> 
                            
                            <div class="col-lg-4 col-12">
                              <label for="HaveHead">سماعات رأس</label>
                              <i class="fas fa-star require_input"></i>
                              <div>    
                                  <select name="HaveHead" class="form-control HaveHead" id="HaveHead">
                                      <option value="نعم">نعم</option>
                                      <option value="لا">لا</option>
                                  </select>
                              </div>
                              <bold class="text-danger" id="errors-HaveHead" style="display: none;"></bold>
                            </div> 
                            
                            <div class="col-lg-4 col-12">
                              <label for="HaveNet">انترنت سريع</label>
                              <i class="fas fa-star require_input"></i>
                              <div>    
                                  <select name="HaveNet" class="form-control HaveNet" id="HaveNet">
                                      <option value="نعم">نعم</option>
                                      <option value="لا">لا</option>
                                  </select>
                              </div>
                              <bold class="text-danger" id="errors-HaveNet" style="display: none;"></bold>
                            </div>  
                          </div>
                        </div>

                        <div class="col-lg-6 col-12">
                          <label for="TheMethod">المنهج</label>
                          <div>
                            <textarea class="form-control dataInput" placeholder="المنهج" id="TheMethod" name="TheMethod" rows="4"></textarea>
                          </div>
                          <bold class="text-danger" id="errors-TheMethod" style="display: none;"></bold>
                        </div>
                        
                        <div class="col-lg-6 col-12">
                          <label for="TheExExplain">شرح الخبرة السابقة في التدريس الأونلاين</label>
                          <div>
                            <textarea class="form-control dataInput" placeholder="شرح الخبرة السابقة في التدريس الأونلاين" id="TheExExplain" name="TheExExplain" rows="4"></textarea>
                          </div>
                          <bold class="text-danger" id="errors-TheExExplain" style="display: none;"></bold>
                        </div>
                       
                      </div>                   
                    </div>
                  </div>
              </div>
      

              <div class="modal-footer">                                               
                  <button type="button" id="save" class="btn btn-primary btn-rounded" style="display: none;">حفظ
                    <span class="spinner-border spinner-border-sm spinner_request" role="status" aria-hidden="true"></span>
                  </button>

                  <button type="button" id="update" class="btn btn-success btn-rounded" style="display: none;">تعديل
                    <span class="spinner-border spinner-border-sm spinner_request2" role="status" aria-hidden="true"></span>
                  </button>
                  
                  <button id="closeModal" type="button" class="btn btn-outline-secondary btn-rounded" data-dismiss="modal">اغلاق</button>
              </div> 

          </form>            
      </div>
    </div>
  </div>
</div>
