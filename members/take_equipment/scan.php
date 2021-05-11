<?php 
    session_start(); 
    if ($_SESSION['user']['role']!='M')
    {
        $_SESSION['message'] = "You must log in first";
        header('location: ../members/login.php');
    }
    $back=$_REQUEST['route'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Scan QR Code | TFPS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/font-awesome.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link rel="icon"  href="../assets/img/logo.png">
<body>

<div class="container">
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="panel panel-danger" style="margin-top: 10px;">
      <div class="panel-heading">
        <h3 class="panel-title" style="text-align: center;">Scan the QR Code of the Equipment</h3>
      </div>
      <div class="panel-body text-center" >
        <canvas></canvas>
        <hr>
        <select></select>
      </div>
    </div>
  </div>

</div>
</div>

<!-- Js Lib -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/qrcodelib.js"></script>
<script type="text/javascript" src="js/webcodecamjquery.js"></script>
<script type="text/javascript">
    var arg = {
        resultFunction: function(result) {
            //$('.hasilscan').append($('<input name="noijazah" value=' + result.code + ' readonly><input type="submit" value="Cek"/>'));
           // $.post("../cek.php", { noijazah: result.code} );
            var redirect = '../take.php';
            $.redirectPost(redirect, {eID: result.code});
        }
    };
    
    var decoder = $("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery;
    decoder.buildSelectMenu("select");
    decoder.play();
    /*  Without visible select menu
        decoder.buildSelectMenu(document.createElement('select'), 'environment|back').init(arg).play();
    */
    $('select').on('change', function(){
        decoder.stop().play();
    });

    // jquery extend function
    $.extend(
    {
        redirectPost: function(location, args)
        {
            var form = '';
            $.each( args, function( key, value ) {
                form += '<input type="hidden" name="'+key+'" value="'+value+'">';
            });
            $('<form action="'+location+'" method="POST">'+form+'</form>').appendTo('body').submit();
        }
    });

</script>

  <?php if($back=='2') : ?>
        <h3><a href="../myhistory.php">Back</a></h3>    
    <?php endif ?>
    <?php if ($back!='2') : ?>
        <h3><a href="../dashboard.php">Back</a></h3>  
  <?php endif ?>
  <h3>
    <a href="../../server/logout.php" style="color: red;">Logout</a>
  </h3>

</body>
</html>