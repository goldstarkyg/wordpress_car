<?php
/**
 * Created by PhpStorm.
 * User: hh
 * Date: 10/31/2017
 * Time: 10:40 AM
 */
    $key = '';
    if(isset($_POST['a']))
        $key = $_POST['a'];
    $key = base64_decode($key);
    $eamil = '';
    if(isset($_POST['b']))
        $email = $_POST['b'];
    if($key != 'please reset password') {
        echo 'You can not use this page.';
    }else {

?>
<html class="no-js" lang="en-US">

<!-- head -->
<head>

    <!-- meta -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="BeTuning | Best WordPress theme for tuning cars lovers" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <title>Inventory &#8211; Passport Motors</title>
</head>
<body>
        <div class="container" >
            <div class="col-md-3" style="margin-top: 50px;">
            <form>
                <div class="form-group">
                    <label for="formGroupExampleInput">New Password</label>
                    <input type="hidden" id="email" placeholder="Example input">
                    <input type="text" class="form-control" id="passord" name="password" placeholder="New Password">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Confirm Password</label>
                    <input type="text" class="form-control" id="confirm" name="confirm" placeholder="Confirm Password">
                </div>
                <div class="form-group">
                    <input type="submit" class="form-control" name="submit" value="Submit">
                </div>
            </form>
            </div>
        </div>
</body>
</html>
<?php
   }
?>
