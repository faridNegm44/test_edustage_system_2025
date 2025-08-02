<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body" id="add_rate" >
            <form class="" id="form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="res_id" value="" />               

                <div class="pd-10 bg-gray-100">



                  {{--  ---------------------- start top -----------------------  --}}

                  <div id="top_section">
                    <div class="row row-xs">                 
                      <div class="col-md-10">
                        <label for="Eval_GroupID">المجموعات الدراسية</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                            <select id="Eval_GroupID" name="Eval_GroupID" class="form-control dataInput">
                                <option selected value="">اختر مجموعة دراسية</option>
                                @foreach ($groups as $group)
                                  <option value="{{ $group->ID }}">
                                      {{ $group->GroupName }} - 
                                      {{ $group->matFullName }} - 
                                      {{ $group->ClassType }} 
                                  </option>
                                @endforeach
                            </select>
                        </div>
                        <bold class="text-danger" id="errors-Eval_GroupID" style="display: none;"></bold>
                      </div>    
                      
                      <div class="col-md-2">
                        <label for="Eval_Month">شهر</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                            <select id="Eval_Month" name="Eval_Month" class="form-control dataInput">
                              <option value="">اختر شهر</option>
                              <option value="1" {{ $beforeMonth == 1 ? 'selected' : '' }}> ( 1 ) يناير</option>
                              <option value="2" {{ $beforeMonth == 2 ? 'selected' : '' }}> ( 2 ) فبراير</option>
                              <option value="3" {{ $beforeMonth == 3 ? 'selected' : '' }}> ( 3 ) مارس</option>
                              <option value="4" {{ $beforeMonth == 4 ? 'selected' : '' }}> ( 4 ) أبريل</option>
                              <option value="5" {{ $beforeMonth == 5 ? 'selected' : '' }}> ( 5 ) مايو</option>
                              <option value="6" {{ $beforeMonth == 6 ? 'selected' : '' }}> ( 6 ) يونيو</option>
                              <option value="7" {{ $beforeMonth == 7 ? 'selected' : '' }}> ( 7 ) يوليو</option>
                              <option value="8" {{ $beforeMonth == 8 ? 'selected' : '' }}> ( 8 ) أغسطس</option>                               
                              <option value="9" {{ $beforeMonth == 9 ? 'selected' : '' }}> ( 9 ) سبتمبر</option>
                              <option value="10" {{ $beforeMonth == 10 ? 'selected' : '' }}> ( 10 ) أكتوبر</وoption>   
                              <option value="11" {{ $beforeMonth == 11 ? 'selected' : '' }}> ( 11 ) نوفمبر</option>
                              <option value="12" {{ $beforeMonth == 12 ? 'selected' : '' }}> ( 12 ) ديسمبر</option>
                            </select>
                        </div>
                        <bold class="text-danger" id="errors-Eval_Month" style="display: none;"></bold>
                      </div>    
                    </div>
                    
                    <div class="row row-xs">                 
                      <div class="col-md-3">
                        <label for="Eval_Att_top">الحضور(10)</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                          <input type="number" class="form-control dataInput dataInput_top" placeholder="الحضور(10)" id="Eval_Att_top">
                        </div>
                        <bold class="text-danger" id="errors-Eval_Att_top" style="display: none;"></bold>
                      </div>    
                      
                      <div class="col-md-3">
                        <label for="Eval_Part_top">التفاعل/السلوك(10)</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                          <input type="number" class="form-control dataInput dataInput_top" placeholder="التفاعل/السلوك(10)" id="Eval_Part_top">
                        </div>
                        <bold class="text-danger" id="errors-Eval_Part_top" style="display: none;"></bold>
                      </div>    
                      
                      <div class="col-md-3">
                        <label for="Eval_Eval_top">الواجبات(40)</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                          <input type="number" class="form-control dataInput dataInput_top" placeholder="الواجبات(40)" id="Eval_Eval_top">
                        </div>
                        <bold class="text-danger" id="errors-Eval_Eval_top" style="display: none;"></bold>
                      </div>    
                      
                      <div class="col-md-3">
                        <label for="Eval_HW_top">الإختبار الشهري(40)</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                          <input type="number" class="form-control dataInput dataInput_top" placeholder="الإختبار الشهري(40)" id="Eval_HW_top">
                        </div>
                        <bold class="text-danger" id="errors-Eval_HW_top" style="display: none;"></bold>
                      </div>         
                    </div>
                    
                    <div class="row row-xs">                 
                      <div class="col-md-6">
                        <label for="time">تعليق المدرس</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                          <input type="text" class="form-control dataInput dataInput_top" placeholder="تعليق المدرس" id="Eval_TeacherComment_top">
                        </div>
                        <bold class="text-danger" id="errors-time" style="display: none;"></bold>
                      </div>    
                      
                      <div class="col-md-6">
                        <label for="time">ملاحظات المدرس</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                          <input type="text" class="form-control dataInput dataInput_top" placeholder="ملاحظات المدرس" id="Eval_TeacherSugg_top">
                        </div>
                        <bold class="text-danger" id="errors-time" style="display: none;"></bold>
                      </div>                       
                    </div>
                  </div>

                  {{--  ---------------------- end top -----------------------  --}}
                  


                  
                  {{--  ---------------- start table --------------------  --}}
                  <div class="row row-xs table-responsive" id="estimate_table" style="display: blobk;">

                    <table class="table table-bordered table-hover" style="background: #fff;">
                      <thead class="thead-dark">
                        <tr>
                          <th>#</th>   
                          <th style="width: 20%;">الطلاب</th>   
                          <th style="width: 7.5%;">الحضور</th>
                          <th style="width: 7.5%;">المشاركة</th>
                          <th style="width: 7.5%;">الواجبات</th>
                          <th style="width: 7.5%;">الإختبارات</th>
                          <th style="width: 7.5%;">المجموع</th>
                          <th style="width: 20%;">تعليق المدرس</th>
                          <th style="width: 20%;">ملاحظات المدرس</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                      </tbody>
                    </table>                  
                    
                    
                    
                    <div class="modal-footer bg-dark">                                               
                        <button type="button" id="save" class="btn btn-primary btn-rounded" style="display: none;">
                          حفظ
                          <span class="spinner-border spinner-border-sm spinner_request" role="status" aria-hidden="true"></span>
                        </button>
      
                        <button type="button" id="update" class="btn btn-success btn-rounded" style="display: none;">
                          تعديل
                          <span class="spinner-border spinner-border-sm spinner_request2" role="status" aria-hidden="true"></span>
                        </button>
                        
                        <button id="closeModal" type="button" class="btn btn-secondary btn-rounded" data-dismiss="modal">اغلاق</button>
                    </div> 
                  </div>

                </div>
              </form>            
        </div>
      </div>
    </div>
</div>
