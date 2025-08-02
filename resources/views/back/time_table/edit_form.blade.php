@if (auth()->user()->user_status != 4)
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">تعديل حصة</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <div class="modal-body" style="display: none;">
                <form class="" id="editForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="res_id" value="" />

                    <input type="hidden" id="day_res" />
                    <input type="hidden" id="room_res" />
                    <input type="hidden" id="user_res" />
                    <input type="hidden" id="group_to_colspan_res" />


                    <div class="pd-30 pd-sm-40" style="background-image: linear-gradient(to right, #9aba99 0, #ebf2a8 100%) !important;">
                        <div class="row row-xs">
                            <div class="col-lg-4">
                                <div class="col-xs-12">
                                    <label for="group_id">المجموعة</label>
                                    <i class="fas fa-star require_input"></i>
                                    <div>
                                        <select id="group_id" name="group_id" class="selectize dataInput">
                                            <option value="" selected disabled>المجموعات</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->groupId }}">
                                                    {{ $group->groupName }} -
                                                    {{ $group->teacherName }}
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

                                <div class="col-xs-12 mt-1">
                                    <p>تاريخ الحصة التعوضية</p>
                                    <div id="date" style="font-weight: bold;text-align: center;"></div>
                                    <bold class="text-danger" id="errors-date" style="display: none;"></bold>
                                </div>

                                <div class="col-xs-12">
                                    <label for="notes">ملاحظات</label>
                                    <div>
                                        <input type="text" class="form-control dataInput" id="notes" name="notes" placeholder="ملاحظات">
                                    </div>
                                    <bold class="text-danger" id="errors-notes" style="display: none;"></bold>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="col-xs-12">
                                    <label for="recorded_times">مواعيد الحصة المسجلة</label>
                                    <div>
                                        <select id="recorded_times" name="recorded_times[]" class="form-control dataInput recorded_times" style="height: 377px !important;overflow: auto;" multiple>

                                        </select>
                                    </div>
                                    <bold class="text-danger" id="errors-recorded_times" style="display: none;padding: 7px 0;"></bold>
                                </div>


                                <input type="hidden" id="recorded_times_hidden" name="recorded_times_hidden" />


                                <div class="col-xs-12">
                                    <button type="button" class="btn btn-danger btn-sm btn-block" id="remove_recorded_times">
                                        حذف مواعيد الحصص المختارة
                                        <i class="fa fa-trash-alt pd-10"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="col-xs-12">
                                    <label for="times">مواعيد الحصص المتاحة</label>
                                    <div>
                                        <select id="times" name="times[]" class="form-control dataInput times" style="height: 414px !important;" multiple>

                                        </select>
                                    </div>
                                    <bold class="text-danger" id="errors-times" style="display: none;padding: 7px 0;"></bold>
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
                        <button type="button" id="save" class="btn btn-success">
                            تعديل
                        <span class="spinner-border spinner-border-sm spinner_request" role="status" aria-hidden="true"></span>
                        </button>

                        <button id="closeModal" type="button" class="btn btn-light" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

@else

    <div class="modal fade" id="editModal" id="editModal2" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <div class="modal-body" style="display: none;">
                <form class="" id="editForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="res_id" value="" />

                    <input type="hidden" id="day_res" />
                    <input type="hidden" id="room_res" />
                    <input type="hidden" id="user_res" />
                    <input type="hidden" id="group_to_colspan_res" />


                    <div class="pd-30 pd-sm-40" style="background-image: linear-gradient(to right, #9aba99 0, #ebf2a8 100%) !important;">
                        <div class="row row-xs">
                            <div class="col-12" style="display: none;">
                                <select id="group_id" name="group_id" class="selectize dataInput">
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->groupId }}">
                                            {{ $group->groupName }} -
                                            {{ $group->teacherName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xs-12 mt-1">
                                <p>تاريخ الحصة التعوضية</p>
                                <div id="date" style="font-weight: bold;text-align: center;"></div>
                                <bold class="text-danger" id="errors-date" style="display: none;"></bold>
                            </div>

                            <div class="col-12">
                                <div class="col-xs-12">
                                    <label for="recorded_times">مواعيد الحصة المسجلة</label>
                                    <div>
                                        <select id="recorded_times" name="recorded_times[]" class="form-control dataInput recorded_times" style="height: 180px !important;overflow: auto;" multiple>

                                        </select>
                                    </div>
                                    <bold class="text-danger" id="errors-recorded_times" style="display: none;padding: 7px 0;"></bold>
                                </div>

                                <input type="hidden" id="recorded_times_hidden" name="recorded_times_hidden" />

                                <div class="col-xs-12">
                                    <button type="button" class="btn btn-danger btn-sm btn-block" id="remove_recorded_times">
                                        حذف مواعيد الحصص المختارة
                                        <i class="fa fa-trash-alt pd-10"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
@endif
