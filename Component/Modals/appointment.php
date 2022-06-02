<div class="modal bottom-sheet" id="manage_appointment" style="min-height:100vh;">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
    
    <div class="row">
        <h5 class="center">APPOINTMENT</h5>
        <div class="col s12">
            <div class="col s2 input-field">
                <input type="text" name="" id="customer_name_app"><label for="">Name</label>
            </div>
            <div class="col s2 input-field">
                <input type="text" name="" id="prop_name_app"><label for="">Item Name</label>
            </div>
            <div class="col s2 input-field">
                <select name="" id="app_status" class="browser-default">
                    <option value="">[ALL] APPOINTMENT STATUS</option>
                    <option value="0">[0] PENDING APPROVAL</option>
                    <option value="1">[1] APPROVED TRANSACTION</option>
                    <option value="2">[2] DECLINED TRANSACTION</option>
                    <option value="3">[3] HISTORY TRANSACTION</option>
                    <option value="4">[4] SUCCESS TRANSACTION</option>
                </select>
            </div>

            <div class="col s2 input-field">
                <input type="text" name="" id="app_date_from" class="datepicker" value="<?=date('Y-m-d');?>"><label for="">Dated from:</label>
            </div>

            <div class="col s2 input-field">
                <input type="text" name="" id="app_date_to" class="datepicker" value="<?=date('Y-m-d');?>"><label for="">Dated to:</label>
            </div>

            <div class="col s2 input-field">
                <button class="btn col s12 green" id="search_app" onclick="load_appointment()">Search</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <table class="responsive-table">
                <thead style="font-size:10px;">
                    <th>#</th>
                    <th>CUSTOMER NAME</th>
                    <th>EMAIL</th>
                    <th>PHONE</th>
                    <th>IMG</th>
                    <th>PROPERTY NAME</th>
                    <th>PRICE</th>
                    <th>APPOINTMENT DATE</th>
                    <th>APPOINTMENT TIME</th>
                    <th>COMMENT</th>
                    <th>COMMENT APPROVAL</th>
                    <th>STATUS</th>
                    <th>DECLINE</th>
                    <th>APPROVE</th>
                    <th>REVIEW</th>
                </thead>
                <tbody id="appoint_data"></tbody>
            </table>
        </div>
    </div>

</div>