<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            <form class="" id="addForm" enctype="multipart/form-data">
                @csrf
                {{-- <h4 class="mb-4">جدول الحصص</h4> --}}

                <div class="pd-30 pd-sm-40" style="background-image: linear-gradient(to right, #c3cdf3 0, #f7d7d7 100%) !important;">
                    <div class="row row-xs">
                        <div class="col-lg-7">
                            <div class="col-xs-12">
                                <label for="group_id">المجموعة</label>
                                <i class="fas fa-star require_input"></i>
                                <div>
                                    <select id="group_id" name="group_id" class="selectize dataInput">
                                        <option value="" selected disabled>المجموعات</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->groupId }}">
                                                {{ $group->groupName }}

                                                @if (auth()->user()->user_status != 4)
                                                     -
                                                    {{ $group->teacherName }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <bold class="text-danger" id="errors-group_id" style="display: none;"></bold>
                            </div>

                            <div class="col-xs-12">
                                <label for="day">الايام</label>
                                <i class="fas fa-star require_input"></i>
                                <div>
                                    <select class="form-control" name="day" id="day">
                                        <option value="السبت">السبت</option>
                                        <option value="الأحد">الأحد</option>
                                        <option value="الاثنين">الاثنين</option>
                                        <option value="الثلاثاء">الثلاثاء</option>
                                        <option value="الأربعاء">الأربعاء</option>
                                        <option value="الخميس">الخميس</option>
                                        <option value="الجمعة">الجمعة</option>
                                    </select>
                                </div>
                                <bold class="text-danger" id="errors-day" style="display: none;"></bold>
                            </div>

                            <div class="col-xs-12">
                                <label for="room_id">الغرف الدراسية</label>
                                <i class="fas fa-star require_input"></i>
                                <div>
                                    <select class="form-control room_id" name="room_id" id="room_id" required>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->roomId }}">{{ $room->roomName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <bold class="text-danger" id="errors-room_id" style="display: none;"></bold>
                            </div>

                            <div class="col-xs-12">
                                <label for="user">مستخدم</label>
                                <i class="fas fa-star require_input"></i>
                                <div>
                                    <select class="form-control user" name="user" id="user" required style="font-size: 17px;font-weight: bold;">
                                    <option value="1" style="font-size: 16px !important;font-weight: bold !important;">1 (*)</option>
                                    <option value="2" style="font-size: 16px !important;font-weight: bold !important;">2 (#)</option>
                                </select>
                                </div>
                                <bold class="text-danger" id="errors-user" style="display: none;"></bold>
                            </div>

                            @if (auth()->user()->user_status != 4)
                                <div class="col-xs-12">
                                    <label for="class_type">نوع الحصة</label>
                                    <i class="fas fa-star require_input"></i>
                                    <div>
                                        <select class="form-control" name="class_type" id="class_type">
                                            <option value="أساسية">أساسية</option>
                                            <option value="تعوضية">تعوضية</option>
                                            <option value="محجوزة">محجوزة</option>
                                        </select>
                                    </div>
                                    <bold class="text-danger" id="errors-class_type" style="display: none;"></bold>
                                </div>

                                <div class="col-xs-12">
                                    <label for="date">تاريخ الحصة التعوضية</label>
                                    <i class="fas fa-star require_input"></i>
                                    <div>
                                        <input type="text" placeholder="تاريخ الحصة التعوضية" class="form-control datePicker" name="date" id="date" required style="font-weight: bold;text-align: center;"/>
                                    </div>
                                    <bold class="text-danger" id="errors-date" style="display: none;"></bold>
                                </div>
                            @else
                                <div class="col-xs-12">
                                    <label for="date">تاريخ الحصة التعوضية</label>
                                    <i class="fas fa-star require_input"></i>
                                    <div>
                                        <input type="text" placeholder="تاريخ الحصة التعوضية" class="form-control datePicker" name="date" id="date" required style="font-weight: bold;text-align: center;"/>
                                    </div>
                                    <bold class="text-danger" id="errors-date" style="display: none;"></bold>
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-5">
                            <div class="col-xs-12">
                                <label for="times">مواعيد الحصص المتاحة</label>
                                <i class="fas fa-star require_input"></i>
                                <div>
                                    <select id="times" name="times[]" class="form-control dataInput times" style="height: 263px !important;" multiple>
                                        <option class="text-center text-danger" disabled style="margin-top: 60px;font-size: 13px;">اختر أولا الغرفة الدراسية واليوم والمستخدم</option>
                                        <option class="text-center text-danger" disabled style="font-size: 13px;">لإظهار المواعيد المتاحة</option>
                                    </select>
                                </div>
                                <bold class="text-danger" id="errors-times" style="display: none;padding: 7px 0;"></bold>
                            </div>

                            <div class="col-xs-12">
                                <label for="notes">ملاحظات</label>
                                <div>
                                    <input type="text" class="form-control dataInput" id="notes" name="notes" placeholder="ملاحظات">
                                </div>
                                <bold class="text-danger" id="errors-notes" style="display: none;"></bold>
                            </div>


                        </div>
                    </div>
                    <br>
                    <button type="button" class="btn btn-warning btn-lg btn-block text-dark btn_get_available_times" style="font-weight: bold;">
                        إظهار المواعيد المتاحة
                        <i class="fa fa-search"></i>
                    </button>
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
