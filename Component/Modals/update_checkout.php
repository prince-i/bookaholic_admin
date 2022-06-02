<div class="modal" id="update_chk_out" style="">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;" id="update_chk_out_close">&times;</button>
</div>
    
    <div class="row">
        <h5 class="center">UPDATE CHECKOUT STATUS</h5>
        <div class="col s12">
            <div class="col s12 input-field">
                <input type="text" name="" id="co_id_ups">
            </div>
            <div class="col s12 input-field">
                <select name="" id="co_status_ups" class="browser-default">
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

         
            <div class="col s2 input-field">
                <button class="btn col s12 green" id="search_co" onclick="update_checkout()">UPDATE</button>
            </div>
        </div>
    </div>


</div>