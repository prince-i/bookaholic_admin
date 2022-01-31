<div class="modal" id="plan_menu_admin">
<div class="modal-footer">
    <button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
<div class="modal-content">
    <div class="row">
         <div class="col s12 center">
            <div id="image_prop_view"></div>
        </div>
        <div class="col s12" style="font-size:20px;font-family:arial;">
            <div class="col s6">
                <b>Property Owner:</b>
                <span id="propowner"></span>
            </div>
            <div class="col s6">
                <b>Property Name:</b>
                <span id="propname"></span>
            </div>
            <div class="col s6">
                <b>Owner Contact:</b>
                <span id="propdesc"></span>
            </div>
            <div class="col s6">
                <b>Price:</b>
                <span id="prop_price"></span>
            </div>
            <div class="col s6">
                <b>Address:</b>
                <span id="prop_address"></span>
            </div>
            <div class="col s6">
                <b>Rent Status:</b>
                <span id="rent_stat"></span>
            </div>
        </div>

        <div class="col s12">
            <input type="hidden" name="" id="propertyID">
        </div>
        
    </div>
    <div class="row divider"></div>
    <div class="row">
    <div class="input-field col s12 center">
        <button class="btn red" onclick="delete_plan_admin()" id="delPlanBtn">delete</button>
    </div>
    </div>
</div>
</div>