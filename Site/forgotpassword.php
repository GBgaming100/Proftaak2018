<?php 

    include("inc/functions.php");

    if (isset($_SESSION['user'])) {
        
      if(isset($_REQUEST["destination"])){
        header("Location: {$_REQUEST["destination"]}");
      }else if(isset($_SERVER["HTTP_REFERER"])){
        header("Location: index.php");
      }

      end();

    }
?>

<!DOCTYPE html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>
        Wachtwoord Vergeten?
     </title>

    <meta name="description" content="My Vending"
    />

    <meta name='keywords' content='My Vending vendingmachine'>
    <meta name='coverage' content='Worldwide'>
    <meta name='copyright' content='My Vending'>

    <meta name="theme-color" content="#ef4873">

    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Customize MetaTag end -->

    <?php styleAndStuffs(); ?>

</head>
<body>
  <?php importHeader("") ?>
  <div class="container">
    <div class="panel panel-default " style="
    margin: 20vh auto;
    max-width: 350px;">
      <div class="panel-body">
        <div class="text-center">
          <h3><i class="fas fa-unlock-alt fa-4x"></i></h3>
          <h2 class="text-center">Wachtwoord Vergeten?</h2>
          <p>Vraag hier uw nieuwe wachtwoord aan</p>
          <div class="panel-body">

            <form id="register-form" role="form" autocomplete="off" class="form" action="inc/user/sendpassrequest.php" method="post">

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                  <input id="email" name="mail" aria-label="mail" placeholder="E-mail address" class="form-control" type="mail">
                </div>
              </div>
              <div class="form-group">
                <input name="recover-submit" class="btn btn-lg btn-secondary btn-block" value="Reset Password" type="submit">
              </div>
              
              <input type="hidden" class="hide" name="token" id="token" value=""> 
            </form>
                <?php if (isset($_SESSION['emailnotification'])) {?><p><?php echo $_SESSION['emailnotification'];?></p><?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<?php 

    js();

?>