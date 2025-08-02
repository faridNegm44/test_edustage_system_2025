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
                        {{------------------------ start right ----------------------}}
                        <div class="col-md-4 card bg-secondary-transparent" style="padding: 0 20px 12px;"> 
                            <div class="row">
                                <div class="col-12">
                                    <label for="name">اسم المستخدم</label>
                                    <i class="fas fa-star require_input"></i>
                                    <div>
                                        <input type="text" class="form-control dataInput" placeholder="اسم المستخدم" id="name" name="name">
                                    </div>
                                    <bold class="text-danger" id="errors-name" style="display: none;"></bold>
                                </div>
        
                                <div class="col-12">
                                    <label for="email">البريد الإلكتروني</label>
                                    <i class="fas fa-star require_input"></i>
                                    <div>
                                        <input type="email" class="form-control dataInput" placeholder="البريد الإلكتروني" id="email" name="email">
                                    </div>
                                    <bold class="text-danger" id="errors-email" style="display: none;"></bold>
                                </div>
        
                                <div class="col-12">
                                    <label for="password">كلمة المرور</label>
                                    <i class="fas fa-star require_input"></i>
                                    <div style="position: relative;">
                                        <input type="password" class="form-control dataInput" placeholder="كلمة المرور" id="password" name="password">
                                        <i class="fa fa-eye show_pass" style="position: absolute;top: 14px;left: 10px;font-size: 16px;cursor: pointer;"></i>
                                    </div>
                                    <bold class="text-danger" id="errors-password" style="display: none;"></bold>
                                </div>
                                
                                <div class="col-12">
                                    <label for="confirmed_password">تاكيد كلمة المرور</label>
                                    <i class="fas fa-star require_input"></i>
                                    <div style="position: relative;">
                                        <input type="password" class="form-control dataInput" placeholder="تاكيد كلمة المرور" id="confirmed_password" name="confirmed_password">
                                        <i class="fa fa-eye show_pass" style="position: absolute;top: 14px;left: 10px;font-size: 16px;cursor: pointer;"></i>
                                    </div>
                                    <bold class="text-danger" id="errors-confirmed_password" style="display: none;"></bold>
                                </div>
                            </div>
                        </div>
                        {{------------------------ end right ----------------------}}


                        {{------------------------ start left ----------------------}}
                        <div class="col-md-8 card bg-info-transparent" style="padding: 0 20px 12px;">
                            <div class="row">                     
                                <div class="col-md-3 col-xs-12">
                                    <label for="gender">النوع</label>
                                    <div>
                                        <select id="gender" name="gender"  class="form-control">
                                            <option value="1">ذكر</option>
                                            <option value="0">انثي</option>
                                        </select>
                                    </div>
                                    <bold class="text-danger" id="errors-gender" style="display: none;"></bold>
                                </div>
        
                                <div class="col-md-3 col-xs-12">
                                    <label for="phone">رقم التليفون</label>
                                    <div>
                                        <input type="number" class="form-control dataInput" placeholder="رقم التليفون" id="phone" name="phone">
                                    </div>
                                    <bold class="text-danger" id="errors-phone" style="display: none;"></bold>
                                </div>   
                                
                                <div class="col-md-3 col-xs-12">
                                    <label for="birth_date">تاريخ الميلاد</label>
                                    <div>    
                                        <input type="text" class="form-control dataInput datePicker" id="birth_date" name="birth_date" placeholder="تاريخ الميلاد">
                                    </div>
                                    <bold class="text-danger" id="errors-birth_date" style="display: none;"></bold>
                                </div>
        
                                <div class="col-md-3 col-xs-12">
                                    <label for="nat_id">الرقم القومي</label>
                                    <div>    
                                        <input type="number" class="form-control dataInput" placeholder="الرقم القومي" id="nat_id" name="nat_id">
                                    </div>
                                    <bold class="text-danger" id="errors-nat_id" style="display: none;"></bold>
                                </div>
                            
                                <div class="col-md-4 col-xs-12">
                                    <label for="active">الحالة</label>
                                    <div>    
                                        <select  name="active" class="form-control active" id="active">
                                            <option value="1">نشط</option>
                                            <option value="0">معطل</option>
                                        </select>
                                    </div>
                                    <bold class="text-danger" id="errors-active" style="display: none;"></bold>
                                </div>
        
                                <div class="col-md-4 col-xs-12">
                                    <label for="user_status">نوع المستخدم</label>
                                    <i class="fas fa-star require_input"></i>
                                    <div>
                                        <select id="user_status" name="user_status"  class="form-control dataInput">
                                            <option value="" selected disabled>اختر نوع المستخدم</option>
                                            <option value="1">سوبر أدمن</option>
                                            <option value="2">موظف</option>
                                        </select>
                                    </div>
                                    <bold class="text-danger" id="errors-user_status" style="display: none;"></bold>
                                </div>  
                                
                                <div class="col-md-4 col-xs-12">
                                    <label for="user_role">التراخيص</label>
                                    <i class="fas fa-star require_input"></i>
                                    <div>
                                        <select id="user_role" name="user_role"  class="form-control dataInput">
                                            @foreach ($permissions as $item)
                                                <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <bold class="text-danger" id="errors-user_role" style="display: none;"></bold>
                                </div>  

                                <div class="col-lg-6 col-xs-12">
                                    <label for="address">العنوان </label>
                                    <div>    
                                        <input type="text" class="form-control dataInput" placeholder="العنوان " id="address" name="address">
                                    </div>
                                    <bold class="text-danger" id="errors-address" style="display: none;"></bold>
                                </div>                                   
                                
                                <div class="col-lg-6 col-xs-12">
                                    <label for="notes">ملاحظات</label>
                                    <div>    
                                        <input type="text" class="form-control dataInput" placeholder="ملاحظات" id="notes" name="notes">
                                    </div>
                                    <bold class="text-danger" id="errors-notes" style="display: none;"></bold>
                                </div>
                            </div>
                        </div>
                        {{------------------------ end left ----------------------}}
                    </div>

                              

                    <div class="row row-xs">
                        <div class="col-md-8" id="file_upload">
                            <div class="custom-file-container fileinput_fileinput" data-upload-id="file_upload" style="margin-top: 12px;">
                                <label style="color: #555;"> صورة
                                    <a href="javascript:void(0)" class="custom-file-container__image-clear clear_image" title="Clear Image">
                                        <i class="fa fa-trash-alt" style="color: rgb(221, 7, 7);font-size: 15px;position: relative;top: 3px;margin: 0px 15px 10px;"></i>
                                    </a>
                                </label>
                                <label class="custom-file-container__custom-file" >
                                    <input type="file" class="custom-file-container__custom-file__custom-file-input dataInput" name="image">
                                    <input type="hidden" name="image_hidden" id="image_hidden"/>
                                    <span class="custom-file-container__custom-file__custom-file-control heading_title text-center" style="background: #fff;font-size: 12px;"></span>
                                </label>

                                <div id="custom-file-container__image-preview">
                                    <div class="custom-file-container__image-preview" style="position: relative;top: -48px;"></div>
                                </div>
                                <bold class="text-danger" id="errors-image" style="display: none;position: relative;top: -60px;"></bold>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-xs-12">
                            <img id="image_preview_form" class="img-responsive img-thumbnail" src="{{ url('back/images/users/df_image.png') }}" />
                        </div>
                    </div>
                  </div>

                  <div class="modal-footer bg bg-dark">                                               
                      <button type="button" id="save" class="btn btn-success" style="display: none;">
                          حفظ
                          <span class="spinner-border spinner-border-sm spinner_request" role="status" aria-hidden="true"></span>
                        </button>
          
                        <button type="button" id="update" class="btn btn-success" style="display: none;">
                          تعديل
                          <span class="spinner-border spinner-border-sm spinner_request2" role="status" aria-hidden="true"></span>
                        </button>
                        
                        <button id="closeModal" type="button" class="btn btn-light" data-dismiss="modal">اغلاق</button>
                  </div>
            </form>            
            
        </div>


      </div>
    </div>
</div>
