<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog " role="document">
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
                        <label for="name">الصف الدراسي</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                            <input type="text" class="form-control dataInput" placeholder="الصف الدراسي" id="name" name="name" value="">
                        </div>
                        <bold class="text-danger" id="errors-name" style="display: none;"></bold>
                      </div>    
                      
                      <div class="col-12">
                        <label for="color">لون الصف الدراسي</label>
                        <i class="fas fa-star require_input"></i>
                        <div>
                          <select id="colorSelect" class="form-control dataInput" id="color2" name="color2" style="margin-bottom: 5px;">
                            <option value="" selected>لون الصف الدراسي</option>
                            <option value="#808000" style="background-color: #808000;">بني فاتح 808000#</option>
                            <option value="#ff66cc" style="background-color: #ff66cc;">وردي فاتح ff66cc#</option>
                            <option value="#ccffcc" style="background-color: #ccffcc;">أخضر فاتح ccffcc#</option>
                            <option value="#ccccff" style="background-color: #ccccff;">أزرق فاتح ccccff#</option>
                            <option value="#ffcccc" style="background-color: #ffcccc;">وردي فاتح ffcccc#</option>
                            <option value="#99ccff" style="background-color: #99ccff;">أزرق سماوي 99ccff#</option>
                            <option value="#ff99cc" style="background-color: #ff99cc;">وردي سماوي ff99cc#</option>
                            <option value="#cc99ff" style="background-color: #cc99ff;">أرجواني سماوي cc99ff#</option>
                            <option value="#33cccc" style="background-color: #33cccc;">أخضر سماوي 33cccc#</option>
                            <option value="#008000" style="background-color: #008000;">أخضر غامق 008000#</option>
                            <option value="#ffcccc" style="background-color: #ffcccc;">وردي سماوي ffcccc#</option>
                            <option value="#00ff00" style="background-color: #00ff00;">أخضر #00ff00</option>
                            <option value="#0000ff" style="background-color: #0000ff;">أزرق 0000ff#</option>
                            <option value="#ffff00" style="background-color: #ffff00;">أصفر #ffff00</option>
                            <option value="#66cccc" style="background-color: #66cccc;">أزرق سماوي 66cccc#</option>
                            <option value="#ff00ff" style="background-color: #ff00ff;">وردي ff00ff#</option>
                            <option value="#ff9900" style="background-color: #ff9900;">برتقالي #ff9900</option>
                            <option value="#800000" style="background-color: #800000;">بني غامق 800000#</option>
                            <option value="#000080" style="background-color: #000080;">أزرق غامق 000080#</option>
                            <option value="#008080" style="background-color: #008080;">أخضر فاتح 008080#</option>
                            <option value="#800080" style="background-color: #800080;">أرجواني 800080#</option>
                            <option value="#ffcc00" style="background-color: #ffcc00;">ذهبي ffcc00#</option>
                            <option value="#c0c0c0" style="background-color: #c0c0c0;">رمادي c0c0c0#</option>
                            <option value="#ff0000" style="background-color: #ff0000;">أحمر ff0000#</option>
                            <option value="#808080" style="background-color: #808080;">رمادي غامق 808080#</option>
                            <option value="#33cc33" style="background-color: #33cc33;">أخضر فاتح 33cc33#</option>
                            <option value="#66ccff" style="background-color: #66ccff;">أزرق فاتح 66ccff#</option>
                            <option value="#ffffff" style="background-color: #ffffff;">أبيض ffffff#</option>
                            <option value="#000000" style="background-color: #000000;color: #fff;">أسود 000000#</option>
                          </select>

                          <input type="color" class="form-control dataInput" placeholder="اختر لون" id="color" name="color">
                        </div>
                        <bold class="text-danger" id="errors-color" style="display: none;"></bold>
                      </div>    
                       
                      <div class="col-12">
                        <label for="status">الحالة</label>
                        <div>    
                            <select name="status" class="form-control status" id="status">
                                <option value="1">نشط</option>
                                <option value="0">معطل</option>
                            </select>
                        </div>
                        <bold class="text-danger" id="errors-status" style="display: none;"></bold>
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
