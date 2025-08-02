<div class="modal fade" id="takeAttendance" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">تفقد الحضور للحصة</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        {{-- style="display: none;" --}}
        <div class="modal-body">
            <form class="" id="formTakeAttendance">
                @csrf
                <input type="hidden" id="res_id" value="" />               

                <div class="pd-30 pd-sm-40 bg-gray-100">
                    <div class="row">  
                    
                      <div class="col-lg-5">

                        <div class="form-group row">
                          <label for="group_id" class="col-md-3 col-12 col-form-label">المجموعة</label>

                          <div class="col-md-3 col-12">
                            <input type="text" disabled readonly class="dataInput form-control group_id" placeholder="المجموعة">
                            <input type="hidden" name="GroupID" class="dataInput form-control group_id" />

                            <bold class="text-danger" id="errors-group_id" style="display: none;"></bold>
                          </div>
                          
                          <div class="col-md-6 col-12">
                            <input type="text" disabled readonly id="group_name" name="group_name" class="dataInput form-control" placeholder="G412po98-09k">
                            <bold class="text-danger" id="errors-group_name" style="display: none;"></bold>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="year_id" class="col-md-3 col-12 col-form-label">الصف والمادة</label>

                          <div class="col-md-3 col-12">
                            <input type="text" disabled readonly id="year_id" name="year_id" class="dataInput form-control" placeholder="الصف والمادة">
                            <bold class="text-danger" id="errors-year_id" style="display: none;"></bold>
                          </div>
                          
                          <div class="col-md-6 col-12">
                            <input type="text" disabled readonly id="year_name" name="year_name" class="dataInput form-control" placeholder="G412po98-09k">
                            <bold class="text-danger" id="errors-year_name" style="display: none;"></bold>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="ClassType" class="col-md-3 col-12 col-form-label">تاريخ الحصة</label>

                          <div class="col-md-9 col-12">
                            <input type="text" disabled readonly id="ClassType" name="ClassType" class="dataInput form-control" placeholder="تاريخ الحصة">
                            <bold class="text-danger" id="errors-ClassType" style="display: none;"></bold>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label for="GroupTeacherPayType" class="col-md-3 col-12 col-form-label">طريقة الإحتساب</label>

                          <div class="col-md-9 col-12">
                            <input type="text" disabled readonly id="GroupTeacherPayType" name="GroupTeacherPayType" class="dataInput form-control" placeholder="طريقة الإحتساب">
                            <bold class="text-danger" id="errors-GroupTeacherPayType" style="display: none;"></bold>
                          </div>
                        </div>
                        
                        <hr>
                        <div class="row">
                          <div class="col-lg-6 col-12">
                            <label> عدد الحضور:  <strong id="selected_count" style="font-size: 18px;color: red;margin: 0 5px;">10</strong> </label>
                          </div>
  
                          <div class="col-lg-6 col-12">
                            <label> عدد غياب:  <strong id="not_selected_count" style="font-size: 18px;color: red;margin: 0 5px;">0</strong> </label>
                          </div>
                        </div>
                      </div>
                        

                      
                      <div class="col-lg-7 card" id="left" style="padding-top: 15px;">
                    
                        <table class="table table-striped table-hover table-bordered" id="takeAttendanceTable">
                          <thead class="thead-dark">
                            <tr>
                              <th class="text-center">
                                <input type="checkbox" class="check_all" />
                              </th>
                              <th style="width: 40%;">
                                اسم الطالب
                                <span class="bg bg-danger-gradient" style="margin: 0 10px;padding: 0px 5px;" id="count_students">0</span>
                              </th>
                              <th>
                                حالة الطالب
                                <select class="form-control" style="display: inline;width: 60%;margin: 0 10px;">
                                  <option value="" selected disabled>اختر حالة لكل الطلاب</option>
                                  <option value="غائب">غائب</option>
                                  <option value="غائب/مدفوع">غائب/مدفوع</option>
                                  <option value="حاضر">حاضر</option>
                                </select>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            @for ($i = 1; $i <= 10; $i++)
                              <tr>
                                  <td><input type="checkbox" name="students[{{ $i }}][selected]" class="check_item"></td>
                                  <td>الطالب رقم {{ $i }}</td>
                                  <td>
                                      <select name="students[{{ $i }}][status]" class="form-control text-center">
                                          <option value="غائب">غائب</option>
                                          <option value="غائب/مدفوع">غائب/مدفوع</option>
                                          <option value="حاضر">حاضر</option>
                                      </select>
                                  </td>
                              </tr>
                            @endfor
                          </tbody>
                        </table>

                      </div>

                      <div class="col-lg-7 text-center text-danger" id="no_students" style="display: none;margin-top: 40px;"></div>

                    </div>
                </div>

                <div class="modal-footer bg bg-dark">                                               
                    <button type="button" id="saveTakeAttendance" class="btn btn-success btn-rounded">
                      حفظ تفقد الحصة
                      <span class="spinner-border spinner-border-sm spinner_request" role="status" aria-hidden="true"></span>
                    </button>

                    <button id="closeModal" type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">اغلاق</button>
                </div> 

            </form>            
        </div>
      </div>
    </div>
</div>
