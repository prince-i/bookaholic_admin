<?php
    include 'conn.php';
    require 'session.php';
    $method = $_POST['method'];
    if($method == 'displayPlanList'){
        $from = $_POST['dateFrom'];
        $to = $_POST['dateTo'];
        $partsCode = $_POST['partsCode'];
        $shiftCode = $_POST['shiftCode'];
        // QUERY
        $qry = "SELECT *FROM tbl_property WHERE prop_createdAt >='$from 00:00:00' AND prop_createdAt <= '$to 23:59:59' AND prop_name LIKE '$partsCode%' AND prop_status LIKE '$shiftCode%' ORDER BY prop_createdAt DESC";
        $stmt = $conn->prepare($qry);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $c = 0;
            foreach($stmt->fetchALL() as $x){
                $c++;
                $accID = $x['acc_id'];
                if(empty($x['prop_image'])){
                    $propImage = "NO IMAGE";
                }else{
                    $propImage = '<img src="'.$x['prop_image'].'" width=100px/>';
                }

                if($x['prop_status'] == 0){
                    $propStatus = 'PENDING TO POST';
                }elseif($x['prop_status'] == 1){
                    $propStatus = 'POSTED';
                }elseif($x['prop_status'] == 2){
                    $propStatus = 'SOLD';
                }elseif($x['prop_status'] == 3){
                    $propStatus = 'DELETED';
                }

                ## GET OWNER
                $getOwner = "SELECT DISTINCT* FROM tbl_accounts WHERE acc_id = '$accID'";
                $stmt=$conn->prepare($getOwner);
                $stmt->execute();
                foreach($stmt->fetchALL() as $o){
                    $owner = $o['acc_fname']." ".$o['acc_lname'];
                    $ownerEmail = $o['acc_email'];
                    $ownerMobile = $o['acc_phone'];
                }


                echo '<tr style="cursor:pointer;" class="modal-trigger" data-target="plan_menu_admin"
                    onclick="get_plan_del(&quot;'
                    .$x['prop_id'].'~!~'
                    .$owner.'~!~'
                    .$x['prop_name'].'~!~'
                    ."$ownerEmail / $ownerMobile".'~!~'
                    .$x['prop_price'].'~!~'
                    .$x['prop_address'].'~!~'
                    .$x['prop_isForRent'].'~!~'
                    .$x['prop_image']
                    .'&quot;)" >';
                echo '<td>'.$c.'</td>';
                echo '<td>'.$propImage.'</td>';
                echo '<td>'.$x['prop_name'].'</td>';
                echo '<td> ₱ '.$x['prop_price'].'</td>';
                echo '<td>'.$x['prop_address'].'</td>';
                echo '<td>'.$propStatus.'</td>';
                echo '<td>'.$owner.'</td>';
                echo '<td>'.$ownerMobile.'</td>';
                echo '<td>'.$ownerEmail.'</td>';
                echo '<td>'.$x['prop_createdAt'].'</td>';
                echo '</tr>';
            }
        }else{
            echo '<tr>';
            echo '<td colspan="12">NO DATA</td>';
            echo '</tr>';
        }
    }


    if($method == 'fetch_users'){
        $x = $_POST['userSearch'];
        $type = $_POST['acc_type'];

        $query = "SELECT *FROM tbl_accounts WHERE (acc_email LIKE '$x%' OR acc_fname LIKE '$x%' OR acc_lname LIKE '$x%') AND acc_role LIKE '$type%' ORDER BY acc_createdAt DESC";
        
        
        $stmt = $conn->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            foreach($stmt->fetchALL() as $x){

                if($x['acc_role'] == 1){
                    $userType = 'SELLER';
                }elseif($x['acc_role'] == 0){
                    $userType = 'BUYER';
                }

                echo '<tr >';
                echo '<td>
                <p>
                    <label>
                        <input type="checkbox" name="" id="checkUser" class="singleCheckUser" value="'.$x['acc_id'].'" onclick="get_user_select()">
                        <span></span>
                    </label>
                </p>    
                </td>';
                echo '<td class="modal-trigger" data-target="editusermodal" onclick="get_data_user(&quot;'.$x['acc_id'].'~!~'.$x['acc_email'].'~!~'.$x['acc_password'].'~!~'.$x['acc_fname'].'~!~'.$x['acc_lname'].'&quot;)" style="cursor:pointer;"><u>'.$x['acc_id'].
                '</u></td>';
                echo '<td class="modal-trigger" data-target="editusermodal" onclick="get_data_user(&quot;'.$x['acc_id'].'~!~'.$x['acc_email'].'~!~'.$x['acc_password'].'~!~'.$x['acc_fname'].'~!~'.$x['acc_lname'].'&quot;)" style="cursor:pointer;"><u>'.$x['acc_email'].'</u></td>';
                
                '</td>';
                echo '<td>'.$x['acc_fname']." ".$x['acc_lname'].
                '</td>';
                 echo '<td>'.$userType.'</td>';
                echo '<td>'.$x['acc_createdAt'].
                '</td>';
                echo '</tr>';
            }
        }else{
            echo '<tr>';
            echo '<td colspan="7">NO DATA</td>';
            echo '</tr>';
        }
    }

    if($method == 'addUser'){
        $userID = $_POST['userid'];
        $password = $_POST['passwd'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $phone = $_POST['phone'];
        $usertype = $_POST['usertype'];

        ## GENERATE OTP
        $otp = mt_rand(100000,999999);

        ## VERIFIED DEFAULT 
        $verfied = 0;

        ## PASSWORD CRYPT

        function generateSalt($len){
            $urs=md5(uniqid(mt_rand(), true));
            $b64String=base64_encode($urs);
            $mb64String=str_replace('+','.', $b64String);
            return substr($mb64String, 0, $len);
        }

        $hashFormat = "$2y$10$";
        $saltLength = 22;
        $salt = generateSalt($saltLength);
        $password = crypt($password,$hashFormat.$salt);


        ## CHECK USER ID IF EXISTS
        $query = "SELECT *FROM tbl_accounts WHERE acc_email =  '$userID'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            echo 'exists';
        }else{
            // INSERT TO DB
            $save = "INSERT INTO tbl_accounts (`acc_email`,`acc_password`,`acc_fname`,`acc_lname`,`acc_phone`,`acc_role`,`acc_otp`) VALUES ('$userID','$password','$fname','$lname','$phone','$usertype','$otp')";
            $stmt = $conn->prepare($save);
            if($stmt->execute()){
                echo 'save';
            }else{
                echo 'fail';
            }
        }
    }

    if($method == 'deleteUser'){
        $users = [];
        $users = $_POST['userArray'];
        // COUNT ALL USERS TO DELETE
        $selectedUser = count($users);
        foreach($users as $x){
           $sql = "DELETE FROM tbl_accounts WHERE acc_id = '$x'";
           $stmt = $conn->prepare($sql);
           if($stmt->execute()){
            //    EVERY SUCCESSFUL QUERY DEDUCT THE USER COUNT INSIDE THE ARRAY
               $selectedUser = $selectedUser - 1;
           }
        }
        if($selectedUser == 0){
            echo 'done';
        }else{
            echo 'error';
        }
    }

    if($method == 'update_user'){
        $id = $_POST['ref_id'];
        $userid = $_POST['new_userid'];
        $password = $_POST['new_password'];
        $fname = $_POST['new_fname'];
        $lname = $_POST['new_lname'];
        $usertype = $_POST['new_usertype'];


        ## ENCRYPT PASSWORD
          function generateSalt($len){
            $urs=md5(uniqid(mt_rand(), true));
            $b64String=base64_encode($urs);
            $mb64String=str_replace('+','.', $b64String);
            return substr($mb64String, 0, $len);
        }

        $hashFormat = "$2y$10$";
        $saltLength = 22;
        $salt = generateSalt($saltLength);
        $password = crypt($password,$hashFormat.$salt);

        ##

        $sql = "UPDATE tbl_accounts SET acc_email ='$userid', acc_password ='$password', acc_fname = '$fname', acc_lname = '$lname', acc_role = '$usertype' WHERE acc_id = '$id'";
        $stmt = $conn->prepare($sql);
        if($stmt->execute()){
            echo 'success';
        }else{
            echo 'fail';
        }
    }
    if($method == 'output_history'){
        $log_from = $_POST['log_from'];
        $log_to = $_POST['log_to'];
        $search = $_POST['history_key'];
        // SELECT QUERY
        $sql = "SELECT log_detail,date_log FROM tb_history_logs WHERE date_log >= '$log_from 00:00:00' AND date_log<= '$log_to 23:59:59' AND log_detail LIKE '%$search%'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $c = 0;
        if($stmt->rowCount() > 0){
            foreach($stmt->fetchAll() as $x){
                $c = $c + 1;
                echo '<tr>';
                echo '<td>'.$c.'</td>';
                echo '<td>'.$x['log_detail'].'</td>';
                echo '<td>'.$x['date_log'].'</td>';
                echo '</tr>';
            }
        }
    }

    if($method == 'delete_prop'){
        $id = $_POST['id'];
        $sql  = "UPDATE `tbl_property` SET prop_status = 3 WHERE prop_id = '$id'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    if($method == 'stats'){
        ## GET BUYER AND SELLER
        $GETUSER = "SELECT DISTINCT COUNT(IF(acc_role = 1,1,NULL)) AS seller,
                                    COUNT(IF(acc_role =0,1,NULL)) AS buyer 
                                    FROM tbl_accounts";
        $stmt = $conn->prepare($GETUSER);
        $stmt->execute();
        foreach($stmt->fetchall() as $x){
             $seller = $x['seller'];
             $buyer = $x['buyer'];
        }

        ## GET TOTAL COUNT OF PROPERTY
        $GET_PROP = "SELECT COUNT(prop_id) AS property FROM tbl_property";
        $stmt = $conn->prepare($GET_PROP);
        $stmt->execute();
        foreach($stmt->fetchall() as $x){
            $property = $x['property'];
        }
        ## DATA
        echo "$seller==$buyer==$property";
    }

    if($method == 'fetch_admin'){
        $search = $_POST['search_admin'];
        $type = $_POST['search_type'];
        $adminQL = "SELECT *FROM tbl_admin WHERE (userid LIKE '$search%' OR full_name LIKE '$search%') AND user_type LIKE '$type%'";
        $stmt = $conn->prepare($adminQL);
        $stmt->execute();
        foreach($stmt->fetchall() as $x){
               echo '<tr onclick="get_admin(&quot;'.$x['id'].'~!~'.$x['userid'].'~!~'.$x['password'].'~!~'.$x['full_name'].'&quot;)" data-target="edit_admin" class="modal-trigger" style="cursor:pointer;">';
                echo '<td>'.$x['userid'].'</td>';
                echo '<td>'.$x['full_name'].'</td>';
                echo '<td>'.$x['user_type'].'</td>';
                echo '</tr>';
        }
    }


    if($method == 'update_admin'){
        $id = $_POST['id'];
        $userid = $_POST['userid'];
        $pass = $_POST['pass'];
        $pass = md5($pass);
        $name = $_POST['name'];
        $sql = "UPDATE tbl_admin SET userid = '$userid',password = '$pass', full_name = '$name' WHERE id = '$id'";
        $stmt = $conn->prepare($sql);
        if($stmt->execute()){
            echo "done";
        }else{
            echo "fail";
        }
    }

    if($method == "delete_admin"){
        $id = $_POST['id'];
        $delQL = "DELETE FROM tbl_admin WHERE id = '$id'";
        $stmt = $conn->prepare($delQL);
        if($stmt->execute()){
            echo "del";
        }else{
            echo "fail";
        }
    }

    if($method == 'for_approval'){
        $from = $_POST['log_from'];
        $to = $_POST['log_to'];
        $key = $_POST['key'];

        ## QUERY
        if(empty($from) || empty($to)){
            $qry ="SELECT *FROM tbl_property WHERE prop_name LIKE '$key%' AND prop_status = 0 ORDER BY prop_createdAt DESC";
        }else{
            $qry = "SELECT *FROM tbl_property WHERE prop_createdAt >='$from 00:00:00' AND prop_createdAt <= '$to 23:59:59' AND prop_name LIKE '$key%' AND prop_status = 0 ORDER BY prop_createdAt DESC";
        }
        
        $stmt = $conn->prepare($qry);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $c = 0;
            foreach($stmt->fetchALL() as $x){
                $c++;
                $accID = $x['acc_id'];

                ## GET OWNER
                $getOwner = "SELECT DISTINCT* FROM tbl_accounts WHERE acc_id = '$accID'";
                $stmt=$conn->prepare($getOwner);
                $stmt->execute();
                foreach($stmt->fetchALL() as $o){
                    $owner = $o['acc_fname']." ".$o['acc_lname'];
                    $ownerEmail = $o['acc_email'];
                    $ownerMobile = $o['acc_phone'];
                }

                if($x['prop_status'] == 0){
                    $propStatus = 'PENDING TO POST';
                }elseif($x['prop_status'] == 1){
                    $propStatus = 'POSTED';
                }elseif($x['prop_status'] == 2){
                    $propStatus = 'SOLD';
                }elseif($x['prop_status'] == 3){
                    $propStatus = 'DELETED';
                }


                // echo '<tr style="cursor:pointer;" class="modal-trigger" data-target="approved_prop"
                //     onclick="get_for_approve(&quot;'
                //     .$x['prop_id']
                //     .'&quot;)" >';
                echo '<td>
                    <p>
                        <label>
                            <input type="checkbox" name="" id="checkApproval" class="singleCheckApproval" value="'.$x['prop_id'].'" onclick="get_approval_select()">
                            <span></span>
                        </label>
                    </p>    
                    </td>';
                echo '<td style="text-align:center;">'.$c.'</td>';
                echo '<td style="text-align:center;">'.$x['prop_name'].'</td>';
                echo '<td style="text-align:center;"> ₱ '.$x['prop_price'].'</td>';
                echo '<td style="text-align:center;">'.$x['prop_address'].'</td>';
                echo '<td style="text-align:center;">'.$propStatus.'</td>';
                echo '<td style="text-align:center;">'.$owner.'</td>';
                echo '<td style="text-align:center;">'.$ownerMobile.'</td>';
                echo '<td style="text-align:center;">'.$ownerEmail.'</td>';
                echo '<td style="text-align:center;">'.$x['prop_createdAt'].'</td>';
                echo '</tr>';
            }
        }else{
            echo '<tr>';
            echo '<td colspan="11" class="center">NO DATA</td>';
            echo '</tr>';
        }
    }

    if($method == 'count_pending'){
        $sql = "SELECT COUNT(prop_id) as c FROM tbl_property WHERE prop_status = 0";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchALL();
        foreach($res as $x){
            echo $x['c'];
        }
    }



    if($method == 'add_admin'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $fullname = $_POST['fullname'];
        $password = md5($password);
        $type = $_POST['type'];

        ## CHECK USERNAME IF IN USE
        $sql = "SELECT id FROM tbl_admin WHERE userid = '$username'";
        $stmt =  $conn->prepare($sql);
        $stmt->execute();
        $stmt->fetchALL();
        $count = $stmt->rowCount();
        if($count > 0){
            ## EXISTS
            echo 'exists';
        }else{
            ## INSERT
            $insert  = "INSERT INTO tbl_admin (`userid`,`password`,`full_name`,`user_type`) VALUES ('$username','$password','$fullname','$type')";
            $stmt = $conn->prepare($insert);
            if($stmt->execute()){
                echo 'done';
            }else{
                echo 'fail';
            }
        }
    }

    if($method == 'appointments'){
        $customer = $_POST['app_customer'];
        $property = $_POST['app_property'];
        $status = $_POST['app_status'];
        $from = $_POST['date_from'];
        $to = $_POST['date_to'];


        $SQL = "SELECT CONCAT(tbl_accounts.acc_fname,' ',tbl_accounts.acc_lname) AS NAME,tbl_accounts.acc_email AS EMAIL,tbl_accounts.acc_phone AS PHONE, tbl_property.prop_image AS PROP_IMG, tbl_property.prop_name AS PROPNAME, tbl_property.prop_price AS PROP_PRICE, 
        (SELECT CONCAT(tbl_accounts.acc_fname,' ',tbl_accounts.acc_lname) FROM tbl_accounts WHERE acc_id = tbl_appointment.id_acc LIMIT 1) AS SELLER,
        (SELECT tbl_accounts.acc_email FROM tbl_accounts WHERE acc_id = tbl_appointment.id_acc LIMIT 1) AS SELLER_EMAIL,
        (SELECT tbl_accounts.acc_phone FROM tbl_accounts WHERE acc_id = tbl_appointment.id_acc LIMIT 1) AS SELLER_PHONE,
        tbl_appointment.app_date as APP_DATE, tbl_appointment.app_time as APP_TIME,tbl_appointment.app_status AS APPOINT_STAT FROM tbl_appointment LEFT JOIN tbl_property ON tbl_appointment.prop_id = tbl_property.prop_id LEFT JOIN tbl_accounts ON tbl_accounts.acc_id = tbl_appointment.acc_id  WHERE CONCAT(tbl_accounts.acc_fname,' ',tbl_accounts.acc_lname) LIKE '$customer%' AND (tbl_appointment.app_date >= '$from' AND tbl_appointment.app_date <= '$to')
        AND tbl_appointment.app_status LIKE '$status%' AND tbl_property.prop_name LIKE '$property%' ORDER BY CONCAT(tbl_appointment.app_date,' ',tbl_appointment.app_time) DESC";


        $stmt = $conn->prepare($SQL);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $c = 0;
            foreach($stmt->fetchALl() as $x){
                $c++;
                $time_ = explode("T",$x['APP_TIME']);
                $time = $time_[1];
                $time = substr($time,0,8);
                $status = $x['APPOINT_STAT'];
                if($status == '0'){
                    $status_ = 'PENDING APPROVAL';
                }
                if($status == '1'){
                    $status_ = 'APPROVED TRANSACTION';
                }
                if($status == '2'){
                    $status_ = 'DECLINED TRANSACTION';
                }
                if($status == '3'){
                    $status_ = 'HISTORY TRANSACTION';
                }

                if($status == '4'){
                    $status_ = 'SUCCESS TRANSACTION';
                }

                echo '<tr>';
                echo '<td>'.$c.'</td>';
                echo '<td>'.$x['NAME'].'</td>';
                echo '<td>'.$x['EMAIL'].'</td>';
                echo '<td>'.$x['PHONE'].'</td>';
                echo '<td><img src="'.$x['PROP_IMG'].'" class="responsive-img"/></td>';
                echo '<td>'.$x['PROPNAME'].'</td>';
                echo '<td>'.$x['PROP_PRICE'].'</td>';
                echo '<td>'.$x['SELLER'].'</td>';
                echo '<td>'.$x['SELLER_EMAIL'].'</td>';
                echo '<td>'.$x['SELLER_PHONE'].'</td>';
                echo '<td>'.$x['APP_DATE'].'</td>';
                echo '<td>'.$time.'</td>';
                echo '<td>'.$status_.'</td>';
              
                echo '</tr>';
            }
        }
    }


    if($method == 'checkouts'){
        $customer = $_POST['co_customer'];
        $prop_co = $_POST['prop_co'];
        $status = $_POST['status'];

      

        $query = "SELECT tbl_checkout.co_id AS CO_ID, CONCAT(tbl_accounts.acc_fname,' ',tbl_accounts.acc_lname) AS NAME,tbl_accounts.acc_email AS EMAIL,tbl_accounts.acc_phone AS PHONE, tbl_checkout.co_image AS CO_IMG, tbl_property.prop_name AS PROPNAME, tbl_property.prop_price AS PROP_PRICE,
        (SELECT CONCAT(tbl_accounts.acc_fname,' ',tbl_accounts.acc_lname) FROM tbl_accounts WHERE acc_id = tbl_checkout.id_acc LIMIT 1) AS SELLER,
        (SELECT tbl_accounts.acc_email FROM tbl_accounts WHERE acc_id = tbl_checkout.id_acc LIMIT 1) AS SELLER_EMAIL,
        (SELECT tbl_accounts.acc_phone FROM tbl_accounts WHERE acc_id = tbl_checkout.id_acc LIMIT 1) AS SELLER_PHONE,
        tbl_checkout.co_loc AS LOCATION, tbl_checkout.co_landmark AS LANDMARK, tbl_checkout.co_special AS SPECIAL, tbl_checkout.co_comment AS COMMENT, tbl_checkout.co_comment_approve AS APPROVE_COMMENT, tbl_checkout.co_status AS CHK_STATUS, tbl_checkout.co_decline AS DECLINE, tbl_checkout.co_approve AS APPROVE, tbl_checkout.co_review AS REVIEW, tbl_checkout.co_cancel AS CANCEL, tbl_checkout.co_payment AS PAYMENT FROM tbl_checkout LEFT JOIN tbl_property ON tbl_checkout.prop_id = tbl_property.prop_id LEFT JOIN tbl_accounts ON tbl_accounts.acc_id = tbl_checkout.acc_id  WHERE CONCAT(tbl_accounts.acc_fname,' ',tbl_accounts.acc_lname) LIKE '$customer%' AND tbl_property.prop_name LIKE '$prop_co%' AND tbl_checkout.co_status LIKE '$status%' ORDER BY tbl_checkout.co_id DESC";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        if($stmt->rowCount()){
            $c =0;
            foreach($stmt->fetchALL() as $x){
                $c++;
                $status = $x['CHK_STATUS'];
                if($status == '0'){
                    $stat = 'PENDING ORDER';
                }
                if($status == '1'){
                    $stat = 'TO PAY';
                }
                if($status == '2'){
                    $stat = 'CANCELLED ORDER';
                }

                if($status == '3'){
                    $stat = 'DELIVERED';
                }
                if($status == '4'){
                    $stat = 'TO DELIVER';
                }
                if($status == '5'){
                    $stat = 'COMPLETED';
                }
                if($status == '6'){
                    $stat = 'TO PROCESS';
                }
                if($status == '7'){
                    $stat = 'PAID';
                }
                if($status == '8'){
                    $stat = 'PENDING CANCELLATION';
                }
                echo '<tr onclick="get_checkout_data(&quot;'.
                $x['CO_ID'].'~!~'.
                $x['CHK_STATUS'].'~!~'.
                $x['NAME'].'~!~'.
                $x['EMAIL'].'~!~'.
                $x['PHONE'].'~!~'.
                $x['CO_IMG'].'~!~'.
                $x['PROPNAME'].'~!~'.
                $x['PROP_PRICE'].'~!~'.
                $x['SELLER'].'~!~'.
                $x['SELLER_EMAIL'].'~!~'.
                $x['SELLER_PHONE'].'~!~'.
                $x['LOCATION'].'~!~'.
                $x['LANDMARK'].'~!~'.
                '&quot;)" style="cursor:pointer;"
                class="modal-trigger" data-target="update_chk_out">';
                echo '<td>'.$c.'</td>';
                echo '<td>'.$x['NAME'].'</td>';
                echo '<td>'.$x['EMAIL'].'</td>';
                echo '<td>'.$x['PHONE'].'</td>';
                echo '<td><img src="'.$x['CO_IMG'].'" class="responsive-img" width="200"/></td>';
                echo '<td>'.$x['PROPNAME'].'</td>';
                echo '<td>'.$x['PROP_PRICE'].'</td>';
                echo '<td>'.$x['SELLER'].'</td>';
                echo '<td>'.$x['SELLER_EMAIL'].'</td>';
                echo '<td>'.$x['SELLER_PHONE'].'</td>';
                echo '<td>'.$x['LOCATION'].'</td>';
                echo '<td>'.$x['LANDMARK'].'</td>';
                echo '<td>'.$stat.'</td>';
                
                echo '</tr>';
            }
        }
    }


    if($method == 'update_chk'){
        $id = $_POST['id'];
        $stat = $_POST['new_stat'];
        $UPDATE =  "UPDATE tbl_checkout SET co_status = '$stat' WHERE co_id = '$id'";
        $stmt = $conn->prepare($UPDATE);
       if($stmt->execute()){
        echo "success";
       }else{
           echo "fail";
       }
        
    }

    if($method == 'approve_prop'){
        $prop = [];
        $prop = $_POST['approvalArray'];
        // COUNT ALL USERS TO DELETE
        $selectedUser = count($prop);
        foreach($prop as $x){
           $sql = "UPDATE `tbl_property` SET prop_status = 1 WHERE prop_id = '$x'";
           $stmt = $conn->prepare($sql);
           if($stmt->execute()){
            //    EVERY SUCCESSFUL QUERY DEDUCT THE USER COUNT INSIDE THE ARRAY
               $selectedUser = $selectedUser - 1;
           }
        }
        if($selectedUser == 0){
            echo 'done';
        }else{
            echo 'error';
        }
    }

    if($method == 'decline_prop'){
        $prop = [];
        $prop = $_POST['declineArray'];
        // COUNT ALL USERS TO DELETE
        $selectedUser = count($prop);
        foreach($prop as $x){
           $sql = "UPDATE `tbl_property` SET prop_status = 3 WHERE prop_id = '$x'";
           $stmt = $conn->prepare($sql);
           if($stmt->execute()){
            //    EVERY SUCCESSFUL QUERY DEDUCT THE USER COUNT INSIDE THE ARRAY
               $selectedUser = $selectedUser - 1;
           }
        }
        if($selectedUser == 0){
            echo 'done';
        }else{
            echo 'error';
        }
    }


    // if($method == 'appr_prop'){
    //     $id = $_POST['id'];
    //     ## PENDING TO POST --> POSTED
    //     $sql = "UPDATE `tbl_property` SET prop_status = 1 WHERE prop_id = '$id'";
    //     $stmt = $conn->prepare($sql);
    //     if($stmt->execute()){
    //         echo '1';
    //     }else{
    //         echo '0';
    //     }
    // }

    // if($method == 'decline_prop'){
    //     $id = $_POST['id'];
    //     $sql = "UPDATE `tbl_property` SET prop_status = 3 WHERE prop_id = '$id'";
    //     $stmt = $conn->prepare($sql);
    //     if($stmt->execute()){
    //         echo '1';
    //     }else{
    //         echo '0';
    //     }
    // }




    // KILL CONNECTION
    $conn = null;

?>