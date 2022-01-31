<div class="modal bottom-sheet" id="history_logs" style="min-height:100vh;">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
<div class="modal-content">
    <h5 class="center">PROPERTY FOR APPROVAL</h5>
    <div class="row">
        <div class="col s12">
            <!-- FROM -->
            <div class="col l3  m6 s12 input-field">
                <input type="text" class="datepicker" id="log_from" value="">
            </div>
            <!-- TO -->
            <div class="col l3 m6 s12 input-field">
                <input type="text" class="datepicker" id="log_to" value="">
            </div>
            <!-- KEYWORD -->
            <div class="col l3 m12 s12 input-field">
                <input type="text" name="" id="keywordHistory">
                <label for="">Search</label>
            </div>
            <!-- BUTTON -->
            <div class="col l3 m12 s12 input-field">
                <button class="btn col s12 btn-large #2e7d32 green darken-3" onclick="load_for_approve()">Search</button>
            </div>
        </div>

        <div class="col s12 collection" style="max-height:80vh;border:1px solid black;overflow:auto;">
            <table id="history_table" style="word-break:break;">
                <thead>
                    <th>#</th>
                        <th>RENT STATUS</th>
                        <th>PROPERTY NAME</th>
                        <th>DESCRIPTION</th>
                        <th>PRICE</th>
                        <th>ADDRESS</th>
                        <th>PROPERTY STATUS</th>
                        <th>OWNER NAME</th>
                        <th>OWNER MOBILE NO.</th>
                        <th>OWNER EMAIL</th>
                        <th>POSTED</th>
                </thead>
                <tbody id="history_data_output"></tbody>
            </table>
        </div>
        <button class="btn left green" onclick="export_logs('history_table')">export logs &darr;</button>
    </div>
</div>
</div>

<script>
function export_logs(table_id, separator = ',') {
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
    var filename = 'BOOKAHOLIC_FOR_APPROVAL'+ '_' + new Date().toLocaleDateString() + '.csv';
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