<?php 
    
    include("inc/functions.php");

?>

<!DOCTYPE html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>
       Admin | My vending
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

    <section class="container navbar-spacer">

        <h3 class="section-title">Vendingmachines</h3>
        <hr>   

        <div class="row">
            
            <div class="col-lg-3 mb-4">
                <div class="list-group">
                <?php

                $sql = "SELECT * FROM vendingmachines";

                $vendingmachines = connectWithDatabase($sql);

                foreach ($vendingmachines as $vending) {

                ?>
                  <p data-marker="<?php echo $vending['id'];?>" class="dblVending list-group-item list-group-item-action"><?php echo $vending['name'];?> <i class="fas fa-chevron-circle-right float-right"></i></p>

                <?php } ?>

                <button class="btn btn-secondary" data-toggle="modal" data-target="#add-location">Voeg Vendingmachine Toe <i class="fas fa-plus-circle"></i></button>

                <div class="modal fade" id="add-location" tabindex="-1" role="dialog" aria-labelledby="add-location-label" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="add-location-label">Nieuwe Vendingmachine</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white" id="basic-addon1"><i class="fas fa-tag"></i></span>
                          </div>
                          <input type="text" class="form-control" placeholder="Vending Naam" aria-label="Vending Naam" aria-describedby="basic-addon1">
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-secondary">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
                  
                </div>
            </div>
            <div class="col-lg-9 mb-4">
                <div id="map" style="width:100%;height:400px;z-index:1;"></div>
            </div>

        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title vending-name" id="exampleModalLabel">Helmond Station</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <table class="table">
                  <thead class="thead-primary">
                    <tr>
                      <th scope="col" data-toggle="tooltip" data-placement="top" title="Position of vendingmachine">Position</th>
                      <th scope="col" data-toggle="tooltip" data-placement="top" title="Product on the position">Product</th>
                      <th scope="col" data-toggle="tooltip" data-placement="top" title="The current stock">Stock</th>
                      <th scope="col" data-toggle="tooltip" data-placement="top" title="Delete Row"></th>
                    </tr>
                  </thead>
                  <tbody id="vending-machine">
                    <template id="vending-machine-template">

                    {{#.}}
                    <tr class="update-row">
                      <th scope="row">

                      <input type="number" name="id" value="{{vendingassortiment_id}}" style="display: none;">
                      <input type="number" name="position" value="{{position}}" style="width: 60px;">
                        </th>
                      <td>
                        <select>
                          <option value="{{product_id}}">{{product_name}}</option>
                          {{#product_other}}
                          <option value="{{id}}">{{name}}</option>
                          {{/product_other}}
                        </select>
                      </td>
                      <td><input type="number" name="stock" value="{{stock}}" style="width: 60px;"></td>
                      <td>
                        <button class="btn bnt-delete-item btn-danger" value="{{vendingassortiment_id}}" data-product-id="{{product_id}}"><i class="fas fa-minus-circle"></i></button>
                      </td>
                    </tr>
                    {{/.}}

                    <tr class="insert-row bg-light add-product">
                      <th scope="row">

                      <input type="number" class="machineId" name="machineId" value="{{id}}" style="display: none;">
                      <input type="number" name="position" style="width: 60px;">
                        </th>
                      <td>
                        <select>
                          <?php

                          $sql = "SELECT id, name FROM products";

                          foreach(connectWithDatabase($sql) as $product){;

                          ?>
                            <option value="<?php echo $product['id'] ?>"><?php echo $product['name'] ?></option>
                          <?php } ?>
                        </select>
                      </td>
                      <td><input type="number" name="stock" value="0" style="width: 60px;"></td>
                      <td></td>
                    </tr>

                    </template>

                  </tbody>
                </table>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-save btn-secondary" data-dismiss="modal">Opslaan <i class="fas fa-save"></i></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren <i class="fas fa-times-circle"></i></button>
              </div>
            </div>
          </div>
        </div>

        <h3 class="section-title">Producten</h3>
        <hr>

        <table class="table">
          <thead class="thead-primary">
            <tr>
              <th scope="col">#</th>
              <th scope="col"></th>
              <th scope="col">Naam</th>
              <th scope="col">Prijs €</th>
              <th scope="col">Categorie</th>
              <th scope="col">Achtergrondkleur</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody id="products">

            <?php

            $sql = "SELECT id, name FROM categories";

            $categories = connectWithDatabase($sql);

            ?>

            <template id="products-template">

            {{#.}}
            <tr class="update-product-row">
              <th scope="row" class="product-id">{{id}}</th>
              <td>
                <img src="{{img}}" width="50px;" style="background: {{background}};" class="rounded-circle product-img" data-toggle="modal" data-target="#productimgModal">
              </td>
              <td><input type="text" value="{{name}}" class="product-name-input w-100"></td>
              <td><input type="decimal" value="{{price}}" class="product-price" style="max-width: 75px;"></td>

              <td>
                
                <select class="categorie-select" name="categorie">
                  <option value="{{cat_id}}">{{cat_name}}</option>
                  {{#category_other}}

                  <option value="{{id}}">{{name}}</option>

                  {{/category_other}}
                </select>

              </td>

              <td>
                <input type="color" value="{{background}}" class="color-selector">
                <input type="text" value="{{background}}" class="color-text">
              </td>
              <td>
                <button class="btn bnt-delete-product btn-danger" value="{{id}}"><i class="fas fa-minus-circle"></i></button>
              </td>
            </tr>

            {{/.}}
            <tr class="insert-product-row bg-light">
              <th scope="row" class="product-id">80</th>
              <td>
                <img src="https://static-images.jumbo.com/product_images/492100FLS-1_360x360.png" width="50px;" class="rounded-circle product-img" data-toggle="modal" data-target="#productimgModal">
              </td>
              <td><input type="text" class="product-name-input w-100"></td>
              <td><input type="decimal" class="product-price" style="max-width: 75px;"></td>

              <td>
                
                <select class="categorie-select" name="categorie">

                  <?php

                  $sql = "SELECT * FROM categories;";

                  foreach (connectWithDatabase($sql) as $cat) { ?>

                  <option value="<?php echo $cat['id'];?>"><?php echo $cat['name'];?></option>

                  <?php } ?>
                </select>

              </td>

              <td>
                <input type="color" class="color-selector">
                <input type="text" class="color-text">
              </td>
              <td></td>
            </tr>
            </template>
          </tbody>
        </table>

        <div class="modal fade" id="productimgModal" tabindex="-1" role="dialog" aria-labelledby="productimgModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="productimgModalLabel">Verander afbeeling</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="url" value="URL" class="imgUrl-input w-100">

                <img src="nothing" class="imgUrl-img">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-change-product-img btn-secondary" data-dismiss="modal">Opslaan <i class="fas fa-save"></i></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren <i class="fas fa-times-circle"></i></button>
              </div>
            </div>
          </div>
        </div>

        <button class="btn bnt-save-product btn-secondary" value="<?php echo $p['id'] ?>">Opslaan <i class="fas fa-save"></i></button>


        <h3 class="section-title mt-3">Categorieën</h3>
        <hr>

        <table class="table">
          <thead class="thead-primary">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Naam</th>
              <th scope="col"></th>
            </tr>
          </thead>

          <tbody id="categories">

            <template id="categories-template">

            {{#.}}
            <tr class="update-categories-row">
                
                <td scope="row" class="categorie-id">{{id}}</td>
                <td><input type="input" value="{{name}}"></td>
                <td><button class="btn btn-delete-categories btn-danger" value="{{id}}"><i class="fas fa-minus-circle"></i></button></td>

            </tr>
            {{/.}}

            <tr class="insert-categories-row bg-light">
                
                <td scope="row">{{id}}</td>
                <td><input class="categorie-insert" type="input" value="{{name}}"></td>
                <td></td>

            </tr>

            </template>

          </tbody>
        </table>

        <button class="btn btn-secondary btn-save-categories">Opslaan <i class="fas fa-save"></i></button>

    </section>

    <?php echo importFooter();?>

</body>

    <?php 
    
            js();

    ?>

    <script src="js/pages/admin.js"></script>
</html>