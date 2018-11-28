<?php 
    
    include("inc/functions.php");

    $id = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id = ". $id;

    $product = connectWithDatabase($sql)[0];

?>

<!DOCTYPE html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>
       My vending
     </title>

    <!-- Customize MetaTag Start -->
     <meta name="description" content="My Vending"
    />

    <meta name='keywords' content='My Vending vendingmachine'>
    <meta name='coverage' content='Worldwide'>
    <meta name='copyright' content='My Vending'>

    <meta name="theme-color" content="#ef4873">

    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <?php styleAndStuffs(); ?>

</head>

<body class="renegade-network" data-spy="scroll">

    <?php importHeader("") ?>

    <section class="container mt-4">

        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item text-primary"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $product['name']; ?></li>
        </ol>   

        <div class="row">
          <div class="col-sm-4 mb-4" style="background: <?php echo $product['background']; ?>; box-shadow: 5px 5px <?php echo $product['background']; ?>85;">
            <img class="card-img-top" src="<?php echo $product['img']; ?>" alt="Card image cap">
          </div>
          <div class="col-sm-8 mb-4">
            <h1>Product: <?php echo $product['name']; ?></h1>
            <hr>

            <h3>€<?php echo $product['price']; ?></h3>

            <h3 class="section-title">Locaties</h3>
              <div class="list-group">
                <?php

                $sql = "SELECT m.* FROM  `vendingmachines` m JOIN vendingassortiment a ON m.id = a.machine_id WHERE a.product_id =".$id;

                $vendingmachines = connectWithDatabase($sql);

                foreach ($vendingmachines as $vending) {

                ?>
                  <a href="vending.php?id=<?php echo $vending['id'];?>" class="dblVending list-group-item list-group-item-action"><?php echo $vending['name'];?> <i class="fas fa-chevron-circle-right float-right"></i></a>

                <?php } ?>
                  
                </div>

          </div>
        </div>
        <div class="glider-contain">
          <div class="glider">

            <?php

                $sql = "SELECT * FROM products WHERE NOT id = ". $id;

                $otherproducts = connectWithDatabase($sql);

                foreach ($otherproducts as $other) {

            ?>

            <div>

              <a href="product.php?id=<?php echo $other['id']; ?>">
                <div>
                <img class="card-img-top" src="<?php echo $other['img']; ?>" alt="Card image cap" style="background: <?php echo $other['background']; ?>;">
                </div>
              </a>

            </div>

            <?php } ?>
          </div>

          <button role="button" aria-label="Previous" class="glider-prev"><i class="fas fa-arrow-circle-left text-primary"></i></button>
          <button role="button" aria-label="Next" class="glider-next"><i class="fas fa-arrow-circle-right text-primary"></i></button>
          <div role="tablist" class="dots"></div>
        </div>

    </section>

</body>

    <?php 
    
            js();

    ?>

    <!-- <script src="js/pages/vendings.js"></script> -->
    <script type="text/javascript">
      
      new Glider(document.querySelector('.glider'), {
  slidesToShow: 5,
  slidesToScroll: 1,
  draggable: true,
  dots: '.dots',
  arrows: {
    prev: '.glider-prev',
    next: '.glider-next'
  }
});

    </script>
</html>