<?php
   $session = isset($_SESSION['user']);   
   $car_lists = json_encode($this->car_list);
?>

<style>
    /* Style the tab */
    div.tab {
        overflow: hidden;
        margin-top: 5px;;
    }

    /* Style the buttons inside the tab */
    div.tab a {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 4px 10px;
        transition: 0.3s;
    }

    /* Change background color of buttons on hover */
    div.tab a:hover {
        background-color: #e1e1e1;
        text-decoration: none;
    }

    /* Create an active/current tablink class */
    div.tab a.active {
        background-color: #e1e1e1;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        /*border: 1px solid #6f6f70;*/
        z-index: 400;
        border-top: none;
        background-color: #e1e1e1;
        right: 0px;
        -moz-box-shadow: 0px 4px 7px 0px #8b8c8c;
        -webkit-box-shadow: 0px 4px 7px 0px #8b8c8c;
        box-shadow:0px 4px 7px 0px #8b8c8c ;
    }
    .loginform  a {
        color: #3b7aba !important;
        cursor: pointer;
        text-decoration: underline;
    }
    #loginform-login > div > input {
        float: left !important;
    }
    #signupform > div > input {
        float: left !important;
    }
    #forgotform > div > input {
        float: left !important;
    }
    .error {
        color:#f93508;
    }
    .mycars-list {
        margin: 0;
        padding: 10px 8px 10px 5px;      
    }
    .mycars-watchers {
        float: left;
        font-size:9pt;
        color: #ed832f;
        font-weight: bold;
    }
    .remove {
        float: right;;
    }
    .custom-compare {
        float: left;
    }
    .mycars-image {
        float: left;
        display:inline-block;
        width:35%;
    }
    .mycars-img {
        margin-top:10px; 
        border:1px solid #b2b0b0;
        width: 100%;
    }
    .mycars-details {
        float: right;
        display:inline-block;
        width:63%;        
    }
    .mycars-close {
        float: right;
        margin-top:5px;
    }
    .mycars-savetime{
        font-size: 7pt;
    }
    .top-count {
        position: absolute;
        margin-left: -15px;
        margin-top:-12px;
        background-color: #e67216;
        color: #ffffff;
        width: 20px;
        height:20px;
        text-align: center;
        border-radius:25px;
    }
    #saved-session p {
        font-size: 8pt;
    } 
    #signupform p {
      font-size: 8pt;  
    }
    
