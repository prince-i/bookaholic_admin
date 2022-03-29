<?php
    require '../process/session.php';
    
    
    if($user_type == 'normal'){
        session_unset();
        session_destroy();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="../Image/logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOKAHOLIC ADMIN | <?=$full_name;?></title>
    <link rel="stylesheet" href="../materialize/css/materialize.min.css">
    <link rel="stylesheet" href="../Component/main.css">
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<?php
    include '../Component/Modals/logout-modal.php';
    include '../Component/Modals/plan_admin_modal.php';
    include '../Component/Modals/user_management.php';
    include '../Component/Modals/admin_management.php';
    include '../Component/Modals/add_user.php';
    include '../Component/Modals/edit_user.php';
    include '../Component/Modals/modal_history_logs.php';
    include '../Component/Modals/edit_admin.php';
    include '../Component/Modals/approve_prop.php';
    include '../Component/Modals/add_admin_modal.php';
?>
<nav class="#388e3c green darken-2">
    <div class="nav-wrapper">
      <a href="#" style="margin-left:15px" class="brand-logo"> Hi, <?=$full_name;?></a>
      <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="#" data-target="masterlist_admin" class="modal-trigger" onclick="load_admin_user()">Manage Admin</a></li>
        <li><a href="#" class="modal-trigger" data-target="manage_user" onclick="load_users()">Manage Users</a></li>
        <li><a href="#" data-target="history_logs" class="modal-trigger" onclick="load_for_approve()">For Approval <span id="apprCount" class="badge new red">0</span></a></li>
        <li><a href="#" data-target="modal-logout" class="modal-trigger">Sign out</a></li>
      </ul>
    </div>
  </nav>

   <ul class="sidenav" id="mobile-demo">
        <li><a href="#" data-target="masterlist_admin" class="modal-trigger" onclick="load_admin_user()">Manage Admin</a></li>
        <li><a href="#" class="modal-trigger" data-target="manage_user" onclick="load_users()">Manage Users</a></li>
        <li><a href="#" data-target="history_logs" class="modal-trigger" onclick="load_for_approve()">For Approval <span id="apprCount" class="badge new red">0</span></a></li>
        <li><a href="#" data-target="modal-logout" class="modal-trigger">Sign out</a></li>
  </ul>
<!-- PLAN LIST -->


<div class="row">
    <div class="col s12">
        <!-- BUTTON & SEARCH -->
        <div class="row">
            <div class="col s4">
                <div class="card">
                    <div class="card-content">
                        <h5 style="color:#136912;">NO. OF SELLERS</h5>
                        <span id="total_seller" class="flow-text"></span>
                    </div>
                </div>
            </div>

            <div class="col s4">
                <div class="card">
                    <div class="card-content">
                        <h5 style="color:#136912;">NO. OF BUYERS</h5>
                        <span id="total_buyer" class="flow-text"></span>
                    </div>
                </div>
            </div>

            <div class="col s4">
                <div class="card">
                    <div class="card-content">
                        <h5 style="color:#136912;">NO. OF BOOKS</h5>
                        <span id="total_property" class="flow-text"></span>
                    </div>
                </div>
            </div>

            <div class="col s12">
                <!-- SEARCH -->
                <div class="input-field col l2 m12 s12">
                    <input type="text" name="" id="date_from" class="datepicker" placeholder="Date From" value="<?=$server_date_only;?>">
                </div>

                <div class="input-field col l2 m12 s12">
                    <input type="text" name="" id="date_to" class="datepicker" placeholder="Date To" value="<?=$server_date_only;?>">
                </div>

                <div class="input-field col l2 m12 s12">
                    <input type="text" name="" id="partscode_search" ><label for="keyword">Book Title Name</label>
                </div>
                <!-- SHIFT -->
                <div class="input-field col l2 m12 s12">
                    <select name="" id="shift_search" class="browser-default z-depth-1" style="border-radius:30px;">
                        <option value="">SELECT BOOK STATUS</option>
                        <option value="0">PENDING TO POST</option>
                        <option value="1">POSTED</option>
                        <option value="2">SOLD</option>
                        <option value="3">DELETED/HIDDEN</option>
                       
                    </select>
                </div>


                <!-- SEARCH BTN -->
                <div class="input-field col l2 m12 s12">
                    <button class="btn col s12 btn-large #4caf50 green" onclick="load_plan_list()" id="search-plan" style="border-radius:30px;"> Search</button>
                </div>
                <!-- EXPORT -->
                <div class="input-field col l2 m12 s12">
                    <button id="exportBtn" class="btn col s12 btn-large #81c784 green lighten-2" onclick="export_plan('planTable')" style="border-radius:30px;"> Export</button>
                </div>
            </div>
        </div>

        <!-- ORDER/PLAN LIST -->
            <div class="col s12 collection z-depth-1" id="plan_list">
                <table class="centered" id="planTable">
                    <thead style="font-size:12px;">
                        <th>#</th>
                        <th>Book Image</th>
                        <th>Book Title</th>
                        <th>Price</th>
                        <th>Home Address</th>
                        <th>Book Status</th>
                        <th>Full Name</th>
                        <th>Phone number</th>
                        <th>Email Address</th>
                        <th>Date Posted</th>
                    </thead>
                    <tbody id="plan_data"></tbody>
                </table>
            </div>
    </div>
</div>



<!-- /PLAN LIST -->


<script src="../Component/jquery.min.js"></script>
<script src="../materialize/js/materialize.min.js"></script>
<script src="../node_modules/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
        $('.modal').modal({
        inDuration: 300,
        outDuration:200
        });
        $('.sidenav').sidenav();
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoClose: true
        });
        $('input:text').attr('autocomplete','off');
        load_plan_list();
        $('#checkbox_control button').attr('disabled',true);
        $('#user_control button').attr('disabled',true);
        load_stat();
        count_pending();
        setInterval(count_pending,5000); // REALTIME
        setInterval(load_stat,10000); // REALTIME
    });

    const load_stat = () =>{
        $.ajax({
            url: '../process/admin_function.php',
            type: 'POST',
            cache: false,
            data:{
                method: 'stats'
            },success:function(data){
                console.log(data);
                var stat = data.split('==');
                $('#total_seller').html(stat[0]);
                $('#total_buyer').html(stat[1]);
                $('#total_property').html(stat[2]);
            }
        });
    }

    const load_plan_list =()=>{
        var dateFrom = document.getElementById('date_from').value;
        var dateTo = document.getElementById('date_to').value;
        var partsCode = document.getElementById('partscode_search').value;
        var shiftCode = document.getElementById('shift_search').value;
            $.ajax({
                url:'../process/admin_function.php',
                type: 'POST',
                cache:false,
                data:{
                    method:'displayPlanList',
                    dateFrom:dateFrom,
                    dateTo:dateTo,
                    partsCode:partsCode,
                    shiftCode:shiftCode
                },success:function(response){
                    $('#plan_data').html(response);
                }
            });
    }

    const get_plan_del =(param)=>{
        var data = param.split('~!~');
        // console.log(param);
        document.getElementById('propertyID').value = data[0];
        document.getElementById('propowner').innerHTML = data[1];
        document.getElementById('propname').innerHTML = data[2];
        document.getElementById('propdesc').innerHTML = data[3];
        document.getElementById('prop_price').innerHTML = data[4];
        document.getElementById('prop_address').innerHTML = data[5];
        document.getElementById('rent_stat').innerHTML = data[6];
        document.getElementById('image_prop_view').innerHTML = '<img src="'+ data[7] +'" class="responsive-img" style="width:25%;"/>';
    }

    const delete_plan_admin =()=>{
        var id = document.getElementById('propertyID').value;
        var x = confirm("CONFIRM DELETE, CLICK OK TO PROCEED");
        if(x == true){
            // console.log("del");
            $('#delPlanBtn').attr('disabled',true);
            $('#delPlanBtn').html('Deleting...');
            $.ajax({
               url: '../process/admin_function.php' ,
               type: 'POST',
               cache:false,
               data:{
                   method:'delete_prop',
                    id:id
               },success:function(response){
                $('#delPlanBtn').attr('disabled',false);
                $('#delPlanBtn').html('Delete');
                $('.modal').modal('close','#plan_menu_admin');
                load_plan_list();
               }
            });
        }else{
            // CANCELLED
        }
    }

    function export_plan(table_id, separator = ',') {
    var rows = document.querySelectorAll('table#' + table_id + ' tr');
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
    var filename = 'BOOKAHOLIC_PROPERTY'+ '_' + new Date().toLocaleDateString() + '.csv';
    var link = document.createElement('a');
    link.style.display = 'none';
    link.setAttribute('target', '_blank');
    link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// function export_masterlist(table_id, separator = ',') {
//     var rows = document.querySelectorAll('table#' + table_id + ' tr');
//     var csv = [];
//     for (var i = 0; i < rows.length; i++) {
//         var row = [], cols = rows[i].querySelectorAll('td, th');
//         for (var j = 0; j < cols.length; j++) {
//             var data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ')
//             data = data.replace(/"/g, '""');
//             row.push('"' + data + '"');
//         }
//         csv.push(row.join(separator));
//     }
//     var csv_string = csv.join('\n');
//     // Download it
//     var filename = 'BOOKAHOLIC_FOR_APPROVAL'+ '_' + new Date().toLocaleDateString() + '.csv';
//     var link = document.createElement('a');
//     link.style.display = 'none';
//     link.setAttribute('target', '_blank');
//     link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv_string));
//     link.setAttribute('download', filename);
//     document.body.appendChild(link);
//     link.click();
//     document.body.removeChild(link);
// }
const load_masterlist =()=>{
    var keyword = document.querySelector('#searchKey').value;
    $.ajax({
        url: '../process/admin_function.php',
        type: 'POST',
        cache:false,
        data:{
            method: 'load_masterlist_admin',
            keyword:keyword
        },success:function(response){
            $('#masterData').html(response);
            get_checked_length();
        }
    });
    
}
const saveItem =()=>{
    var partscode = $('#new_partcode').val();
    var partsname = $('#new_partname').val();
    var packing = $('#new_packingQty').val();
    var qrCode = $('#new_qrcode').val();
    if(partscode == ''){
        swal('Enter Parts Code!','','info');
    }else if(partsname == ''){
        swal('Enter Parts Name!','','info');
    }else if(packing == ''){
        swal('Enter Packing Quantity!','','info');
    }else if(packing < 0){
        swal('Invalid Packing Quantity!','','info');
    }else{
        document.querySelector('#saveMasterBtn').disabled = true;
        document.querySelector('#saveMasterBtn').innerHTML = 'SAVING...';
        $.ajax({
        url:'../process/admin_function.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'add_part',
            partscode:partscode,
            partsname:partsname,
            packing:packing,
            qrCode:qrCode
        },success:function(response){
            if(response == 'success'){
                clear();
                // $('.modal').modal('close','#create-master-item');
                swal('Success!','','success');
                load_masterlist();
            }else{
                swal('Error!','','error');
            }
            document.querySelector('#saveMasterBtn').disabled = false;
            document.querySelector('#saveMasterBtn').innerHTML = 'SAVE';
        }
        });
    }
}

