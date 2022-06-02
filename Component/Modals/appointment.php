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
        <div class="col s12 collection" style="height:100vh;overflow:auto;border:1px solid black;">
            <table class="responsive-table" id="app_table">
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
                    <th>APPOINTMENT DATE</th>
                    <th>APPOINTMENT TIME</th>
                    <th>STATUS</th>
                </thead>
                <tbody id="appoint_data"></tbody>
            </table>
        </div>
        <button class="btn left green" onclick="export_appointment('app_table')">export appointments &darr;</button>
        </div>
        
    </div>

</div>

<script>
function export_appointment(table_id, separator = ',') {
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
    var filename = 'BOOKAHOLIC_APPOINTMENTS'+ '_' + new Date().toLocaleDateString() + '.csv';
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