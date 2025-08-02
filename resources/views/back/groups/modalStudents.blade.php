<div class="modal fade" id="modalStudents" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">طلاب المجموعة 📚</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body" style="display: none;">
            <form class="" id="formModalStudents">
                @csrf
                <input type="hidden" id="res_id" value="" />               

                <div class="pd-30 pd-sm-40 bg-gray-100">
                    <div class="row">  

                    {{-- start right --}}
                      <div class="col-lg-5">

                        <div class="form-group row">
                          <label for="group_id" class="col-md-3 col-12 col-form-label">المجموعة</label>

                          <div class="col-md-2 col-12">
                            <input type="text" disabled readonly class="dataInput form-control group_id" placeholder="المجموعة">
                            <input type="hidden" name="GroupID" class="dataInput form-control group_id" />

                            <bold class="text-danger" id="errors-group_id" style="display: none;"></bold>
                          </div>
                          
                          <div class="col-md-7 col-12">
                            <input type="text" disabled readonly id="group_name" name="group_name" class="dataInput form-control" placeholder="G412po98-09k">
                            <bold class="text-danger" id="errors-group_name" style="display: none;"></bold>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="year_id" class="col-md-3 col-12 col-form-label">الصف والمادة</label>

                          <div class="col-md-2 col-12">
                            <input type="text" disabled readonly id="year_id" name="year_id" class="dataInput form-control" placeholder="الصف والمادة">
                            <bold class="text-danger" id="errors-year_id" style="display: none;"></bold>
                          </div>
                          
                          <div class="col-md-7 col-12">
                            <input type="text" disabled readonly id="year_name" name="year_name" class="dataInput form-control" placeholder="G412po98-09k">
                            <bold class="text-danger" id="errors-year_name" style="display: none;"></bold>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="ClassType" class="col-md-3 col-12 col-form-label">نظام التعليم</label>

                          <div class="col-md-9 col-12">
                            <input type="text" disabled readonly id="ClassType" name="ClassType" class="dataInput form-control" placeholder="نظام التعليم">
                            <bold class="text-danger" id="errors-ClassType" style="display: none;"></bold>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="test_type" class="col-md-3 col-12 col-form-label">نظام الإختبارات</label>

                          <div class="col-md-9 col-12">
                            <input type="text" disabled readonly id="test_type" name="test_type" class="dataInput form-control" placeholder="نظام الإختبارات">
                            <bold class="text-danger" id="errors-test_type" style="display: none;"></bold>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="GroupTeacherPayType" class="col-md-3 col-12 col-form-label">نوع الإحتساب</label>

                          <div class="col-md-9 col-12">
                            <input type="text" disabled readonly id="GroupTeacherPayType" name="GroupTeacherPayType" class="dataInput form-control" placeholder="نوع الإحتساب">
                            <bold class="text-danger" id="errors-GroupTeacherPayType" style="display: none;"></bold>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-lg-6 col-12">
                            <label> العدد المسجل:  <strong id="selected_count" style="font-size: 18px;color: red;margin: 0 5px;">0</strong> </label>
                          </div>
  
                          <div class="col-lg-6 col-12">
                            <label> العدد الغير مسجل:  <strong id="not_selected_count" style="font-size: 18px;color: red;margin: 0 5px;">0</strong> </label>
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-lg-4 col-12">
                            <div class="form-group">
                              <label for="student_discount_top">خصم الطالب</label>
    
                              <div>
                                <input type="number" id="student_discount_top" name="student_discount_top" class="dataInput text-center form-control" placeholder="خصم الطالب" value="0">
                                <bold class="text-danger" id="errors-student_discount_top" style="display: none;"></bold>
                              </div>
                            </div>
                          </div>
                         
                          <div class="col-lg-4 col-12" id="TeacherValuePercentageSection">
                            <div class="form-group">
                              <label for="TeacherValuePercentage">نسبة المدرس</label>
    
                              <div>
                                <input type="number" id="TeacherValuePercentage" name="TeacherValuePercentage" class="dataInput text-center form-control" placeholder="نسبة المدرس" value="0">
                                <bold class="text-danger" id="errors-TeacherValuePercentage" style="display: none;"></bold>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-lg-4 col-12" id="TeacherValueStaticSection">
                            <div class="form-group">
                              <label for="TeacherValueStatic">قيمة ثابتة المدرس</label>
    
                              <div>
                                <input type="number" readonly id="TeacherValueStatic" name="TeacherValueStatic" class="dataInput text-center form-control" placeholder="قيمة ثابتة المدرس" value="0">
                                <bold class="text-danger" id="errors-TeacherValueStatic" style="display: none;"></bold>
                              </div>
                            </div>
                          </div>
                         
                          <div class="col-lg-4 col-12">
                            <div class="form-group">
                              <label for="TeacherTax">ضريبة المدرس</label>
    
                              <div>
                                <input type="number" id="TeacherTax" name="TeacherTax" class="dataInput text-center form-control" placeholder="ضريبة المدرس" value="0">
                                <bold class="text-danger" id="errors-TeacherTax" style="display: none;"></bold>
                              </div>
                            </div>
                          </div>
                          
                          
                        </div>


                      </div>
                        
                    {{-- end right --}}


                    {{-- start left --}}
                      <div class="col-lg-7 card" id="left" style="padding-top: 15px;">
                        <table class="table table-striped table-hover table-bordered" id="modalStudentsTable">
                          <thead class="thead-dark">
                            <tr>
                              <th class="text-center">
                                <input type="checkbox" class="check_all" />
                              </th>
                              <th class="text-center">حذف</th>
                              <th class="nowap_thead" style="width: 300px !important;min-width: 300px !important;">اسم الطالب
                                <span class="bg bg-primary" style="margin: 10px;padding: 0px 5px;" id="count_students">0</span>
                                <button class='btn btn-sm btn-danger remove_all_student_tbl_groups_students' type="button">حذف كل الطلاب المسجلين</button>
                              </th>
                              <th class="nowap_thead" style="width: 130px !important;min-width: 130px !important;">نسبه خصم الطالب</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
                    {{-- end left --}}


                      <div class="col-lg-7 text-center text-danger" id="no_students" style="display: none;margin-top: 40px;"></div>

                    </div>
                </div>

                <div class="modal-footer bg bg-dark">                                               
                    <button type="button" id="saveModalStudents" class="btn btn-success btn-rounded">
                      حفظ طلاب المجموعة
                      <span class="spinner-border spinner-border-sm spinner_request" role="status" aria-hidden="true"></span>
                    </button>

                    <button id="closeModal" type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">اغلاق</button>
                </div> 

            </form>            
        </div>
      </div>
    </div>
</div>