const clear =()=>{
    $('#new_partcode').val('');
    $('#new_partname').val('');
    $('#new_packingQty').val('');
    $('#new_qrcode').val('');
}

// CHECK ALL CHECKBOX
const select_all_master =()=>{
    var all_button = document.getElementById('selectmaster_all');
    if(all_button.checked == true){
        $('.singleCheckMaster').each(function(){
            this.checked = true;
        });
    }else{
        $('.singleCheckMaster').each(function(){
            this.checked = false;
        });
    }
    get_checked_length();
}

// GET THE LENGTH OF CHECKED CHECKBOXES
const get_checked_length =()=>{
    var checkedArr = [];
    $('input.singleCheckMaster:checkbox:checked').each(function(){
        checkedArr.push($(this).val());
    });
    var number_of_selected = checkedArr.length;
    // console.log(number_of_selected);
    if(number_of_selected > 0){
        // $('#checkbox_control').fadeIn(500);
        $('#checkbox_control button').attr('disabled',false);
    }else{
        $('#checkbox_control button').attr('disabled',true);
    }
}

const uncheck_all =()=>{
    var select_all = document.getElementById('selectmaster_all');
    select_all.checked = false;
    $('.singleCheckMaster').each(function(){
        this.checked=false;
    });
    get_checked_length();
}

