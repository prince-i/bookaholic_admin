<div class="modal" id="approved_prop">
<div class="modal-footer">
<button class="btn-flat modal-close" style="color:red;font-size:30px;">&times;</button>
</div>
<div class="modal-content">
<input type="hidden" name="" id="propID">
    <div class="row">
        <div class="col s12">
            <h5 class="center">ARE YOU SURE YOU WANT TO APPROVE THIS ITEM?</h5>
        </div>
        <div class="col s12">
            <div class="col s6">
                <button class="btn btn-large col s12 #4caf50 green" onclick="approve_proper()" id="">approve</button>
            </div>
            <div class="col s6">
                <button class="btn btn-large col s12 #ef5350 red lighten-1" onclick="delete_proper()" title="delete" id="">decline</button>
            </div>
        </div>

    </div>
</div>
</div>