<div class="modal fade bg bg-primary-gradient" id="duplicatedEmailsModal" tabindex="-1" role="dialog" aria-labelleDBy="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="duplicatedEmailsLabel">📧 إيميلات مكررة لنفس الإيميل</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">

        <div class="" style="padding: 15px 30px !important;">
          <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
              <thead class="thead-dark">
                <tr>
                  {{--<th>ID المستخدم</th>--}}
                  <th>الاسم</th>
                  <th>حالته</th>
                  <th>الإيميل</th>
                </tr>
              </thead>
              <tbody id="duplicatedEmailsTableBody">
                <!-- هنا هيتضاف الداتا بالجافاسكربت -->
              </tbody>
            </table>
          </div>
        </div>

        <div class="modal-footer">                                                                 
            <button id="closeModal" type="button" class="btn btn-outline-secondary btn-rounded" data-dismiss="modal">اغلاق</button>
        </div> 
      </div>
    </div>
  </div>
</div>
