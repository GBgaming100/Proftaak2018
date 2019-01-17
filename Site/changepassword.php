<?php 

    include("inc/functions.php");

    $salt = "8dC_9Kl?";

    $resetpasskey;

    $message = "";
    $type= "";

    if ((isset($_GET['id'])&& !$_GET['id']== "" )|| isset($_SESSION['user'])) {
      if (isset($_POST['password1']) && isset($_POST['password2'])) {
          if ($_POST['password1'] == $_POST['password2']) {

            $password = $encrypted = md5($_POST['password2'] . $salt);

            if (isset($_GET['id'])){
              $resetpasskey = $_GET['id'];

              $sql = "UPDATE users SET user_password = ?, user_forgotpasscode='' WHERE `user_forgotpasscode` = ?;";
              $params = ['ss', &$password, &$resetpasskey];

              PostToDatabase($query, $params);

            }
            if (isset($_SESSION['user'])) {
              $username = $_SESSION['user'];

              $sql = "UPDATE users SET user_password = ? WHERE `user_name` = ?";
              $params = ['ss', &$password, &$username];
              
              PostToDatabase($query, $params);
            }

              $message = "Your password has been succesfully changed";
              $type = "success";

              header("Location: index.php");
          }else{

              $message = "Passwords didn't match";
              $type = "danger";
            }

        }

        $_SESSION["message"] = [$message, $type];

    }else{
      header("Location: index.php");
    }
?>

<!DOCTYPE html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>
        Verander Wachtwoord
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
          <h3><i class="fas fa-exchange-alt fa-4x"></i></h3>

          <h2 class="text-center">Verander Password</h2>
          <p>U kunt hier uw wachtwoord veranderen</p>
          <div class="panel-body">

            <form id="register-form" role="form" autocomplete="off" class="form" method="post">

              <div class="form-group pass_show">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                  <input id="password" name="password1" aria-label="password" placeholder="Password" class="form-control" type="password">
                </div>

                <div class="input-group pass_show mt-3">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                  <input id="password" name="password2" aria-label="password" placeholder="Repeat password" class="form-control" type="password">
                </div>

              </div>
              <div class="form-group">
                <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Change Password" type="submit">
              </div>
              
              <input type="hidden" class="hide" name="token" id="token" value=""> 
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<?php 

    js();

?>