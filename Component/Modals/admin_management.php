<div class="modal bottom-sheet" id="masterlist_admin" style="min-height:100vh;">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;" onclick="uncheck_all_user()">&times;</button>
</div>
<div class="modal-content">
    <h5 class="center">ADMIN MANAGEMENT</h5>
    <div class="row">
        <div class="col s12">
            <div class="col s6 input-field">
                <input type="text" name="" id="searchAdmin" onchange="load_admin_user()"><label for="">Search</label>
            </div>
            <div class="col s6 input-field">
                <button class="btn #263238 green right modal-trigger" data-target="add_admin_modal">Add Admin</button>
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col s12 collection" style="height:100vh;overflow:auto;border:1px solid black;">
            <table class="centered" id="userMasterlist">
                <thead> 
                    <th>USER ID</th>
                    <th>FULL NAME</th>
                </thead>
                <tbody id="adminData"></tbody>
            </table>
        </div>
    </div>
</div>
</div> 