<div class="modal" id="add_admin_modal">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
<div class="modal-content">
    <div class="row">
        <div class="col s12">
            <div class="input-field col s6">
                <input type="text" name="" id="admin_username"><label for="">USER ID</label>
            </div>
            <div class="input-field col s6">
                <input type="text" name="" id="admin_password"><label for="">USER PASSWORD</label>
            </div>
            <div class="input-field col s6">
                <input type="text" name="" id="admin_fullname"><label for="">ADMIN FULL NAME</label>
            </div>
            <div class="input-field col s6">
                <select name="" id="admin_type" class="browser-default z-depth-4">
                    <option value="admin">ADMIN</option>
                    <option value="normal">NORMAL</option>
                </select>
            </div>
            
        </div>
        <div class="col s12">
            <button class="btn green col s12 btn-large" onclick="add_admin()" id="">Save</button>
        </div>
    </div>
</div>
</div>