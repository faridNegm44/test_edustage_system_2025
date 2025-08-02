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
              <input type="hidden" id="student_id" value="" />               

              <div class="pd-30 pd-sm-40 bg-gray-100">
                  <div class="row row-xs">   
                    {{------------------------ start right ----------------------}}
                    <div class="col-md-4 card bg-secondary-transparent" style="padding: 0 20px 12px;"> 
                      <div class="row">
                        <div class="col-12">
                          <label for="ParentID">ولي الأمر</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                            <select id="ParentID" name="ParentID" placeholder="اختر ولي أمر" class="selectize">
                                <option selected disabled></option>
                                @foreach ($parents as $parent)
                                    <option value="{{ $parent->ID }}" data-email="{{ $parent->TheEmail }}" data-whats="{{ $parent->ThePhone2 }}" data-nat="{{ $parent->NatID }}" data-city="{{ $parent->CityID }}">
                                      {{ $parent->TheName0 }}
                                    </option>
                                @endforeach
                            </select>
                          </div>
                          <bold class="text-danger" id="errors-ParentID" style="display: none;"></bold>
                        </div>

                        <div class="col-12">
                          <label for="copy_parent_info">نسخ بيانات ولي الأمر</label>
                          <div>
                            <button class="btn btn-danger" id="copy_parent_info" style="height: 35px;padding: 0 15px !important;width: 100%;">نسخ بيانات ولي الأمر</button>
                          </div>
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
                          <label for="ThePass">كلمة المرور</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                              <input type="password" class="form-control dataInput" placeholder="كلمة المرور" id="ThePass" name="ThePass">
                          </div>
                          <bold class="text-danger" id="errors-ThePass" style="display: none;"></bold>
                        </div>  
                      </div>
                    </div>
                    {{------------------------ end right ----------------------}}



                    {{------------------------ start left ----------------------}}
                    <div class="col-md-8 card bg-info-transparent" style="padding: 0 20px 12px;">
                      <div class="row">                        
                        <div class="col-md-4 col-12">
                          <label for="TheName">اسم الطالب</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                              <input type="text" class="form-control dataInput" placeholder="اسم الطالب" id="TheName" name="TheName">
                          </div>
                          <bold class="text-danger" id="errors-TheName" style="display: none;"></bold>
                        </div>    
                        
                        <div class="col-lg-4 col-md-6 col-12">
                          <label for="ThePhone">الواتساب</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                              <input type="text" class="form-control dataInput" placeholder="الواتساب" id="ThePhone" name="ThePhone">
                          </div>
                          <bold class="text-danger" id="errors-ThePhone" style="display: none;"></bold>
                        </div>    
                      
                        <div class="col-lg-4 col-md-6 col-12">
                          <label for="TheStatusDate">تاريخ الحالة</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                              <input type="text" class="form-control datePicker" placeholder="تاريخ الحالة" id="TheStatusDate" name="TheStatusDate">
                          </div>
                          <bold class="text-danger" id="errors-TheStatusDate" style="display: none;"></bold>
                        </div>    
  
                        <div class="col-lg-4 col-md-6 col-12">
                          <label for="TheStatus">حالة التسجيل</label>
                          <div>    
                              <select name="TheStatus" class="form-control TheStatus" id="TheStatus">
                                  <option value="جديد">جديد</option>
                                  <option value="مفعل">مفعل</option>
                                  <option value="غير مفعل">غير مفعل</option>
                              </select>
                          </div>
                          <bold class="text-danger" id="errors-TheStatus" style="display: none;"></bold>
                        </div> 
                        
                        <div class="col-lg-4 col-md-6 col-12">
                          <label for="TheEduType">نظام التعليم</label>
                          <div>
                            <select id="TheEduType" name="TheEduType" class="form-control">
                                @foreach ($types_of_education as $type_of_education)
                                    <option value="{{ $type_of_education->LangName }}">{{ $type_of_education->LangName }}</option>
                                @endforeach
                            </select>
                          </div>
                          <bold class="text-danger" id="errors-TheEduType" style="display: none;"></bold>
                        </div>    
                      
                        <div class="col-lg-4 col-md-6 col-12">
                          <label for="TheTestType">نظام الاختبارات</label>
                          <div>
                            <select id="TheTestType" name="TheTestType" class="form-control">
                                <option value="نظام التيرم في مصر">نظام التيرم في مصر</option>
                                <option value="نظام التيرم مسار مصري">نظام التيرم مسار مصري</option>
                                <option value="نظام اختبار السفارة تيرمين">نظام اختبار السفارة تيرمين</option>
                                <option value="نظام اختبار خليجي">نظام اختبار خليجي</option>
                                <option value="International Exam">International Exam</option>
                                <option value="غير ذلك">غير ذلك</option>
                            </select>
                          </div>
                          <bold class="text-danger" id="errors-TheTestType" style="display: none;"></bold>
                        </div>    
                        
                        <div class="col-md-6 col-12">
                          <label for="NatID">الجنسية</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                            <select id="NatID" name="NatID" class="selectize">
                                @foreach ($nats as $nat)
                                    <option value="{{ $nat->ID }}">{{ $nat->TheName }}</option>
                                @endforeach
                            </select>
                          </div>
                          <bold class="text-danger" id="errors-NatID" style="display: none;"></bold>
                        </div>    
                      
                        <div class="col-md-6 col-12">
                          <label for="CityID">مكان الإقامة</label>
                          <i class="fas fa-star require_input"></i>
                          <div>
                            <select id="CityID" name="CityID" class="selectize">
                                @foreach ($cities as $citie)
                                    <option value="{{ $citie->ID }}">{{ $citie->TheCity }}</option>
                                @endforeach
                            </select>
                          </div>
                          <bold class="text-danger" id="errors-CityID" style="display: none;"></bold>
                        </div>    
                        
                        <div class="col-md-6 col-12">
                          <label for="TheNotes">ملاحظات</label>
                          <div>
                            <textarea class="form-control dataInput" placeholder="ملاحظات" id="TheNotes" name="TheNotes" rows="2"></textarea>
                          </div>
                          <bold class="text-danger" id="errors-TheNotes" style="display: none;"></bold>
                        </div>    
                        
                        <div class="col-md-6 col-12">
                          <label for="TheExplain">السجل الدراسي</label>
                          <div>
                            <textarea class="form-control dataInput" placeholder="السجل الدراسي" id="TheExplain" name="TheExplain" rows="2"></textarea>
                          </div>
                          <bold class="text-danger" id="errors-TheExplain" style="display: none;"></bold>
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
