<?php 
    
    include("inc/functions.php");

    $id = $_GET['id'];

    $sql = "SELECT name FROM vendingmachines WHERE id = ". $id;

    $name = connectWithDatabase($sql)[0]['name'];

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

    <?php importHeader("") ?>

    <section class="container mt-4">

        <ol class="breadcrumb bg-transparent">
            <li class="breadcrumb-item text-primary"><a href="#">Home</a></li>
            <li class="breadcrumb-item text-primary"><a href="#">Locaties</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo($name); ?></li>
        </ol>

        <h3>Locatie: <?php echo($name); ?></h3>

        <h5>Producten</h5>
        <hr>   

        <div class="row">
            <div class="col-sm-4 mb-4">
                <div class="input-group mb-3">
                          <input type="text" id="search" class="form-control" placeholder="Search" aria-label="Search for servers" aria-describedby="search-bar">
                          <div class="input-group-append">
                            <span class="input-group-text bg-primary text-white" id="search-bar" data-machine="<?php echo($id); ?>">
                                <i class="fas fa-search"></i>
                            </span>
                          </div>
                        </div>
            </div>
            <div class="col-sm-4 mb-4">
                
                <a class="btn btn-secondary" data-toggle="collapse" href="#collapseCats"><i class="fas fa-list"></i> Catogorieën</a>

                <div class="collapse" id="collapseCats">
                    <ul class="list-group" id="categories">

                    <template id="categories-template">
                    {{#.}}

                      <li class="list-group-item d-flex justify-content-between align-items-center">
                       <input id="check-cat-{{id}}" class="cat-check" type="checkbox" name="cat" value="{{id}}">
                        <label class="checkbox w-100" for="check-cat-{{id}}">
                            {{name}}
                            <span class="float-right ml-3 badge badge-primary badge-pill">
                               {{total}}                      
                            </span>
                        </label>
                      </li>

                    {{/.}}
                    

                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        <input id="check-cat-all" class="cat-check" type="checkbox" name="cat" checked value="All">
                        <label class="checkbox w-100" for="check-cat-all">
                            All
                            <span class="float-right ml-3 badge badge-primary badge-pill">
                                3                      
                            </span>
                        </label>
                      </li>

                      </template>
                    </ul>
                </div>

            </div>

            <div class="col-sm-4 mb-4">
                
                <a class="btn btn-secondary" data-toggle="collapse" href="#collapseFilters"><i class="fas fa-filter"></i> Filter</a>

                <div class="collapse" id="collapseFilters">
                    <ul class="list-group" id="filters">
                      <template id="filters-template">
                        {{#.}}

                          <li class="list-group-item d-flex justify-content-between align-items-center">
                           <input id="check-filter-{{id}}" class="filter-check" type="radio" name="{{type}}" {{extra}} value="{{query}}">
                            <label class="checkbox w-100" for="check-filter-{{id}}">
                                {{name}}
                            </label>
                          </li>

                        {{/.}}

                    </template>
                    </ul>
                </div>

            </div>

        </div>

        <div class="row mb-4" id="products">   
            <template id="products-templates">
                {{#.}}

                <div class="col-lg-3 position-relative price-container">   
                    <div class="card card--front position-absolute" style="background: {{background}}">
                      <img class="card-img-top" src="{{img}}" alt="Card image cap">
                      <h4 class="pricetag">€{{price}}</h4>
                    </div>

                    <div class="card card--back position-absolute p-4" style="background: {{background}}">
                      <h3 class="product-name">{{name}}</h3>

                      <h3 class="text-white">€{{price}}</h3>

                      <button class="btn btn-primary btn-addToCard" value="{{id}}>" data-machine="<?php echo($id); ?>"><i class="fas fa-cart-plus"></i> Add to Card</button>
                    </div>
                </div>

                {{/.}}
            </template>

        </div> 
    </section>

</body>

    <?php 
    
            js();

    ?>

    <script src="js/pages/vendings.js"></script>
</html>