// GET VALUES TO DELETE
const get_masterlist_value =()=>{
    var arrID = [];
    $('input.singleCheckMaster:checkbox:checked').each(function(){
        arrID.push($(this).val());
    });
    var validateSelect = arrID.length;
    if(validateSelect > 0){
        var x = confirm('CONFIRM DELETE. PLEASE CLICK OK!');
        if(x == true){
            // console.log('confirm');
            $('#checkbox_control button').attr('disabled',true);
            $.ajax({
                url: '../process/admin_function.php',
                type: 'POST',
                cache: false,
                data:{
                    method: 'delete_kanban_master_item',
                    arrID:arrID
                },success:function(response){
                    if(response == 'done'){
                        swal('SUCCESSFULLY DELETED!','','success');
                        load_masterlist();
                    }else{
                        swal('Error','','error');
                    }
                    get_checked_length();
                }
            });
        }else{
            // DO NOTHING
        }
    }else{
        swal('NO ITEM IS SELECTED','','info');
    }
}

const load_users =()=>{
    var userSearch = document.querySelector('#searchUser').value;
    var acc_type = document.querySelector('#acc_role').value;
    $.ajax({
        url: '../process/admin_function.php',
        type:'POST',
        cache: false,
        data:{
            method: 'fetch_users',
            userSearch:userSearch,
            acc_type:acc_type
        },success:function(response){
            document.querySelector('#userData').innerHTML = response;
            get_user_select();
        }
    });
}

