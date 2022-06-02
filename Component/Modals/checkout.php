<div class="modal bottom-sheet" id="manage_checkout" style="min-height:100vh;">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
    
    <div class="row">
        <h5 class="center">CHECKOUT</h5>
        <div class="col s12">
            <div class="col s3 input-field">
                <input type="text" name="" id="customer_name_co"><label for="">Name</label>
            </div>
            <div class="col s3 input-field">
                <input type="text" name="" id="prop_name_co"><label for="">Item Name</label>
            </div>
            <div class="col s3 input-field">
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
                    <option value="8">[8] PENDING CANCELLATION</option>
                </select>
            </div>

          

            <div class="col s3 input-field">
                <button class="btn col s12 green" id="search_co" onclick="load_checkout()">Search</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
        <div class="col s12 collection" style="height:100vh;overflow:auto;border:1px solid black;">
            <table class="responsive-table" id="checkout_table">
                <thead style="font-size:10px;">
                    <th>#</th>
                    <th>CUSTOMER NAME</th>
                    <th>EMAIL</th>
                    <th>PHONE</th>
                    <th>IMG</th>
                    <th>PROPERTY NAME</th>
                    <th>PRICE</th>
                    <th>SELLER</th>
                    <th>SELLER EMAIL</th>
                    <th>SELLER PHONE</th>
                    <th>LOCATION</th>
                    <th>LANDMARK</th>
                    <th>STATUS</th>
                </thead>
                <tbody id="co_data"></tbody>
            </table>
        </div>
        <button class="btn left green" onclick="export_checkout('checkout_table')">export checkout &darr;</button>
        </div>
    </div>

</div>

<script>
function export_checkout(table_id, separator = ',') {
    var rows = document.querySelectorAll('table#' + table_id + ' tr');
    // CONSTRUCT CSV
    var csv = [];
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll('td, th');
        for (var j = 0; j < cols.length; j++) {
            var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
            data = data.replace(/"/g, '""');
            row.push('"' + data + '"');
        }
        csv.push(row.join(separator));
    }
    var csv_string = csv.join('\n');
    var filename = 'BOOKAHOLIC_CHECKOUT'+ '_' + new Date().toLocaleDateString() + '.csv';
    var link = document.createElement('a');
    link.style.display = 'none';
    link.setAttribute('target', '_blank');
    link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>