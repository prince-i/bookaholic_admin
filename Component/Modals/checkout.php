<div class="modal bottom-sheet" id="manage_checkout" style="min-height:100vh;">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
    
    <div class="row">
        <h5 class="center">CHECKOUT</h5>
        <div class="col s12">
            <div class="col s2 input-field">
                <input type="text" name="" id="customer_name_co"><label for="">Name</label>
            </div>
            <div class="col s2 input-field">
                <input type="text" name="" id="prop_name_co"><label for="">Item Name</label>
            </div>
            <div class="col s2 input-field">
                <select name="" id="co_status" class="browser-default">
                    <option value="">[ALL] CO STATUS</option>
                    <option value="0">[0] PENDING ORDER</option>
                    <option value="1">[1] TO PAY</option>
                    <option value="2">[2] CANCELLED ORDER</option>
                    <option value="3">[3] DELIVERED</option>
                    <option value="4">[4] TO DELIVER</option>
                    <option value="5">[5] COMPLETED</option>
                    <option value="6">[6] TO PROCESS</option>
                    <option value="7">[7] PAID</option>
                </select>
            </div>

            <!-- <div class="col s2 input-field">
                <input type="text" name="" id="co_date_from" class="datepicker" value="<?=date('Y-m-d');?>"><label for="">Dated from:</label>
            </div>

            <div class="col s2 input-field">
                <input type="text" name="" id="co_date_to" class="datepicker" value="<?=date('Y-m-d');?>"><label for="">Dated to:</label>
            </div> -->

            <div class="col s2 input-field">
                <button class="btn col s12 green" id="search_co" onclick="load_checkout()">Search</button>
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
                    <th>LOCATION</th>
                    <th>LANDMARK</th>
                    <th>SPECIAL</th>
                    <th>COMMENT</th>
                    <th>APPROVAL COMMENT</th>
                    <th>STATUS</th>
                    <th>DECLINE</th>
                    <th>APPROVE</th>
                    <th>REVIEW</th>
                    <th>CANCEL</th>
                    <th>PAYMENT</th>
                </thead>
                <tbody id="co_data"></tbody>
            </table>
        </div>
    </div>

</div>