const select_all_user =()=>{
    var thisbutton = document.querySelector('#check_all_user');
    if(thisbutton.checked == true){
        $('.singleCheckUser').each(function(){
            this.checked = true;
        });
    }else{
        $('.singleCheckUser').each(function(){
            this.checked = false;
        });
    }
    get_user_select();
}

const get_user_select =()=>{
    var checkedArr = [];
    $('input.singleCheckUser:checkbox:checked').each(function(){
        checkedArr.push($(this).val());
    });
    console.log(checkedArr);
    var number_of_selected = checkedArr.length;
    // console.log(number_of_selected);
    if(number_of_selected > 0){
        $('#user_control button').attr('disabled',false);
    }else{
        $('#user_control button').attr('disabled',true);
    }
}

const uncheck_all_user =()=>{
    var select_all = document.getElementById('check_all_user');
    select_all.checked = false;
    $('.singleCheckUser').each(function(){
        this.checked=false;
    });
    get_user_select();
}


const saveUser =()=>{
    var userid = $('#addUserID').val();
    var passwd = $('#addPassword').val();
    var fname = $('#addFname').val();
    var lname = $('#addLname').val();
    var phone = $('#addPhone').val();
    var usertype = $('#addUsertype').val();
    if(userid == '' || passwd == '' || fname == '' || lname == '' || phone == '' || usertype == ''){
        swal('Please complete all fields!','','info');
    }else{
        document.querySelector('#saveUserBtn').disabled = true;
        document.querySelector('#saveUserBtn').innerHTML = 'SAVING...';
        $.ajax({
            url: '../process/admin_function.php',
            type: 'POST',
            cache: false,
            data:{
                method: 'addUser',
                userid:userid,
                passwd:passwd,
                fname:fname,
                lname:lname,
                phone:phone,
                usertype:usertype
            },success:function(response){
                console.log(response);
                if(response == 'exists'){
                    swal('User already exists!','','info');
                }else if(response == 'save'){
                    swal('User added successfully!','','info');
                    load_users();
                    clear_add();
                }else{
                    swal('User failed to add!','','info');
                }
                document.querySelector('#saveUserBtn').disabled = false;
                document.querySelector('#saveUserBtn').innerHTML = 'SAVE';
            }
        });
    }
}

