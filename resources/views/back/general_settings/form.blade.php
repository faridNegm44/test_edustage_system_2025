<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{ $pageNameAr }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
            <form class="" id="form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="res_id" value=""/>               
                
                <div class="panel panel-primary tabs-style-2">
                  <div class=" tab-menu-heading">
                    <div class="tabs-menu1">
                      <!-- Tabs -->
                      <ul class="nav panel-tabs main-nav-line" style="justify-content: center;margin-bottom: 10px;font-weight: bold;text-decoration: underline;">
                        <li><a href="#general" class="nav-link active" data-toggle="tab">عام</a></li>
                        <li><a href="#images" class="nav-link" data-toggle="tab">الصور</a></li>
                        {{--  <li><a href="#mail" class="nav-link" data-toggle="tab">البريد الإلكتروني</a></li>  --}}
                        <li><a href="#social" class="nav-link" data-toggle="tab">التواصل الإجتماعي</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="panel-body tabs-menu-body border bg-gray-100" style="padding: 30px 30px 50px;">
                    <div class="tab-content">
                        


                        {{--------------------- tab 1 general  ---------------------}}
                        <div class="tab-pane active" id="general">

                          <h5 style="text-decoration: underline;font-weight: bold;">معلومات أساسية</h5>
                          <div class="row row-xs">
                            <div class="col-lg-6">
                              <label for="name" class="main-content-label tx-11 tx-medium tx-gray-600">اسم البرنامج </label>
                              <i class="fas fa-star require_input"></i>
                              <input type="text" class="form-control" placeholder="اسم البرنامج " id="name" name="name" value="{{ $find->name }}">
                              <div>
                                <bold class="text-danger" id="errors-name" style="display: none;"></bold>
                              </div>
                            </div>
                                                        
                            <div class="col-lg-6">
                              <label for="description" class="main-content-label tx-11 tx-medium tx-gray-600">الوصف </label>
                              <input type="text" class="form-control" placeholder="الوصف " id="description" name="description" value="{{ $find->description }}">
                            </div>
                           
                            <div class="col-lg-8">
                              <label for="footer_text" class="main-content-label tx-11 tx-medium tx-gray-600">نص الفوتر</label>
                              <input type="text" class="form-control" placeholder="نص الفوتر" id="footer_text" name="footer_text" value="{{ $find->footer_text }}">
                            </div>
                          </div>                         


                          <br>
                          <h5 style="text-decoration: underline;font-weight: bold;">العنوان</h5>
                          <div class="row row-xs">
                            <div class="col-lg-8">
                              <label for="address" class="main-content-label tx-11 tx-medium tx-gray-600">العنوان</label>
                              <input type="text" class="form-control" placeholder="العنوان" id="address" name="address" value="{{ $find->address }}">
                              <div>
                                <bold class="text-danger" id="errors-address" style="display: none;"></bold>
                              </div>
                            </div>
                            
                            <div class="col-lg-2">
                              <label for="city" class="main-content-label tx-11 tx-medium tx-gray-600">المدينة</label>
                              <input type="text" class="form-control" placeholder="المدينة" id="city" name="city" value="{{ $find->city }}">
                            </div>
                            
                            <div class="col-lg-2">
                              <label for="zip_code" class="main-content-label tx-11 tx-medium tx-gray-600">Zip Code</label>
                              <input type="text" class="form-control" placeholder="Zip Code" id="zip_code" name="zip_code" value="{{ $find->zip_code }}">
                            </div>
                          </div>


                          <br>
                          <h5 style="text-decoration: underline;font-weight: bold;">معلومات الإتصال</h5>
                          <div class="row row-xs">
                            <div class="col-lg-4">
                              <label for="email" class="main-content-label tx-11 tx-medium tx-gray-600">البريد الإلكتروني</label>
                              <input type="text" class="form-control" placeholder="البريد الإلكتروني" id="email" name="email" value="{{ $find->email }}">
                              <div>
                                <bold class="text-danger" id="errors-email" style="display: none;"></bold>
                              </div>
                            </div>
                            
                            <div class="col-lg-4">
                              <label for="phone1" class="main-content-label tx-11 tx-medium tx-gray-600">رقم التلفون الأول</label>
                              <input type="text" class="form-control" placeholder="رقم التلفون الأول" id="phone1" name="phone1" value="{{ $find->phone1 }}">
                              <div>
                                <bold class="text-danger" id="errors-phone1" style="display: none;"></bold>
                              </div>
                            </div>
                            
                            <div class="col-lg-4">
                              <label for="phone2" class="main-content-label tx-11 tx-medium tx-gray-600">رقم التلفون الثاني</label>
                              <input type="text" class="form-control" placeholder="رقم التلفون الثاني" id="phone2" name="phone2" value="{{ $find->phone2 }}">
                              <div>
                                <bold class="text-danger" id="errors-phone2" style="display: none;"></bold>
                              </div>
                            </div>
                          </div>
                        </div>







                        {{--------------------- tab 2 images ---------------------}}
                        <div class="tab-pane" id="images">
                          <h5 style="text-decoration: underline;font-weight: bold;">الصور</h5>
                          <div class="row row-xs">
                            {{--<div class="col-lg-6">
                              <label for="logo_website" class="main-content-label tx-11 tx-medium tx-gray-600">صورة التقارير</label>
                              <i class="fas fa-star require_input"></i>
                              <input type="file" class="form-control"  id="logo_website" name="logo_website" >
                              <input type="hidden"  name="logo_website_hidden" value="{{ $find->logo_website }}">
                              <img class="w-100" src="{{ url('back/images/settings/'.$find->logo_website) }}" height="300" alt="logo_website">
                              
                              <div style="padding: 7px 0;">
                                <bold class="text-danger" id="errors-logo_website" style="display: none;"></bold>
                              </div>
                            </div>--}}
                            
                            <div class="col-lg-6">
                              <label for="logo_dashboard" class="main-content-label tx-11 tx-medium tx-gray-600">صورة لوحة التحكم</label>
                              <i class="fas fa-star require_input"></i>
                              <input type="file" class="form-control" id="logo_dashboard" name="logo_dashboard">
                              <input type="hidden"  name="logo_dashboard_hidden" value="{{ $find->logo_dashboard }}">
                              <img class="w-100" src="{{ url('back/images/settings/'.$find->logo_dashboard) }}" height="300" alt="logo_dashboard">
                              
                              <div style="padding: 7px 0;">
                                <bold class="text-danger" id="errors-logo_dashboard" style="display: none;"></bold>
                              </div>
                            </div>
                            
                            <div class="col-lg-6">
                              <label for="fav_icon" class="main-content-label tx-11 tx-medium tx-gray-600">صورة التقارير</label>
                              <i class="fas fa-star require_input"></i>
                              <input type="file" class="form-control"  id="fav_icon" name="fav_icon">
                              <input type="hidden"  name="fav_icon_hidden" value="{{ $find->fav_icon }}">
                              <img class="w-100" src="{{ url('back/images/settings/'.$find->fav_icon) }}" height="300" alt="fav_icon">
                              
                              <div style="padding: 7px 0;">
                                <bold class="text-danger" id="errors-fav_icon" style="display: none;"></bold>
                              </div>
                            </div>
                          </div>
                        </div>



                      
                        {{--------------------- tab 3 mail ---------------------}}
                        {{--  <div class="tab-pane" id="mail">
                          
                          
                        </div>  --}}






                        {{--------------------- tab 4 social ---------------------}}
                        <div class="tab-pane" id="social">
                          <h5 style="text-decoration: underline;font-weight: bold;">التواصل الإجتماعي</h5>
                          <div class="row row-xs">
                            <div class="col-lg-6">
                              <label for="facebook" class="main-content-label tx-11 tx-medium tx-gray-600">فيس بوك</label>
                              <input type="text" class="form-control" placeholder="فيس بوك" id="facebook" name="facebook" value="{{ $find->facebook }}">
                              <div>
                                <bold class="text-danger" id="errors-facebook" style="display: none;"></bold>
                              </div>
                            </div>
                            
                            <div class="col-lg-6">
                              <label for="instagram" class="main-content-label tx-11 tx-medium tx-gray-600">انستجرام</label>
                              <input type="text" class="form-control" placeholder="انستجرام" id="instagram" name="instagram" value="{{ $find->instagram }}">
                              <div>
                                <bold class="text-danger" id="errors-instagram" style="display: none;"></bold>
                              </div>
                            </div>

                            <div class="col-lg-6">
                              <label for="tiktok" class="main-content-label tx-11 tx-medium tx-gray-600">تيك توك</label>
                              <input type="text" class="form-control" placeholder="تيك توك" id="tiktok" name="tiktok" value="{{ $find->tiktok }}">
                              <div>
                                <bold class="text-danger" id="errors-tiktok" style="display: none;"></bold>
                              </div>
                            </div>
                            
                            <div class="col-lg-6">
                              <label for="twitter" class="main-content-label tx-11 tx-medium tx-gray-600">تويتر</label>
                              <input type="text" class="form-control" placeholder="تويتر" id="twitter" name="twitter" value="{{ $find->twitter }}">
                              <div>
                                <bold class="text-danger" id="errors-twitter" style="display: none;"></bold>
                              </div>
                            </div>
                                                      
                            <div class="col-lg-6">
                              <label for="google" class="main-content-label tx-11 tx-medium tx-gray-600">جوجل</label>
                              <input type="text" class="form-control" placeholder="جوجل" id="google" name="google" value="{{ $find->google }}">
                              <div>
                                <bold class="text-danger" id="errors-google" style="display: none;"></bold>
                              </div>
                            </div>                        
                            
                            <div class="col-lg-6">
                              <label for="youtube" class="main-content-label tx-11 tx-medium tx-gray-600">يوتيوب</label>
                              <input type="text" class="form-control" placeholder="يوتيوب" id="youtube" name="youtube" value="{{ $find->youtube }}">
                              <div>
                                <bold class="text-danger" id="errors-youtube" style="display: none;"></bold>
                              </div>
                            </div>
                            
                          </div>
                        </div>
                      
                    </div>
                  </div>
                </div>
              

                <div class="modal-footer bg bg-dark">                                               
                  <button type="button" id="update" class="btn btn-success">
                      حفظ
                      <span class="spinner-border spinner-border-sm spinner_request2" role="status" aria-hidden="true"></span>
                    </button>
                          
                    <button id="closeModal" type="button" class="btn btn-light" data-dismiss="modal">اغلاق</button>
              </div>

            </form>            
        </div>
      </div>
    </div>
</div>
