<?php
    include("../functions.php");

?>

<!DOCTYPE html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>
       Scanner
     </title>

    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <?php styleAndStuffs(); ?>

</head>
<body>

	<button class="btn btn-primary js-scan">scan</button>
	<video id="preview" autoplay="autoplay" class="active" src="" style="transform: scaleX(-1);"></video>

</body>
<?php 
    
    js();

?>
<script type="text/javascript">
	$("body").on("click", ".js-scan", function(){
    if(active == false){
      active = true;

      //turns the webcam on
      Instascan.Camera.getCameras().then(function (cameras) {
        //checks if the computer has any cameras
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
    }else{
      active = false;

      //turns the webcam off
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.stop(cameras[0]);
        }
      }).catch(function (e) {
        console.error(e);
      });
    }
  })
</script>