const get_to_delete_user =()=>{
    var userArray = [];
    $('input.singleCheckUser:checkbox:checked').each(function(){
        userArray.push($(this).val());
    });
    console.log(userArray);
    var val_selected_user = userArray.length;
    if(val_selected_user > 0){
        var x = confirm("Click OK to confirm deletion!");
        if(x == true){
            // DELETE AJAX
            $('#user_control button').attr('disabled',true);
            $.ajax({
                url: '../process/admin_function.php',
                type: 'POST',
                cache: false,
                data:{
                    method: 'deleteUser',
                    userArray:userArray
                },success:function(response){
                   if(response == 'done'){
                    swal('SUCCESSFULLY DELETED!','','info');
                    load_users();
                   }else{
                       swal('Error to delete!','','info');
                   }
                   get_user_select();
                }
            });
        }else{
            // DO NOTHING
        }
    }else{
        swal('NO USER IS SELECTED','','info');
    }
}


const clear_add =()=>{
    document.querySelector('#addUserID').value = '';
    document.querySelector('#addPassword').value = '';
    document.querySelector('#addFname').value = '';
    document.querySelector('#addLname').value = '';
    document.querySelector('#addPhone').value = '';
    document.querySelector('#addUsertype').selectedIndex = 0;
}

const get_data_user =(param)=>{
   var string = param.split('~!~');
   document.querySelector('#recordID').value = string[0];
   document.querySelector('#edit_userid').value = string[1];
   document.querySelector('#edit_password').value = "";
   document.querySelector('#edit_fname').value = string[3];
   document.querySelector('#edit_lname').value = string[4];
   document.querySelector('#edit_user_type').value = string[5];
}

const update_user =()=>{
    var ref_id = document.querySelector('#recordID').value;
    var new_userid = document.querySelector('#edit_userid').value;
    var new_password = document.querySelector('#edit_password').value;
    var new_fname = document.querySelector('#edit_fname').value;
    var new_lname = document.querySelector('#edit_lname').value;
    var new_usertype = document.querySelector('#edit_user_type').value;
    if(new_userid == '' || new_password =='' || new_fname == '' || new_lname == '' || new_usertype == ''){
        swal('Please complete all the fields!','','info');
    }else{
        // AJAX
        document.querySelector('#update_user_btn').disabled = true;
        $.ajax({
            url: '../process/admin_function.php',
            type: 'POST',
            cache: false,
            data:{
                method: 'update_user',
                ref_id:ref_id,
                new_userid:new_userid,
                new_password:new_password,
                new_fname:new_fname,
                new_lname:new_lname,
                new_usertype:new_usertype
            },success:function(response){
                console.log(response);
                if(response == 'success'){
                    swal('UPDATED!','','success');
                    load_users();
                    clear_edits();
                }else{
                    swal('ERROR IN UPDATING!','','success');
                }
                document.querySelector('#update_user_btn').disabled = false;
            }
        });
    }
}

const clear_edits =()=>{
    document.querySelector('#recordID').value = '';
    document.querySelector('#edit_userid').value = '';
    document.querySelector('#edit_password').value = '';
    document.querySelector('#edit_fullname').value = '';
    document.querySelector('#edit_user_type').selectedIndex = 0;
}