</style>
<div class="remove"></div>
<div style="position: absolute; width:300px;margin-left: -100px;z-index: 100;"  >
    <div class="tab">
        <div id="tab-session">
            <a class="tablinks" onclick = "openTab(event, 'viewed')" >
                <span id="viewed-count" class="top-count" ></span>
                Viewed
            </a>
            <a class="tablinks" onclick = "openTab(event, 'saved')" >
                <span id="saved-count" class="top-count" ></span>
                Saved
            </a>
            <a class="tablinks" onclick = "openTab(event, 'alert')" >
              <span id="alert-count" class="top-count" ></span>
             Alerts</a >
            <a class="tablinks" id="tablink-login" onclick="openTab(event, 'login')">Log In</a>
        </div>
        <div id="tab-nosession" >
            <a class="tablinks"  style="float: right" onclick="openTab(event, 'login')">Log In</a>
        </div>
    </div>
    <!--**************viewed list******************-->
    <div id="viewed" class="tabcontent" style="position: inherit; width: 400px;right: 0px;" >        
        <div id="viewed-nosession" style="margin-bottom: 10px;">
            <p>You do not have any viewed cars at this time.</p>
        </div>
        <div id="viewed-session" style="max-height:550px;overflow-y: auto">
            <!--viewed list part-->
        </div>        
    </div>
    <!--*******************************-->
    <!--**************saved list******************-->
    <div id="saved" class="tabcontent" style="position: inherit; width: 400px;right: 0px;">
        <div id="saved-nosession" style="margin-bottom: 10px;">
            <p>You do not have any saved cars at this time.</p>
        </div>
        <div id="saved-session" style="max-height:550px;overflow-y: auto">
            <!--saved list part-->
        </div>        
    </div>
    <!--*******************************-->
    <!--**************alert list******************-->
    <div id="alert" class="tabcontent" style="position: inherit; width: 400px;right: 0px;">   
         <div id="alert-nosession" style="margin-bottom: 10px;">
            <p>You do not have any cars with changed price at this time.</p>
        </div>    
        <div id="alert-session" style="max-height:550px;overflow-y: auto">
            <!--alert list part-->
        </div>
    </div>
    <!--*******************************-->
    <!--*******************login form start*********************-->
    <div id="login" class="tabcontent" style="position: inherit; width: 550px;right:0px;" >
        <div>
            <P class="error" ></P>
        </div>
        <?php if(isset($_SESSION['user'])) { ?>
        <div id="login-session">
            <form id="signoutform"  style="margin-top: 20px;">
                <div style="display: inline-block">
                    <span style="font-size: 8pt;">You are logged in as <?php echo $_SESSION['user']['email'] ?> </span> <a href='#' onclick="signout()" style="color: blue" >Logout</a>
                </div>
            </form>
        </div>
        <?php }else { ?>

        <div id="login-nosession">
            <form id="loginform" class="loginform" style="margin-top: 20px;">
                <div id="loginform-login">
                    <div style="display:block">
                        <input  type="email" name="login_email" style="width: 210px; margin-right:10px;"  placeholder="Email Address*"  />
                        <input  type="password" name="login_password" style="width: 210px;margin-right:10px;"  placeholder="Password*"  />
                        <input  type="button" value="Login" style="width:100px;" onclick="signin()"  />
                    </div>
                    <div style="display:inline-block" >
                        <a onclick="openLog(event, 'signupform')">Sign Up</a>
                        <a style="margin-left: 300px;" onclick="openLog(event, 'forgotform')" >Forgot Password?</a>
                    </div>
                </div>
            </form>
            <form id="signupform" style="display: none; margin-top: 20px;" class="loginform" >
                <div id="alert-signup-title">
                    <p>Please provide your email address to begin receiving price alerts at home, at work, and on your phone!</p>
                </div>
                <div id="login-signup-title">
                    <p>Make the most of your secure shopping experience by creating an account.</p>
                    <div style="margin-left:30px;">
                        <p>- Access your saved cars on any device.</p>
                        <p>- Receive Price Alert emails when price changes, new offers become available or a vehicle is sold.</p>
                        <p>- Securely store your current vehicle information and access tools to save time at the the dealership.</p>
                    </div>
                </div>
                <div style="display:inline-block;width: 400px;margin-left: 90px;">
                    <input type="text" name="signup_firstname" placeholder="FirstName*" required="" style="width:45%; margin-right:4%;" />
                    <input type="text" name="signup_lastname" placeholder="LastName*" required="" style="width: 45%;margin-right: 10px;" />
                    <input type="email" name="signup_email" placeholder="Email Address*" required="" style="width:99%;"  />
                    <input type="password" name="signup_password" placeholder="Create Password*" required="" style="width: 99%;" />
                    <input type="password" name="signup_repassword" placeholder="Confirm Password*" required="" style="width: 99%;" />
                    <input type="button" value="Sign Up Now!" onclick="signup()" style="width:99%;" />
                </div>
                <div style="display:inline-block">
                    <span style="font-size: 8pt">Already Registered? </span>  <a onclick="openLog(event, 'loginform')">Login</a>
                </div>
            </form>
            <form id="forgotform" style="display: none;margin-top: 20px;" class="loginform">
                <div id="forgotinput" style="display: block">
                    <span style="font-size: 8pt">Enter your registered email address to request a password reset link</span>
                    <input type="email" name="forgot_email" placeholder="Email Address*" style="width: 320px; margin-right: 10px;" />
                    <input type="submit" value="Request Password Reset"  onclick="forgot(event)"  />
                </div>
                <div id="forgottext" style="display: none">
                    <p><span style="font-size:10pt">An email is on its way.</span></p>
                    <p><span>Please check your inbox for further instructions. If you don 't see the email, Please check your sapm folder. </span></p>
                </div>
                <div style="float: right">
                    <a onclick="openLog(event, 'loginform')" >Log In</a> | <a onclick="openLog(event, 'signupform')">Sign Up</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
    <!--*************************************-->
</div>
<script>
    var $ = jQuery;
    var session = '<?php echo $session ?>';
    var login = false ;
    if(session !='') login = true;
    var session_email ='';
    if(session) session_email = '<?php echo $_SESSION['user']['email'] ?>' ;
    if(session_email != '') $('#tablink-login').html('Account');   
    
    viewd_saved_count('viewed');
    viewd_saved_count('saved');
    viewd_saved_count('alert');


    //change style for button
    function changeStyle() {
        $('.btn-list-car-save').text("Save This Car!");
        $('.btn-list-car-alert').text("Get Price Alerts");
        var styleList =  localStorage.getItem('list');
        $.each(JSON.parse(styleList), function(k,v){
            var inventory_id = v.inventory_id;
            var save = v.save;
            var alert = v.alert;
            if(v.save == 'true') $('.btn-save-'+inventory_id).text('Saved!');
            if(v.save == 'false') $('.btn-save-'+inventory_id).text('Save This Car!');
            if(v.alert == 'true') $('.btn-price-'+inventory_id).text('Alert Set!');
            if(v.alert == 'false') $('.btn-price-'+inventory_id).text('Get Price Alerts');
        });
    }

    var removeimgurl = "<?php echo plugins_url('dealernetwork-inventory/').'images/close.png'?>";
    var url = '<?php echo plugins_url('dealernetwork-inventory/views/inventory-customer-sign.php') ;?>';

    function openTab(evt, Name) {
        // Declare all variables
        var i, tabcontent, tablinks, loglinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // display loginform
        $('.loginform').css("display", 'none');

        if(Name == 'login') {
            $('#loginform').css("display", 'block');
            $('#alert-signup-title').css("display", "none");
            $('#login-signup-title').css("display", "block");
        }

        if(Name == 'alert') {
            $('#signupform').css("display", 'block');
            $('#alert-signup-title').css("display", "block");
            $('#login-signup-title').css("display", "none");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        if(Name == 'alert') {
            if(login) {
                alert_html();
                changeStyle();
            }else {
                Name = 'login';
            }
        }
        document.getElementById(Name).style.display = "block";
        evt.currentTarget.className += " active";
        
        if(Name == 'viewed') {
            if(login) {
               get_viewed(); // from server json    
            }else {
               viewed_html();     
            }
            changeStyle();
        }

        if(Name == 'saved') {
            if(login) {
               get_saved(); // from server json    
            }else {
               saved_html();     
            }
            changeStyle();
        }

    }

    function saved_html(){
        var html = "";
        if(localStorage.getItem('saved') != '' && localStorage.getItem('saved') != null) {
            var saved_json = JSON.parse(localStorage.getItem('saved'));
            console.log(saved_json);
            var background = '';
            var count = 0;
            $.each(saved_json, function (k, v) {
                count++;
                if (count == 1) {
                    html += "<p style='font-size: 12pt;margin-bottom: 10px; font-weight: bold'>We've saved this car for you!</p>";
                    html += "<p><span>Would you like us to send you price alerts?</span> <a href='#' >Yes Please</a></p>";
                }

                if (count % 2 == 1) background = '#f1eeee';
                if (count % 2 == 0) background = '#ffffff';
                html += "<div style='background-color:" + background + ";display:inline-block'  >";
                html += "<ul class='mycars-list'>";
                html += "<li>";
                html += "<div>";

                var all_count  = parseInt(all_saved_count(v.InventoryID)) -1;                
                if(all_count > 0) {
                        html += "<div class='mycars-watchers'>You and "+all_count+" others have saved this vehicle</div>";
                 }else {
                        html += "<div class='mycars-watchers'>You have only saved this vehicle now.</div>";
                 }

                html += "<div class='mycars-close'><img src='" + removeimgurl + "' onclick=\"delete_viewd_saved('"+v.InventoryID+"', 'saved','"+v.StockNumber+"','"+v.Price+"')\" /></div>";
                html += "</div>";
                html += "<div>";
                html += "<div class='mycars-image' onclick=\"goView(event,'"+v.homeurl+"','"+v.InventoryID+"','saved')\" style='cursor: pointer' >";
                html += "<p><img class='mycars-img' src='" + v.ImageUrls[0] + "'></p>";
                // html += "<p><span class='mycars-savetime'>Saved about 2 minutes ago</span></p>";
                html += "</div>";
                html += "<div class='mycars-details'>";
                html += "<P style='font-size:12pt'><b>" + v.Year + " " + v.Make + " " + v.Model + "</b></P>";
                html += "<p>Stock#: " + v.StockNumber + " </p>";
                html += "<p>Engine: " + v.Engine + " </p>";
                html += "<p>Transimition: " + v.Transmission + " </p>";
                html += "<p style='font-size:10pt'><b>Reqular Price: $" + v.Price + "</b></p>";
                html +="<p style='cursor:pointer'><a class='dn-inv-button btn-list-car-alert btn-price-"+v.InventoryID+"' onclick=\"getPriceAlert(event, '"+v.InventoryID+"','"+v.homeurl+"','"+v.StockNumber+"','"+v.Price+"')\">Get Price Alerts</a></p>";
                html += "</div>";
                html += "</div>";
                html += "</li>";
                html += "</ul>";
                html += "</div>";
            });
        }
        if(html != "") {
            $('#saved-session').html(html);
            $('#saved-nosession').css('display', 'none');
            $('#saved-session').css('display', 'block');
        }
        else {
            $('#saved-nosession').css('display', 'block');
            $('#saved-session').css('display', 'none');
        }
    }

    function alert_html(){
        var html = "";
        if(localStorage.getItem('alert') != '' && localStorage.getItem('alert') != null) {
            var alert_json = JSON.parse(localStorage.getItem('alert'));

            var background = '';
            var count = 0;
            $.each(alert_json, function (k, v) {
                count++;
                if (count % 2 == 1) background = '#f1eeee';
                if (count % 2 == 0) background = '#ffffff';
                html += "<div style='background-color:" + background + ";display:inline-block'  >";
                html += "<ul class='mycars-list'>";
                html += "<li>";

                html += "<div>";
                html += "<div class='mycars-image' >";
                html += "<p><img class='mycars-img' src='" + v.ImageUrls[0] + "'></p>";
                html += "</div>";
                html += "<div class='mycars-details'>";
                html += "<P style='font-size:12pt'><b>" + v.Year + " " + v.Make + " " + v.Model + "</b></P>";
                html += "<p>Stock#: " + v.StockNumber + " </p>";
                html += "<p style='font-size:10pt'><b>New Price: $" + v.Price + "</b></p>";
                html += "<p style='font-size:10pt'><b>Price: $" + v.changed_price + "</b></p>";

                html +="<p style='cursor:pointer'><a class='dn-inv-button btn-list-alert ' onclick=\"updatePrice(event, '"+v.InventoryID+"')\" >Update Price</a></p>";
                html += "</div>";
                html += "</div>";
                html += "</li>";
                html += "</ul>";
                html += "</div>";
            });
        }
        if(html != "") {
            $('#alert-session').html(html);
            $('#alert-nosession').css('display', 'none');
            $('#alert-session').css('display', 'block');
        }
        else {
            $('#alert-nosession').css('display', 'block');
            $('#alert-session').css('display', 'none');
        }
    }

    function viewed_html(){
        var html = "";
        if(localStorage.getItem('viewed') != '' && localStorage.getItem('viewed') != null) {
            var viewed_json = JSON.parse(localStorage.getItem('viewed'));
            var background = '';
            var count = 0;
            $.each(viewed_json, function (k, v) {
                count++;
                if (count == 1) {
                    html += "<p style='font-size: 12pt;margin-bottom: 10px; font-weight: bold'>We've saved this car for you!</p>";
                    html += "<p><span>Would you like us to send you price alerts?</span> <a href='#' >Yes Please</a></p>";
                }

                if (count % 2 == 1) background = '#f1eeee';
                if (count % 2 == 0) background = '#ffffff';
                html += "<div style='background-color:" + background + ";display:inline-block' onclick='location.href="+v.homeurl+"' >";
                html += "<ul class='mycars-list'>";
                html += "<li>";
                html += "<div>";

                var all_count  = parseInt(all_saved_count(v.InventoryID)) -1;
                if(all_count > 0) {
                    html += "<div class='mycars-watchers'>You and "+all_count+" others have saved this vehicle</div>";
                }else {
                    html += "<div class='mycars-watchers'>You have only saved this vehicle now.</div>";
                }

                html += "<div class='mycars-close'><img src='" + removeimgurl + "' onclick=\"delete_viewd_saved('"+v.InventoryID+"', 'viewed','"+v.StockNumber+"','"+v.Price+"')\" /></div>";
                html += "</div>";
                html += "<div>";
                html += "<div class='mycars-image' onclick=\"goView(event, '"+v.homeurl+"','"+v.InventoryID+"', 'viewed')\" style='cursor: pointer' >";
                html += "<p><img class='mycars-img' src='" + v.ImageUrls[0] + "'></p>";
                // html += "<p><span class='mycars-savetime'>Saved about 2 minutes ago</span></p>";
                html += "</div>";
                html += "<div class='mycars-details' >";
                html += "<P style='font-size:12pt'><b>" + v.Year + " " + v.Make + " " + v.Model + "</b></P>";
                html += "<p>Stock#: " + v.StockNumber + " </p>";
                html += "<p>Engine: " + v.Engine + " </p>";
                html += "<p>Transimition: " + v.Transmission + " </p>";
                html += "<p style='font-size:10pt'><b>Reqular Price: $" + v.Price + "</b></p>";
                html += "<p style='cursor:pointer' style='margin-top:10px;'><a class='dn-inv-button btn-list-car-save btn-save-"+v.InventoryID+"' onclick=\"saveThisCar(event, '"+v.InventoryID+"','"+v.homeurl+"', '"+v.StockNumber+"','"+v.Price+"')\" >Saved!</a>";
                html +="<a class='dn-inv-button btn-list-car-alert btn-price-"+v.InventoryID+"' onclick=\"getPriceAlert(event, '"+v.InventoryID+"','"+v.homeurl+"','"+v.StockNumber+"','"+v.Price+"')\" >Get Price Alerts</a></p><br/>";
                html += "</div>";
                html += "</div>";
                html += "</li>";
                html += "</ul>";
                html += "</div>";
            });
        }
        if(html != "") {
            $('#viewed-session').html(html);
            $('#viewed-nosession').css('display', 'none');
            $('#viewed-session').css('display', 'block');
        }
        else {
            $('#viewed-nosession').css('display', 'block');
            $('#viewed-session').css('display', 'none');
        }
    }

    function openLog(evt, Name) {
        $('.loginform').css("display", 'none');
        $('#'+Name).css("display", 'block');
        $('.error').html('');
        evt.stopPropagation();
    }

    $(document).click(function() {
        //'clicked outside'
        $(".tabcontent").css("display","none");
//        $(".tablinks").css("background-color","#f4f3f3");
    });

    $(".tablinks").click(function(event) {
        //'clicked inside'
        event.stopPropagation();
    });
    $('form input').click(function(event) {
        //'clicked inside'
        event.stopPropagation();
    });
   $('.tabcontent').click(function(event){
       event.stopPropagation();
   });

   //signup
    function signup() {
        var firstname =  $('form#signupform input[name="signup_firstname"]').val();
        var lastname =  $('form#signupform input[name="signup_lastname"]').val();
        var email =  $('form#signupform input[name="signup_email"]').val();
        var pass =  $('form#signupform input[name="signup_password"]').val();

        if(!confirmEmail(email)) {
            $('.error').html('Pleae enter correct email.');
            return false;
        }

       var cur_saved =  localStorage.getItem("saved");
       var cur_viewed = localStorage.getItem("viewed");
       var cur_list =  localStorage.getItem("list");

        var data=[];
        data.push({name:"mode",value: 'signup'});
        data.push({name:"login",value: firstname });
        data.push({name:"pass",value: pass });
        data.push({name:"firstname",value: firstname });
        data.push({name:"lastname",value: lastname });
        data.push({name:"email",value: email });
        data.push({name:"saved", value: cur_saved});
        data.push({name:"viewed", value: cur_viewed});
        data.push({name:"list", value: cur_list});
        data = $.param(data);

        $.ajax({
            type: "POST",
            url: url,
            async:false,
            data:data,
            dataType: "json",
            error: function(jqXHR, textStatus, errorThrown){
                $('.error').html(errorThrown);
            },
            success: function(content){
                if(content['code'] == '202') {
                    $('.error').html('Can not register user!');
                }
                if(content['code'] == '200') { 
                  changeAlert(content['alert']);
                  localStorage.setItem('saved', JSON.stringify(content['saved']));
                  localStorage.setItem('viewed', JSON.stringify(content['viewed']));
                  localStorage.setItem('list', JSON.stringify(content['list']));                  
                  location.reload();
                  changeStyle();
                }
            }
        });
    }

   //signin
   function signin() {
       var email =  $('form#loginform input[name="login_email"]').val();
       var pass =  $('form#loginform input[name="login_password"]').val();

       if(!confirmEmail(email)) {
           $('.error').html('Pleae enter correct email.');
           return false;
       }

       var cur_saved =  localStorage.getItem("saved");
       var cur_viewed = localStorage.getItem("viewed");
       var cur_list =  localStorage.getItem("list");


       var data=[];
       data.push({name:"mode",value: 'signin'});
       data.push({name:"email",value: email });
       data.push({name:"pass",value: pass });
       data.push({name:"saved", value: cur_saved});
       data.push({name:"viewed", value: cur_viewed});
       data.push({name:"list", value: cur_list});

       data = $.param(data);

       $.ajax({
           type: "POST",
           url: url,
           async:false,
           data:data,
           dataType: "json",
           error: function(jqXHR, textStatus, errorThrown){
               $('.error').html(errorThrown);
           },
           success: function(content){
               if(content['code'] == '202') {
                   $('.error').html('Please enter email and password!');
               }else if(content['code'] == '200') {
                   changeAlert(content['alert']);
                  localStorage.setItem('saved', JSON.stringify(content['saved']));
                  localStorage.setItem('viewed', JSON.stringify(content['viewed']));
                  localStorage.setItem('list', JSON.stringify(content['list']));                  
                  location.reload();
                  changeStyle();
               }
           }
       });
   }

   //signout
   function signout() {
       var data=[];
       data.push({name:"mode",value: 'signout'});
       data = $.param(data);

       $.ajax({
           type: "POST",
           url: url,
           async:false,
           data:data,
           dataType: "json",
           error: function(jqXHR, textStatus, errorThrown){
               $('.error').html(errorThrown);
           },
           success: function(content){
               if(content['code'] == '200') {
                   localStorage.setItem('alert', "");
                   location.reload();
               }
           }
       });
   }


   function confirmEmail(Email) {
       var atpos = Email.indexOf("@");
       var dotpos = Email.lastIndexOf(".");
       if (atpos<1 || dotpos<atpos+2 || dotpos+2>= Email.length) {
           return false;
       }else {
           return true;
       }
   }
    //Get price event
    var car_lists = <?php echo $car_lists ?>;
    var saved_lists = [];
    var prop_lists = [];
    function saveThisCar(evt,param, url, stocknumber, price) {
        saved_lists = [];
        var btn_saved_text = $.trim($('.btn-save-'+param).text()).toLowerCase();
        evt.stopPropagation();

        var saved = localStorage.getItem('saved');
        
        //if login is true
        if(login) {
            sendSaved(param, stocknumber, price) ;
            return false;
        }

        $.each(car_lists, function(k, v) {
                if (v.InventoryID == param) {
                    if(saved != null && saved != "" && saved != "[null]" && saved != "[]") {
                        var saved_json  = JSON.parse(saved);
                        var check_val = false;
                        $.each(saved_json, function (key, val) {
                            if (val.InventoryID == param) {
                                delete saved_json[key];
                                check_val = true;
                                save_delStyle('del_save',param, stocknumber, price);
                            }else {
                                saved_lists.push(val);
                            }
                        });
                        if(check_val == false) {
                            saved_lists.push(v);
                            save_delStyle('save',param, stocknumber, price);
                        }
                    }else {
                        v.homeurl = url;
                        v.stocknumber = stocknumber;
                        v.price = price;
                        saved_lists.push(v);
                        save_delStyle('save',param,stocknumber, price);
                    }
                    return ;
                }
        });

        if(saved_lists.length > 0)
            localStorage.setItem('saved', JSON.stringify(saved_lists));
        else
            localStorage.setItem('saved', "");
        viewd_saved_count('saved');
        saved_html();
        changeStyle();
    }

    //save style for button  btn_name= save, alert, del_save, del_alert
    function save_delStyle(btn_name, param, stocknumber, price ) {
        var sList = localStorage.getItem('list');
        var sList_json  = JSON.parse(sList);
        var sObject = {};
        var list = [];
        switch (btn_name) {
            case 'save' :
                var check_val = false;
                $.each(sList_json, function(k,v){
                   if(v.inventory_id == param) {
                       check_val = true;
                       v.save = 'true';
                       v.alert = 'true';
                       v.stocknumber = stocknumber;
                       v.price = price;
                       list.push(v);
                   }else {
                       list.push(v);
                   }
                });
                if(check_val == false) {
                    sObject.inventory_id = param;
                    sObject.save = 'true';
                    sObject.alert = 'true';
                    sObject.stocknumber = stocknumber;
                    sObject.price = price;
                    list.push(sObject);
                }
                break;
            case 'del_save' :
                $.each(sList_json, function(k,v){
                    if(v.inventory_id != param) {
                        list.push(v);
                    }
                });
                break;
            case 'alert':
                var check_val = false;
                $.each(sList_json, function(k,v){
                    if(v.inventory_id == param) {
                        check_val = true;
                        v.alert = 'true';
                        v.save = 'true';
                        v.stocknumber = stocknumber;
                        v.price = price;
                        list.push(v);
                    }else{
                        list.push(v);
                    }
                });
                if(check_val == false) {
                    sObject.inventory_id = param;
                    sObject.alert = 'true';
                    sObject.save = 'true';
                    sObject.stocknumber = stocknumber;
                    sObject.price = price;
                    list.push(sObject);
                }
                break;
            case 'del_alert':
                var check_val = false;
                $.each(sList_json, function(k,v){
                    if(v.inventory_id == param) {
                        check_val = true;
                        v.alert = 'false';
                        v.stocknumber = stocknumber;
                        v.price = price;
                        list.push(v);
                    }else{
                        list.push(v);
                    }
                });
                break;
        }
        localStorage.setItem('list', JSON.stringify(list));
    }


    //viewed save
    var viewed_lists = [];
    function viewThisCar(evt,param,url, stocknumber, price) {
        viewed_lists = [];        
        evt.stopPropagation();
        var viewed = localStorage.getItem('viewed');

        //if login is true
        if(login) {
            sendViewed(param, 'insert') ;
            return false;
        }

        // add in data list.
        $.each(car_lists, function(k, v) {
            if (v.InventoryID == param) {
                    var exist_val = false ;
                    if(viewed != '[null]' && viewed != "" ) {
                        var viewed_json  = JSON.parse(viewed);
                        $.each(viewed_json, function (key, val) {
                            if (val.InventoryID == param) exist_val = true;
                            else  viewed_lists.push(val);
                        });
                    }
                    if(exist_val == false) {
                        v.homeurl = url;
                        v.stocknumber = stocknumber;
                        v.price = price;
                        viewed_lists.push(v);               
                    }
                }
        });

        viewd_saved_count('viewed');

        if(viewed_lists.length > 0)
            localStorage.setItem('viewed', JSON.stringify(viewed_lists));
        else
            localStorage.setItem('viewed', "");
        viewed_html();
        changeStyle();
    }

   //Get price event
   function getPriceAlert(evt, param ,url, stocknumber, price) {
       var list = localStorage.getItem('list');
       var json_list = JSON.parse(list);
       var check_val = false ;
       var list_array = [];
       var alert_val= '';
       $.each(json_list, function(k,v){
          if(v.inventory_id == param) {
             if(v.alert == 'false') v.alert = 'true';
             else if(v.alert == 'true') v.alert = 'false';
             check_val = true;
             alert_val = v.alert;
          }
           list_array.push(v);
       });
       if(check_val == true) {
           if(login) {
               sendAlert(evt, param, alert_val, stocknumber, price);
               return false;
           }
           localStorage.setItem('list', JSON.stringify(list_array));
           changeStyle();
       }else {
           saveThisCar(evt, param, url, stocknumber, price);
       }
       evt.stopPropagation();
//       if(!login) openTab(evt, 'alert');
   }

    //send to server to saved
    function sendSaved(param, stocknumber, price) {
        var email = '<?php echo $_SESSION['user']['email'] ?>' ;
        var current_object = '';
        $.each(car_lists, function(k, v) {
            if (v.InventoryID == param) {
                 current_object = JSON.stringify(v);
            }
        });

        var data=[];
        data.push({name:"mode",value: 'saved_car'});
        data.push({name:"email",value: email });
        data.push({name:"inventory_id",value: param });
        data.push({name:"stocknumber",value: stocknumber });
        data.push({name:"price",value: price });
        data.push({name:"car",value: current_object });

        data = $.param(data);

        $.ajax({
            type: "POST",
            url: url,
            async:false,
            data:data,
            dataType: "json",
            error: function(jqXHR, textStatus, errorThrown){
                $('.error').html(errorThrown);
            },
            success: function(content){
                if(content !="" && content != null)  {
                      saveStorageFromServer(content.saved, 'saved');
                      localStorage.setItem('saved', JSON.stringify(saved_lists));
                      var list = content.list;
                      localStorage.setItem('list', JSON.stringify(list));
                }
                viewd_saved_count('saved');    
                saved_html();
                changeStyle();
            }
        });
    }

    //send Alert
    function sendAlert(evt, param, alert, stocknumber, price) {
        var email = '<?php echo $_SESSION['user']['email'] ?>' ;
        evt.stopPropagation();
        var data=[];
        data.push({name:"mode",value: 'saved_alert'});
        data.push({name:"email",value: email });
        data.push({name:"inventory_id",value: param });
        data.push({name:"stocknumber",value: stocknumber });
        data.push({name:"price",value: price });
        data.push({name:"alert",value: alert});

        data = $.param(data);

        $.ajax({
            type: "POST",
            url: url,
            async:false,
            data:data,
            dataType: "json",
            error: function(jqXHR, textStatus, errorThrown){
                $('.error').html(errorThrown);
            },
            success: function(content){
                if(content !="" && content != null)  {
                    var list = content.list;
                    localStorage.setItem('list', JSON.stringify(list));
                }
                viewd_saved_count('saved');
                changeStyle();
            }
        });
    }

    //send to server to viewed
    function sendViewed(param, cond) {
        var email = '<?php echo $_SESSION['user']['email'] ?>' ;
        var current_object = '';
        $.each(car_lists, function(k, v) {
            if (v.InventoryID == param) {
                current_object = JSON.stringify(v);
            }
        });

        var data=[];
        data.push({name:"mode",value: 'viewed_car'});
        data.push({name:"email",value: email });
        data.push({name:"inventory_id",value: param });
        data.push({name:"car",value: current_object });
        data.push({name:"cond",value: cond });

        data = $.param(data);

        $.ajax({
            type: "POST",
            url: url,
            async:false,
            data:data,
            dataType: "json",
            error: function(jqXHR, textStatus, errorThrown){
                $('.error').html(errorThrown);
            },
            success: function(content){
                if(content !="" && content != null) {
                    saveStorageFromServer(content, 'viewed');
                    localStorage.setItem('viewed', JSON.stringify(viewed_lists));
                }
                viewed_html();
            }
        });
    }

    //get saved data from srver
    function get_saved() {
        var email = '<?php echo $_SESSION['user']['email'] ?>' ;        
        var data=[];
        data.push({name:"mode",value: 'get_saved_car'});
        data.push({name:"email",value: email });
        
        data = $.param(data);

        $.ajax({
            type: "POST",
            url: url,
            async:false,
            data:data,
            dataType: "json",
            error: function(jqXHR, textStatus, errorThrown){
                $('.error').html(errorThrown);
            },
            success: function(content){
                if(content !="" && content != null)  {
                        saveStorageFromServer(content, 'saved');
                        localStorage.setItem('saved', JSON.stringify(saved_lists));
                    }
                saved_html();    
            }
        });      
    }

    //get viewed data from srver
    function get_viewed() {
        var email = '<?php echo $_SESSION['user']['email'] ?>' ;        
        var data=[];
        data.push({name:"mode",value: 'get_viewed_car'});
        data.push({name:"email",value: email });
        
        data = $.param(data);

        $.ajax({
            type: "POST",
            url: url,
            async:false,
            data:data,
            dataType: "json",
            error: function(jqXHR, textStatus, errorThrown){
                $('.error').html(errorThrown);
            },
            success: function(content){
                if(content !="" && content != null) {
                        saveStorageFromServer(content, 'viewed');
                        localStorage.setItem('viewed', JSON.stringify(viewed_lists));
                    }
                viewed_html();    
            }
        });      
    }

    function all_saved_count(inventory_id) {
        var data=[];
        data.push({name:"mode",value: 'all_saved_count'});
        data.push({name:"inventory_id",value: inventory_id });
        var count_number = 10;
        data = $.param(data);

        $.ajax({
            type: "POST",
            url: url,
            async:false,
            data:data,            
            error: function(jqXHR, textStatus, errorThrown){
                $('.error').html(errorThrown);
            },
            success: function(content){
                count_number = content;
            }
        });
        return count_number;           
    }

    //delete inventroy when cut from  list by button. item=saved or viewed
    function delete_viewd_saved(inventory_id, item, stocknumber, price) {
        if(login) {
            var email = '<?php echo $_SESSION['user']['email'] ?>' ;            
            var data=[];
            data.push({name:"mode",value: 'delete_car'});
            data.push({name:"email",value: email });
            data.push({name:"inventory_id",value: inventory_id });            
            data.push({name:"item",value: item }); 
            data = $.param(data);

            $.ajax({
                type: "POST",
                url: url,
                async:false,
                data:data,
                dataType: "json",
                error: function(jqXHR, textStatus, errorThrown){
                    $('.error').html(errorThrown);
                },
                success: function(content){
                    if(content.code = '200') {
                        if(item =='viewed') {
                            saveStorageFromServer(content.viewed, item);
                            localStorage.setItem(item, JSON.stringify(viewed_lists));
                            viewed_html();
                        }
                        if(item =="saved") {
                            saveStorageFromServer(content.saved, item);
                            localStorage.setItem(item, JSON.stringify(saved_lists));
                            saved_html();
                        }
                        saveStorageFromServer(content.list, 'list');
                        localStorage.setItem("list", JSON.stringify(prop_lists));
                    }
                    //viewd_saved_count('viewed');
                    viewd_saved_count(item);
                    saved_html();
                    changeStyle();
                }
            });

        }else {
            saved_lists = [];
            viewed_lists = [];
            var storage = localStorage.getItem(item);
            var storage_val = JSON.parse(storage);
            $.each(storage_val, function(k,v) {
                if(v.InventoryID != inventory_id) {
                    if(item == 'saved') {
                        saved_lists.push(v);               
                    }
                    if(item == 'viewed') {
                        viewed_lists.push(v);               
                    }       
                }else {
                    save_delStyle('del_save',inventory_id,stocknumber,price);
                }
            });
            if(item =="viewed") {
                localStorage.setItem(item, JSON.stringify(viewed_lists));
                viewed_html();
            }
            if(item =="saved") {
                localStorage.setItem(item, JSON.stringify(saved_lists));
                saved_html();
            }
        }
        viewd_saved_count(item);
        changeStyle();
    }

    //save storage from server
    function saveStorageFromServer(content, item) {
         saved_lists = [];
         viewed_lists = [];
         prop_lists = [];
         if(item == 'list') {
             prop_lists = content;
         }else {
             $.each(content, function (k, v) {
                 if (item == 'saved') {
                     saved_lists.push(JSON.parse(v.car));
                 }
                 if (item == 'viewed') {
                     viewed_lists.push(JSON.parse(v.car));
                 }
             });
         }
    }

    //viewed and saved count
    function viewd_saved_count(item){
         var obj_lists = [];
         var storage = localStorage.getItem(item) ;
         $('#tab-session').css('display','block');
         $('#tab-nosession').css('display','none');
         if(storage !='' && storage != '[null]' && storage != '[]') {
             $.each(JSON.parse(storage), function(k, v) { 
                $('.btn-save-'+v.InventoryID).html('Saved!');
                 obj_lists.push(v);
            });
            var length = obj_lists.length;
             if(length == 0) {
                if(item == 'saved') $('#saved-count').css('display','none');
                if(item == 'viewed') $('#viewed-count').css('display','none');
                if(item == 'alert') $('#alert-count').css('display','none');
            }else{
                if(item == 'saved') {
                    $('#saved-count').css('display','block');
                    $('#saved-count').html(length);
                }
                if(item == 'viewed') {
                    $('#viewed-count').css('display','block');
                    $('#viewed-count').html(length);
                }
                if(item == 'alert') {
                     $('#alert-count').css('display','block');
                     $('#alert-count').html(length);
                }
            }
        }else {              
             if(item == 'saved') $('#saved-count').css('display','none');
             if(item == 'viewed') $('#viewed-count').css('display','none');
             if(item == 'alert') $('#alert-count').css('display','none');
         }
    }
    //forgot passsword
    function forgot(evt) {
        evt.stopPropagation();
        var email =  $('form#forgotform input[name="forgot_email"]').val();
        var data=[];
        data.push({name:"mode",value: 'frogot'});
        data.push({name:"email",value: email });
        data.push({name:"url",value: url });
        data = $.param(data);

        $.ajax({
            type: "POST",
            url: url,
            async:false,
            data:data,
            dataType: "json",
            error: function(jqXHR, textStatus, errorThrown){
                $('.error').html(errorThrown);
            },
            success: function(content){
//                if(content['code'] == '200') {
//                    $('#forgotinput').css("display","none");
//                    $('#forgottext').css("display","block");
//                }
            }
        });
    }

    function goView(evt,url, param, item) {
        if(item == 'saved') {
            viewThisCar(evt, param, url);
        }
        location.href = url;
    }

    function changeAlert(list){
        var alert_count = list.length;
        var car_count = 0;
        var alert_lists = [];
        $.each(car_lists, function(k,v){
            car_count++;
            $.each(list, function(k1,v1){
                if(v.InventoryID == v1.inventory_id) {
                    if (v.Price != v1.price) {
                        v.changed_price = v1.price;
                        alert_lists.push(v)
                    }
                }
            });
            if(car_count > alert_count) return;
        });
        localStorage.setItem('alert', JSON.stringify(alert_lists));
        viewd_saved_count('alert');
        alert_html();
    }

    function updatePrice(evt, inventory_id ) {

        evt.stopPropagation();
        var email = '<?php echo $_SESSION['user']['email'] ?>' ;
        var current_object = '';
        var price = "" ;
        $.each(car_lists, function(k, v) {
            if (v.InventoryID == inventory_id) {
                current_object = JSON.stringify(v);
                price = v.Price;
                return ;
            }
        });

        var data=[];
        data.push({name:"mode",value: 'update_price'});
        data.push({name:"email",value: email });
        data.push({name:"inventory_id",value: inventory_id });
        data.push({name:"car",value: current_object });
        data.push({name:"price",value: price });

        data = $.param(data);

        $.ajax({
            type: "POST",
            url: url,
            async:false,
            data:data,
            dataType: "json",
            error: function(jqXHR, textStatus, errorThrown){
                $('.error').html(errorThrown);
            },
            success: function(content){
                changeAlert(content['alert']);
                localStorage.setItem('saved', JSON.stringify(content['saved']));
                localStorage.setItem('viewed', JSON.stringify(content['viewed']));
                localStorage.setItem('list', JSON.stringify(content['list']));
            }
        });
    }

    changeStyle();

</script>
