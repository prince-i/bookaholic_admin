<div class="modal" id="edit_admin">
<div class="modal-footer">
<button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
<div class="modal-content">
<input type="hidden" name="" id="adminID">
    <div class="row">
        <div class="col s12">
            <div class="input-field col s6">
                <input type="text" name="" id="admin_userID" placeholder="USER ID">
            </div>

            <div class="input-field col s6">
                <input type="text" name="" id="admin_pass" placeholder="PASSWORD">
            </div>

            <div class="input-field col s6">
                <input type="text" name="" id="admin_name" placeholder="FULL NAME">
            </div>
        </div>
        <div class="col s12">
            <div class="col s6">
                <button class="btn btn-large col s12 #4caf50 green" onclick="update_admin()" id="">UPDATE</button>
            </div>
            <div class="col s6">
                <button class="btn btn-large col s12 #ef5350 red lighten-1" onclick="delete_admin()" id="">REMOVE</button>
            </div>
        </div>

    </div>
</div>
</div>