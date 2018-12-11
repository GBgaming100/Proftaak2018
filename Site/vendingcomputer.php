<?php 
    if (!(isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) 
		    && $_SERVER['PHP_AUTH_USER'] == 'admin' 
		    && $_SERVER['PHP_AUTH_PW'] == 'admin')) {
		    header('WWW-Authenticate: Basic realm="Restricted area"');
		    header('HTTP/1.1 401 Unauthorized');
		    exit;
		}
    include("inc/functions.php");

?>

<!DOCTYPE html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>
       My vending
     </title>

    <!-- Customize MetaTag Start -->
    <meta name="description" content="Renegade Network: <?php echo $description['about_text'];?>"
    />

    <meta name='keywords' content='MTA SA FiveM GTA SA GTA V RenegadeNetwork'>
    <meta name='url' content='http://renegadenetwork.tk/'>
    <meta name='coverage' content='Worldwide'>
    <meta name='copyright' content='Renegade Network'>

    <meta name="theme-color" content="#000000">

    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <?php styleAndStuffs(); ?>

</head>

<body class="renegade-network" data-spy="scroll">

    <?php importHeader("scrolled") ?>

             <div id="QR-Code" class="container" style="width:100%">
            <div class="panel panel-primary">
                <div class="panel-heading" style="display: inline-block;width: 100%;">
                    <h4 style="width:50%;float:left;">WebCodeCam.js Demonstration</h4>
                    <div style="width:50%;float:right;margin-top: 5px;margin-bottom: 5px;text-align: right;">
                    <select id="cameraId" class="form-control" style="display: inline-block;width: auto;"></select>
                    <button id="save" data-toggle="tooltip" title="Image shoot" type="button" class="btn btn-info btn-sm disabled"><span class="glyphicon glyphicon-picture"></span></button>
                    <button id="play" data-toggle="tooltip" title="Play" type="button" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-play"></span></button>
                    <button id="stop" data-toggle="tooltip" title="Stop" type="button" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-stop"></span></button>
                    <button id="stopAll" data-toggle="tooltip" title="Stop streams" type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-stop"></span></button>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-md-6" style="text-align: center;">
                    <div class="well" style="position: relative;display: inline-block;">
                        <canvas id="qr-canvas" width="320" height="240"></canvas>
                        <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                        <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                        <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                        <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                    </div>
                </div>
                <div class="col-md-6" style="text-align: center;">
                    <div id="result" class="thumbnail">
                        <div class="well" style="position: relative;display: inline-block;">
                            <img id="scanned-img" src="" width="320" height="240">
                        </div>
                        <div class="caption">
                            <h3>Scanned result</h3>
                            <p id="scanned-QR"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
            </div>
        </div>
    </div>

</body>
<?php 
    
    js();

?>
<script type="text/javascript" src="js/qrcodelib.js"></script>
<script type="text/javascript" src="js/WebCodeCam.js"></script>
<script src="js/vendingcomputer.js"></script>
