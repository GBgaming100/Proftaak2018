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

    <button class="btn btn-secondary js-scan">scan</button>
	<video id="preview" autoplay="autoplay" class="active" src="" style="transform: scaleX(-1);"></video>

</body>
<?php 
    
    js();

?>
<script src="js/vendingcomputer.js"></script>