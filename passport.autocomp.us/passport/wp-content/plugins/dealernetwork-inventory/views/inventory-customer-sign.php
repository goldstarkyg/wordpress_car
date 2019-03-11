<?php
require_once("../../../../wp-load.php");


function my_function() {
    if(!session_id()) {
        session_start();
    }
    global $wpdb;
    $mode = $_POST['mode'];
    $current = date('Y-m-d H:i:s');
    //============sign up
    switch ($mode) {
      case 'signup' :
        
        $user_lgoin = $_POST['login'];
        $user_pass = md5($_POST['pass']);
        $user_nicename = $_POST['firstname'];
        $display_name = $_POST['lastname'];
        $user_email = $_POST['email'];


        $table = "wp_users";
        $result = $wpdb->insert(
            $table,
            array(
                'user_login' => $user_lgoin,
                'user_pass' => $user_pass,
                'user_nicename' => $user_nicename,
                'display_name' => $display_name,
                'user_email' => $user_email,
                'user_registered' =>$current
            )
        );
        $ret = array();
        if($result) {
            $ret['code'] = 200;
            $_SESSION['user']['firstname'] = $user_nicename ;
            $_SESSION['user']['lastname']= $display_name;
            $_SESSION['user']['email'] = $user_email ;  

            $storage = compareStorage();
            $ret['alert'] = $storage['alert'];
            $ret['saved'] = $storage['saved'];
            $ret['viewed'] = $storage['viewed'];
            $ret['list'] = $storage['list'];          
        }else {
            $ret['code'] = 202;
        }

        return json_encode($ret);
    break;
    //===========sign in
    case 'signin' :        

        $user_pass = md5($_POST['pass']);
        $user_email = $_POST['email'];
        $table = "wp_users";
        $user = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ".$table." WHERE user_email = %s and user_pass= %s", $user_email, $user_pass ) );
        $ret = array();
        if ( !$user ) {
            $ret['code'] = 202;           
        }else {            
            $ret['code'] = 200;
            $ret['user'] = $user;
            $_SESSION['user']['firstname'] = $user->user_nicename ;
            $_SESSION['user']['lastname']= $user->display_name;
            $_SESSION['user']['email'] = $user->user_email ;

            $storage = compareStorage();
            $ret['alert'] = $storage['alert'];
            $ret['saved'] = $storage['saved'];
            $ret['viewed'] = $storage['viewed'];
            $ret['list'] = $storage['list'];           
        }        

        return json_encode($ret);
    break;

    //=======forgot
    case 'frogot' :
        $toemail = $_POST['email'];
        $url = $_POST['url'];
        $username = "Gold";
        $fromemail = 'goldstarkyg91@gmail.com';
        $to = $toemail;
        $subject = 'Password reset request from PASSPORT';
        $from = $fromemail;
        $key= base64_encode('please reset password');
        

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

        // Create email headers
        $headers .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();


        $message = '<html lang="en"><body>';
        $message.= '<head><meta charset="UTF-8"></head>';
        $message .= '<h1 style="color:#f40;">Dear sir</h1>';
        $message .= '<p style="color:#080;font-size:18px;"> PASSPORT received a request to reset the password for your account registered with '.$toemail.'.</p>';
        $message .= '<p style="color:#080;font-size:18px;">To reset your password, click on the link below (or right click to copy and paste the URL into your browser):</p>';
        $message .= '<p style="color:#080;font-size:18px;"><a href="'.$url.'?a='.$key.'&b='.$toemail.'" target="_blank">Click to reset password</a></p>'; 
        $message .= '</body></html>';

        // Sending email
        $mailResult = false;
        $mailResult = wp_mail( $toemail, $subject, $message, $headers );    

        $ret = array();
        if($mailResult){
             $ret['code'] = 200;                
        } else{
                $ret['code'] = 202;                
        }
        echo json_encode($ret);    
     break;

    //========signout
    case 'signout' :
        unset($_SESSION['user']);
        $ret['code'] = 200;
        return json_encode($ret);
    break;
    //========saved_alert
    case 'saved_alert' :        
        if($mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)) {
            $email = $_POST['email'];            
            $stocknumber = $_POST['stocknumber'];            
            $inventory_id = $_POST['inventory_id'];
            $alert = $_POST['alert'];
            $price = $_POST['price'];
            
            //comapre price
            $sql = "SELECT * FROM `sold_list` where user_email='".$email."' and inventory_id='".$inventory_id."'";

            if ($result = $mysqli->query($sql)) {             
                while($row = $result->fetch_array(MYSQL_ASSOC)) {                    
                    $origin_price = $row['price'];                    
                    if($price != $origin_price) { //send email
                        add_filter( 'wp_mail_content_type','change_content_email' );
                        sendEmail($stocknumber, $price, $origin_price, $email);
                    }
                }
                $result->close();
            }
            
            
            $sql = "update sold_list set alert = '".$alert."'  where user_email='".$email."' and  inventory_id ='".$inventory_id."' ";    
            $mysqli->query($sql);                       

            if($alert == 'true') {
                //comapre registered price
            }    
            $list = array();
            $sql = "SELECT * FROM `sold_list` where user_email='".$email."'";

            $ret = array();    
            if ($result = $mysqli->query($sql)) {             
                while($row = $result->fetch_array(MYSQL_ASSOC)) { 
                    $list[] = $row;
                }
               $result->close();
            }
            $ret['code'] = 200;
            $ret['list'] = $list;
            echo json_encode($ret);           
            $mysqli->close();  
        }
     break;
    //=========saved_car
    case 'saved_car' :        
        if($mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)) {
            $email = $_POST['email'];
            $car = $_POST['car'];
            $inventory_id = $_POST['inventory_id'];
            $stocknumber = $_POST['stocknumber'];
            $price = $_POST['price'];
            $cond = '';

            $sql = "select * from `sold_saved` where `user_email` = ? and `inventory_id` = ? ";
            
            //find like email and inventroy
            if ($stmt = $mysqli->prepare($sql))
            {               
                $stmt->bind_param('ss', $email, $inventory_id);
                if ($stmt->execute())
                {
                    $stmt->store_result();

                    if ($stmt->num_rows < 1)
                    {
                       $cond = 'insert';
                    }else {
                       $cond = 'delete';
                    }                     
                    $stmt->free_result();
                }
                $stmt->close();
            }

            if($cond == 'delete' ) {                 
                  $sql = "delete  from `sold_saved`  where user_email= '".$email."' and inventory_id = '".$inventory_id."'";
                  $mysqli->query($sql);
                  $sql = "delete  from `sold_list`  where user_email= '".$email."' and inventory_id = '".$inventory_id."'";
                  $mysqli->query($sql);

            }else if($cond == 'insert') {                                                 
                  $created = date('Y-m-d H:i:s');        
                  $sql = "insert into `sold_saved`(user_email, inventory_id, car , created) values('".$email."', '".$inventory_id."', '".$car."', '".$created."')";                  
                  $mysqli->query($sql);
                  $sql = "insert into `sold_list`(user_email, inventory_id, save , alert,stocknumber, price) values('".$email."', '".$inventory_id."', 'true', 'true', '".$stocknumber."','".$price."')";                  
                  $mysqli->query($sql);           
            }

            $myArray = array();
            $saved = array();
            $sql = "SELECT * FROM `sold_saved` where user_email='".$email."'";

            if ($result = $mysqli->query($sql)) {             
                while($row = $result->fetch_array(MYSQL_ASSOC)) {                    
                    $cur_date = date_create(date('Y-m-d H:i:s'));
                    $saved_date = date_create($row['created']);
                    $diff = date_diff($cur_date,$saved_date);
                    $row['created'] = $diff;
                    $saved[] = $row;
                }
                $myArray['saved'] = $saved;
                $result->close();
            }

            $list = array();
            $sql = "SELECT * FROM `sold_list` where user_email='".$email."'";

            if ($result = $mysqli->query($sql)) {             
                while($row = $result->fetch_array(MYSQL_ASSOC)) { 
                    $list[] = $row;
                }
                $myArray['list'] = $list;
                $result->close();
            }
            echo json_encode($myArray);           
            $mysqli->close();  
        }
     break;

     //=========saved_car
    case 'update_price' :        
        if($mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)) {
            $email = $_POST['email'];
            $car = $_POST['car'];
            $inventory_id = $_POST['inventory_id'];
            $price = $_POST['price'];
            
            $sql = "update sold_list set price = '".$price."'  where user_email='".$email."' and  inventory_id ='".$inventory_id."' ";    
            $mysqli->query($sql); 

            $sql = "update sold_saved set car = '".$car."'  where user_email='".$email."' and  inventory_id ='".$inventory_id."' ";    
            $mysqli->query($sql); 

            $sql = "update sold_viewed set car = '".$car."'  where user_email='".$email."' and  inventory_id ='".$inventory_id."' ";    
            $mysqli->query($sql);            
            $mysqli->close(); 
                     
            $ret = array(); 
            $storage = compareStorage();
            $ret['alert'] = $storage['alert'];            
            $ret['saved'] = $storage['saved'];
            $ret['viewed'] = $storage['viewed'];
            $ret['list'] = $storage['list'];   
            return json_encode($ret);  
        }
     break;

     //=========viewed_car
     case 'viewed_car' :       
        if($mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)) {
            $email = $_POST['email'];
            $car = $_POST['car'];
            $inventory_id = $_POST['inventory_id'];
            $cond = $_POST['cond'];
            
            if($cond == 'delete' ) {                 
                 $sql = "delete  from `sold_viewed`  where user_email= '".$email."' and inventory_id = '".$inventory_id."'";
                  $mysqli->query($sql);

            }else if($cond == 'insert') {                                    
                  $created = date('Y-m-d H:i:s');        
                  $sql = "insert into `sold_viewed`(user_email, inventory_id, car , created) values('".$email."', '".$inventory_id."', '".$car."', '".$created."')";
                  $mysqli->query($sql);           
            }

            $myArray = array();
            $sql = "SELECT * FROM sold_viewed where user_email='".$email."'";
            if ($result = $mysqli->query($sql)) {
                while($row = $result->fetch_array(MYSQL_ASSOC)) {
                    $cur_date = date_create(date('Y-m-d H:i:s'));
                    $saved_date = date_create($row['created']);
                    $diff = date_diff($cur_date,$saved_date);
                    $row['created'] = $diff;
                    $myArray[] = $row;
                }
                echo json_encode($myArray);
            }
            $result->close();
            $mysqli->close();
        }
    break;
        
    //=======get_saved_car
    case 'get_saved_car' :
        if($mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)) {
            $email = $_POST['email'];
            $myArray = array();
            $sql = "SELECT * FROM sold_saved where user_email='".$email."'";
            if ($result = $mysqli->query($sql)) {
                while($row = $result->fetch_array(MYSQL_ASSOC)) {
                    $cur_date = date_create(date('Y-m-d H:i:s'));
                    $saved_date = date_create($row['created']);
                    $diff = date_diff($cur_date,$saved_date);
                    $row['created'] = $diff;
                    $myArray[] = $row;
                }
                echo json_encode($myArray);
            }
            $result->close();
            $mysqli->close();
        }
    break;

    //======get_viewed_car
    case 'get_viewed_car' :
        if($mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)) {
            $email = $_POST['email'];
            $myArray = array();
            $sql = "SELECT * FROM sold_viewed where user_email='".$email."'";
            if ($result = $mysqli->query($sql)) {
                while($row = $result->fetch_array(MYSQL_ASSOC)) {
                    $cur_date = date_create(date('Y-m-d H:i:s'));
                    $saved_date = date_create($row['created']);
                    $diff = date_diff($cur_date,$saved_date);
                    $row['created'] = $diff;
                    $myArray[] = $row;
                }
                echo json_encode($myArray);
            }
            $result->close();
            $mysqli->close();
        }
    break;  

    //=======all_saved_count
    case 'all_saved_count' :       
        if($mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)) {
            $inventory_id = $_POST['inventory_id'];           
            $myArray = array();
            $row_cnt = 0;
            $sql = "SELECT * FROM sold_saved where inventory_id='".$inventory_id."'";
            $result = $mysqli->query($sql) ;
            if($result) {
              $row_cnt = $result->num_rows; 
              $result->close();              
            }
            $mysqli->close();
            return $row_cnt;
        }
    break;

    //======delete_car
    case 'delete_car' :
        if($mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)) {
            $email = $_POST['email'];
            $inventory_id = $_POST['inventory_id'];
            $item = $_POST['item'];
            $myArray = array();  
            $table = '';
            if($item == 'saved') $table = 'sold_saved';
            if($item == 'viewed') $table = 'sold_viewed';          
            $sql = "delete FROM ".$table." where user_email='".$email."' and inventory_id ='".$inventory_id."'";
            $mysqli->query($sql);

            $List_saved_viewed = array();
            $sql = "SELECT * FROM ".$table." where user_email='".$email."'";
            if ($result = $mysqli->query($sql)) {
                while($row = $result->fetch_array(MYSQL_ASSOC)) {
                    $cur_date = date_create(date('Y-m-d H:i:s'));
                    $saved_date = date_create($row['created']);
                    $diff = date_diff($cur_date,$saved_date);
                    $row['created'] = $diff;
                    $List_saved_viewed[] = $row;
                }                
            }
            $result->close();
            /////////
            if($item == 'saved') {                
                $sql = "delete FROM  sold_list  where user_email='".$email."' and inventory_id ='".$inventory_id."'";
                $mysqli->query($sql);                
            }

            $storage = array(); 
            $myList = array();
            $sql = "SELECT * FROM sold_list where user_email='".$email."'";
            if ($result = $mysqli->query($sql)) {
                while($row = $result->fetch_array(MYSQL_ASSOC)) {                    
                    $myList[] = $row;
                }
            }
            $result->close();
            
            ///////
            
            $mysqli->close();

            $storage['code'] = 200;
            $storage['list'] = $myList;
            $storage[$item] = $List_saved_viewed;            
            
            echo json_encode($storage);
        }  
   break;      
  }
}
add_shortcode( 'testinsert', 'my_function');
echo do_shortcode("[testinsert]");