const load_for_approve = () =>{
    var log_from = document.querySelector('#log_from').value;
    var log_to = document.querySelector('#log_to').value;
    var key = document.querySelector('#keywordHistory').value;
    $.ajax({
        url: '../process/admin_function.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'for_approval',
            log_from:log_from,
            log_to:log_to,
            key:key
        },success:function(response){
            // console.log(response);
            document.querySelector('#history_data_output').innerHTML = response;
        }
    });
}

function count_pending(){
    $.ajax({
        url: '../process/admin_function.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'count_pending',
        },success:function(response){
            // console.log(response);
            $('#apprCount').html(response);
        }
    });
}

const load_admin_user = () =>{
    var search_admin = $('#searchAdmin').val();
    $.ajax({
        url: '../process/admin_function.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'fetch_admin',
            search_admin:search_admin,
        },success:function(data){
            $('#adminData').html(data);
        }
    });
}

const get_admin = (param) =>{
    // console.log(param);
    var dt = param.split('~!~');
    $('#adminID').val(dt[0]);
    $('#admin_userID').val(dt[1]);
    $('#admin_pass').val('');
    $('#admin_name').val(dt[3]);
}

function update_admin(){
    var id = $('#adminID').val();
    var userid = $("#admin_userID").val();
    var pass = $('#admin_pass').val();
    var name = $('#admin_name').val();
    if(userid == '' || pass == '' || name == ''){
        swal('PLEASE COMPLETE ALL THE FIELDS!','','info');
    }else{
        $.ajax({
            url: '../process/admin_function.php',
            cache: false,
            type: 'POST',
            data:{
                method: 'update_admin',
                id:id,
                userid:userid,
                pass:pass,
                name:name
            },success:function(response){
                // console.log(response);
                if(response == 'done'){
                    swal('SUCESSFULLY UPDATED!','','info');
                }else{
                    swal('FAIL TO UPDATE!','','info');
                }
            }
        });
    }
}

function delete_admin(){
    var id = $('#adminID').val();
    var x = confirm("TO DELETE, CLICK OK TO PROCEED!");
    if(x){
       $.ajax({
        url: '../process/admin_function.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'delete_admin',
            id:id,
        },success:function(res){
            // console.log(res);
            if(res =='del'){
                swal('DELETED!','','info');
                load_admin_user();
            }
        }
       });
    }
}

function get_for_approve(id){
    // console.log(id);
    $('#propID').val(id);
}

function approve_proper(){
    var id = $('#propID').val();
    $.ajax({
        url: '../process/admin_function.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'appr_prop',
            id:id
        },success:function(res){
            console.log(res);
            if(res == 1){
                swal('APPROVED SUCCESSFULLY!','','success');
                load_for_approve();
                load_plan_list();
            }else{
                swal('FAILED!','','info');
            }
        }
    });
}

function delete_proper(){
    var id = $('#propID').val();
    $.ajax({
        url: '../process/admin_function.php',
        type: 'POST',
        cache: false,
        data:{
            method: 'decline_prop',
            id:id
        },success:function(res){
            console.log(res);
            if(res == 1){
                swal('REMOVED SUCCESSFULLY!','','success');
            }else{
                swal('FAILED!','','info');
            }
        }
    });
}

const add_admin = () =>{
    var username = $('#admin_username').val();
    var password = $('#admin_password').val();
    var fullname = $('#admin_fullname').val();

    if(username === '' || password === '' || fullname === ''){
        swal('PLEASE COMPLETE ALL THE FIELDS!','','info');
    }else{
        $.ajax({
            url: '../process/admin_function.php',
            type: 'POST',
            cache: false,
            data: {
                method: 'add_admin',
                username:username,
                password:password,
                fullname:fullname
            },success:function(response){
                console.log(response);
                if(response == 'exists'){
                    swal('USERNAME ALREADY EXISTS!','','info');
                }else if(response == 'done'){
                    swal('SUCCESSFULLY ADDED NEW ADMIN ACCOUNT!','','success');
                    load_admin_user();
                    $('.modal').modal('close','#add_admin_modal');
                }else{
                    swal('FAILED!','','info');
                }
            }
        });
    }
}
</script>
</body>
</html>