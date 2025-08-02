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

                <div class="pd-30 pd-sm-40 bg-gray-100">
                    <div class="row row-xs">  
                      
                      {{-- start right --}}
                        <div class="col-lg-7">
                          
                          <div class="row">
                            <div class="col-lg-6">
                              <label for="OpenDate">تاريخ الإفتتاح</label>
                              
                              <div>
                                <input type="text" id="OpenDate" name="OpenDate" class="dataInput datePicker form-control" placeholder="تاريخ الإفتتاح" />
                              </div>
                              <bold class="text-danger" id="errors-OpenDate" style="display: none;"></bold>
                            </div>
    
                            <div class="col-lg-6">
                              <label for="CloseDate">تاريخ الإغلاق</label>
                              <div>
                                <input type="text" id="CloseDate" name="CloseDate" class="dataInput datePicker form-control" placeholder="تاريخ الإغلاق">
                              </div>
                              <bold class="text-danger" id="errors-CloseDate" style="display: none;"></bold>
                            </div>   
                          </div>       
                          
                          <div>
                            <label for="GroupName">
                              إسم المجموعة
                            </label>
                            <i class="fas fa-star require_input"></i>
                            <div>
                              <input type="text" id="GroupName" name="GroupName" class="dataInput form-control" placeholder="إسم المجموعة">
                            </div>
                            <bold class="text-danger" id="errors-GroupName" style="display: none;"></bold>
                          </div>    

                          <div class="row">
                            <div class="col-lg-6">
                              <label for="YearID">المواد الدراسية</label>
                              <i class="fas fa-star require_input"></i>
                              <div>
                                <select id="YearID" name="YearID" class="selectize dataInput">
                                    <option value="" selected disabled>الصفوف والمواد الدراسية</option>
                                    @foreach ($subjects as $subjects)
                                      <option value="{{ $subjects->ID }}">{{ $subjects->ID }} - {{ $subjects->TheFullName }}</option>
                                    @endforeach
                                </select>
                              </div>
                              <bold class="text-danger" id="errors-YearID" style="display: none;"></bold>
                            </div>                                                  

                            <div class="col-lg-6">
                              <label for="TeacherID">المدرس</label>                            
                              <i class="fas fa-star require_input"></i>
                              <div>
                                <select id="TeacherID" name="TeacherID" class="selectize dataInput">
                                    <option value="" selected disabled>اختر مدرس</option>                                
                                </select>
                              </div>
                              <bold class="text-danger" id="errors-TeacherID" style="display: none;"></bold>
                            </div>    
                          </div>                        

                          <div class="row">
                            <div class="col-lg-4">
                              <label for="ClassType">الباقة</label>    
                              <i class="fas fa-star require_input"></i>                      
                              <div>
                                <select id="ClassType" name="ClassType" class="form-control dataInput">
                                    <option value="" selected disabled>اختر باقة</option>
                                    <option value="باقة توفير">باقة توفير</option>
                                    <option value="باقة محدودة العدد">باقة محدودة العدد</option>
                                    <option value="باقة برايفت طالب واحد">باقة برايفت طالب واحد</option>
                                    <option value="باقة برايفت طالبين">باقة برايفت طالبين</option>
                                </select>
                              </div>
                              <bold class="text-danger" id="errors-ClassType" style="display: none;"></bold>
                            </div>   

                            <div class="col-lg-4">
                              <label for="TheLangID">نظام التعليم</label>   
                              <i class="fas fa-star require_input"></i>                         
                              <div>
                                <select id="TheLangID" name="TheLangID" class="form-control dataInput">
                                  <option value="" selected disabled>أنظمة التعليم</option>
                                  @foreach ($types_of_education as $type)
                                      <option value="{{ $type->LangID }}">{{ $type->LangName }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <bold class="text-danger" id="errors-TheLangID" style="display: none;"></bold>
                            </div>    

                            <div class="col-lg-4">
                              <label for="TheTestType">نظام الإختبارات</label>  
                              <i class="fas fa-star require_input"></i>                          
                              <div>
                                <select id="TheTestType" name="TheTestType" class="form-control dataInput">
                                  <option value="" selected disabled>أنظمة الإختبارات</option>
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
                          </div>

                          <hr />
                          <div>
                            <label for="TheNotes">ملاحظات</label>
                            
                            <div>
                              <textarea id="TheNotes" name="TheNotes" class="dataInput form-control" rows="2" placeholder="ملاحظات"></textarea>
                            </div>
                            <bold class="text-danger" id="errors-TheNotes" style="display: none;"></bold>
                          </div>
                        </div>
                      {{-- end right --}}


                      {{-- start left --}}
                        <div class="col-lg-5">                        
                          <div class="row">
                            <div class="col-md-6">
                              <label for="ClassNo1">عدد حصص متوقع</label>
                              <i class="fas fa-star require_input"></i>
                              <div>
                                <input type="text" id="ClassNo1" name="ClassNo1" class="dataInput form-control" placeholder="عدد حصص متوقع">
                              </div>
                              <bold class="text-danger" id="errors-ClassNo1" style="display: none;"></bold>
                            </div>    
    
                            <div class="col-md-6">
                              <label for="ThePrice">السعر</label>
                              <i class="fas fa-star require_input"></i>
                              <div>
                                <input type="text" id="ThePrice" name="ThePrice" class="dataInput form-control" placeholder="السعر">
                              </div>
                              <bold class="text-danger" id="errors-ThePrice" style="display: none;"></bold>
                            </div>    
                          </div>


                          <label class="text-bold" style="margin: 10px;">نظام الإحتساب</label>
                          <br>
                          <small class="alert alert-danger">من فضلك اختر طريقه حساب مناسبة اما قيمه ثابتة او نسبة</small>
                          <div class="row" style="border: 1px solid red;border-radius: 5px;margin: 0;padding: 10px 0;">
                            <div class="col-md-6">
                              <label for="GroupTeacherPayType">النظام</label>
                              
                              <div>
                                <select id="GroupTeacherPayType" name="GroupTeacherPayType" class="dataInput form-control">
                                  <option value="" selected disabled>اختر نظام</option>
                                  <option value="نسبة" >نسبة</option>
                                  <option value="قيمة ثابتة" >قيمة ثابتة</option>                                
                                </select>
                              </div>
                              <bold class="text-danger" id="errors-GroupTeacherPayType" style="display: none;"></bold>
                            </div>
                            
                            <div class="col-md-6" id="GroupStaticValueSection">
                              <label for="GroupStaticValue">القيمة الثابتة</label>
                              
                              <div>
                                <input type="number" id="GroupStaticValue" name="GroupStaticValue" class="dataInput form-control" placeholder="القيمة الثابتة" value="0">
                              </div>
                              <bold class="text-danger" id="errors-GroupStaticValue" style="display: none;"></bold>
                            </div>
                            

                            <div class="col-md-6" id="GroupExtraValueSection">
                              <label for="GroupExtraValue">قيمة الإضافي</label>
                              
                              <div>
                                <input type="number" id="GroupExtraValue" name="GroupExtraValue" class="dataInput form-control" placeholder="قيمة الإضافي" value="0">
                              </div>
                              <bold class="text-danger" id="errors-GroupExtraValue" style="display: none;"></bold>
                            </div>

                            <div class="col-md-6" id="GroupMiniStudentsSection">
                              <label for="GroupMiniStudents">الحد الأدني للقيمة الثابتة</label>                            
                              <div>
                                <input type="number" id="GroupMiniStudents" name="GroupMiniStudents" class="dataInput form-control" placeholder="الحد الأدني للقيمة الثابتة">
                              </div>
                              <bold class="text-danger" id="errors-GroupMiniStudents" style="display: none;"></bold>
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
