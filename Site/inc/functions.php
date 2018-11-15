<?php
	session_start();

	function connectWithDatabase($sql)
	{
		$connect = mysqli_connect("localhost","root","", "myvending"); //localhost

		$resource = mysqli_query($connect, $sql);
	    $retuning_array = array();
	    while($result = mysqli_fetch_assoc($resource))
	    {
	    	$retuning_array[] = $result;
	    }
	    return $retuning_array;
	}


	function styleAndStuffs()
	{
		?>
			<link href="https://fonts.googleapis.com/css?family=Lily+Script+One|Montserrat" rel="stylesheet">

			<link rel="stylesheet" href="dest/css/bootstrap.min.css">
			<link rel="stylesheet" href="css/style.css" >

			<link rel="stylesheet" type="text/css" href="css/sal.css">

			<link rel="icon" href="https://image.flaticon.com/icons/png/128/1020/1020421.png">

		<?php
	}

	function importHeader($scrolled)
	{
	?>

	<nav class="navbar navbar-expand-lg navbar-light <?php echo $scrolled; ?>">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="https://image.flaticon.com/icons/png/128/1020/1020421.png" width="30" height="30" class="d-inline-block align-top" alt="">
        My Vending
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link color-white" data-toggle="modal" data-target="#mycard" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-shopping-basket"></i> Lijst
            </a>
          </li>
        </ul>
      </div>
    </div>
    </nav>

    <!-- mycard -->
	<div class="modal fade" id="mycard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog  modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Mijn <i class="fas fa-shopping-basket text-primary"></i> Lijst</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">

	      	<div class="accordion" id="card-items">
			        <template id="card-items-template">
			        	{{#.}}

			  <div class="card">
			    <div class="card-header" id="heading{{id}}">
			      <h5 class="mb-0">
			        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{id}}" aria-expanded="true" aria-controls="collapse{{id}}">
			          Locatie: {{name}}
			        </button>
			      </h5>
			    </div>

			    <div id="collapse{{id}}" class="collapse" aria-labelledby="headingOne" data-parent="#card-locations">
                {{#card}}

			        <div class="row">
			        	
			        	<div class="col-1"><img src="{{img}}" width="40" height="40"></div>
			        	<div class="col-6">{{name}}</div>
			        	<div class="col-3">€{{price}}</div>

			        	<div class="col-1">
			        		<i class="fas fa-minus-circle btn-deleteCardItem" data-product="{{id}}"></i>
			        	</div>

			        </div>

	       		{{/card}}
	       			<hr>

	       			<div class="row">
			        	
			        	<div class="col-1"></div>
			        	<div class="col-6">Total:</div>
			        	<div class="col-3">€<span class="totalPrice">00.00</span></div>

			        	<div class="col-1"></div>
			        </div>

		        	<div class="row">
		        	
			        	<div class="col-1"></div>
			        	<div class="col-6">Mijn crediet:</div>
			        	<div class="col-3">€<span class="saldoCurrent">5.00</span></div>

		        		<div class="col-1"></div>

			        </div>

			        <hr>

			        <div class="row">
		        	
			        	<div class="col-1"></div>
			        	<div class="col-6">Saldo na betaling:</div>
			        	<div class="col-3">€<span class="saldoAfter">10.00</span></div>

		        		<div class="col-1"></div>

			        </div>

			        <button class="btn btn-secondary w-100 mt-4" data-toggle="modal" data-target="#barcode"><i class="fas fa-money-bill"></i> Betalen</button>

			      </div>
			    </div>
			  </div>
			  {{/.}}
	       </template>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary">Save changes</button>
	      </div>
	    </div>
	  </div>
	</div>

<div class="modal fade" id="barcode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="exampleModalLabel">Locatie: ROC Ter-AA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer text-center">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
        <button type="button" class="btn btn-primary">Help</button>
      </div>
    </div>
  </div>
</div>

    <?php
	}

	function js()
	{
		?>
			<!-- jQuery -->
		    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

		    <!-- Bootstrap -->
		    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		    <script src="dest/js/bootstrap.min.js"></script>

		    <!-- Mustache JS -->
		    <script src="dest/js/mustache.js"></script>
		    
		    <!-- Font Awsome JS -->
		    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>

			<!-- sal.js -->
			<script src = "js/functions/sal.js"></script>

		    <!-- Custom js  -->
		    <script src="js/main.js"></script>
		<?php
	}
?>