function compareStorage() {

     if($mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)) {
            $sql = 'CREATE TABLE if not exists `sold_saved` (`user_email` varchar(40) DEFAULT NULL, 
                        `inventory_id` varchar(20) DEFAULT NULL,
                        `car` longtext,
                        `created` datetime DEFAULT NULL)'; 
            $mysqli->query($sql);   

            $sql = 'CREATE TABLE if not exists `sold_viewed` (`user_email` varchar(40) DEFAULT NULL, 
                        `inventory_id` varchar(20) DEFAULT NULL,
                        `car` longtext,
                        `created` datetime DEFAULT NULL)'; 
            $mysqli->query($sql);                    
             
            $sql = "CREATE TABLE if not exists `sold_list`( `inventory_id` VARCHAR(20), `user_email` VARCHAR(50), `save` VARCHAR(10), `alert` VARCHAR(10), `stocknumber` VARCHAR(20), `price` VARCHAR(20)  )"; 
            $mysqli->query($sql);   

            $saved =  json_decode(stripslashes($_POST['saved']));
            $viewed = json_decode(stripslashes($_POST['viewed']));
            $list =  json_decode(stripslashes($_POST['list'])); 
            $user_email = $_POST['email'];

            $storage = array(); 
            $alertList = array();
            $sql = "SELECT * FROM sold_list where user_email='".$user_email."'";
            if ($result = $mysqli->query($sql)) {
                while($row = $result->fetch_array(MYSQL_ASSOC)) { 
                    $alertList[] = $row;
                }
                $storage['alert'] = $alertList;
            }
            $result->close();  

            $saved_array = array();
            foreach ((array)$saved as $val) {                  
                    $inventory_id = $val->InventoryID; 
                    $car = json_encode($val);

                    $sql = "delete FROM `sold_saved` where user_email='".$user_email."' and inventory_id ='".$inventory_id."'";
                    $mysqli->query($sql);
                    $created = date('Y-m-d H:i:s');        
                    
                    $sql = "insert into `sold_saved`(user_email, inventory_id, car , created) values('".$user_email."', '".$inventory_id."', '".$car."', '".$created."')";                  
                    $mysqli->query($sql);
                        
            }
            
            foreach ((array)$viewed as $val) {
                $inventory_id = $val->InventoryID;
                $car = json_encode($val);              
                $sql = "delete FROM `sold_viewed` where user_email='".$user_email."' and inventory_id ='".$inventory_id."'";
                $mysqli->query($sql);

                $created = date('Y-m-d H:i:s');                        
                $sql = "insert into `sold_viewed` (user_email, inventory_id, car , created) values('".$user_email."', '".$inventory_id."', '".$car."', '".$created."')";                  
                $mysqli->query($sql);                    
            }          

            foreach ((array)$list as $val) {
                $inventory_id = $val->inventory_id;                    
                $sql = "delete FROM  `sold_list` where user_email='".$user_email."' and inventory_id ='".$inventory_id."'";
                $mysqli->query($sql);
                
                $save = $val->save;
                $alert = $val->alert;
                $price = $val->price;
                $stocknumber = $val->stocknumber;    
                $sql = "insert into  `sold_list` (user_email, inventory_id, save , alert, stocknumber, price) values('".$user_email."', '".$inventory_id."', '".$save."', '".$alert."','".$stocknumber."','".$price."')";                  
                $mysqli->query($sql);
                    
            }

            
            $mySaved = array();
            $sql = "SELECT * FROM sold_saved where user_email='".$user_email."'";
            if ($result = $mysqli->query($sql)) {
                while($row = $result->fetch_array(MYSQL_ASSOC)) {
                    $cur_date = date_create(date('Y-m-d H:i:s'));
                    $saved_date = date_create($row['created']);
                    $diff = date_diff($cur_date,$saved_date);
                    $row['created'] = $diff;
                    $mySaved[] = $row;
                }
                $storage['saved'] = $mySaved;
            }
            $result->close();  


            $myViewed = array();
            $sql = "SELECT * FROM sold_viewed where user_email='".$user_email."'";
            if ($result = $mysqli->query($sql)) {
                while($row = $result->fetch_array(MYSQL_ASSOC)) {
                    $cur_date = date_create(date('Y-m-d H:i:s'));
                    $saved_date = date_create($row['created']);
                    $diff = date_diff($cur_date,$saved_date);
                    $row['created'] = $diff;
                    $myViewed[] = $row;
                }
                $storage['viewed'] = $myViewed;
            }
            $result->close();  

            $myList = array();
            $sql = "SELECT * FROM sold_list where user_email='".$user_email."'";
            if ($result = $mysqli->query($sql)) {
                while($row = $result->fetch_array(MYSQL_ASSOC)) {                    
                    $myList[] = $row;
                }
                $storage['list'] = $myList;
            }
            $result->close();  
            $mysqli->close(); 
            return $storage;
    }
}

//return html  for email content
function change_content_email(){
    return "text/html";
}


function sendEmail ($stocknumber, $price, $origin_price, $email) {
    $toemail = $email;
    $fromemail = '';

    $subject = 'The Original Price is changed  .';

    $message = '<html lang="en"><body>';
    $message.= '<head><meta charset="UTF-8"></head>';
    $message .= '<h3>Vehicle Stock number: '.$stocknumber.'</h3>';
    $message .= '<p style="font-size:12px;"> Ratail Price is changed from $'.$origin_price.' to $'.$price.'.</p>';
    $message .= '<p style="font-size:12px;"> Sincerely</p>';
    $message .= '<p style="font-size:12px;"> The Passport team.</p>';
    $message .= '</body></html>';

    $mailResult = false;
    $mailResult = wp_mail( $toemail, $subject, $message, 'hurry' );
    //echo $mailResult;
}

?>