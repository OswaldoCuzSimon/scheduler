<?php
include('model/config.php');
include('control/functions.php');

session_start();
?>
<!doctype html>
<html lang=''>
<head>
   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="css/table.css">
	<link rel="stylesheet" href="css/forms.css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="js/tabs.js" type="text/javascript"></script>
   <title>Scheduler</title>
</head>
<body>

<div>
<?php include 'tabs.php' ?>
</div>
<?php 
$res = login_check();
error_log($res);
if ($res==true){
	header('Location: profesor.php');
}else{
	header('Location: login.php');
} 
?>

</body>
<script>
tabSelected("#home");
</script>
<html>
