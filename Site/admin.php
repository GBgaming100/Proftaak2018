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

    <section class="container mt-4">

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

                <button class="btn btn-secondary">Voeg Vendingmachine Toe <i class="fas fa-plus-circle"></i></button>
                  
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
                  <thead>
                    <tr>
                      <th scope="col">Position</th>
                      <th scope="col">Product</th>
                      <th scope="col">Stock</th>
                      <!-- <th scope="col">Size</th> -->
                    </tr>
                  </thead>
                  <tbody id="vending-machine">
                    <template id="vending-machine-template">

                    {{#.}}
                    <tr>
                      <th scope="row">
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
                      <!-- <td>medium</td> -->
                    </tr>
                    {{/.}}
                    </template>

                  </tbody>
                </table>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

    </section>


</body>

    <?php 
    
            js();

    ?>

    <!-- <script src="js/pages/admin.js"></script> -->

    <script>
        var markers = [];

        var map = L.map('map').setView([52.092876, 5.104480], 7);

        var myIcon = L.icon({
            iconUrl: 'img/marker.png',
            iconSize: [38, 38],
            iconAnchor: [22, 22],
            popupAnchor: [-3, -76]
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">Maarten & Max</a> Developers'
        }).addTo(map);

        $.ajax({ 
            type: "GET",
            dataType: "json",
            url: "inc/map/getmapdata.php",

            success: function(data)
            {  

                $.each(data, function(index, value){

                    var marker = L.marker([value['lat'], value['long']], {icon: myIcon}).addTo(map)
                    .bindPopup(value['name']+'.<br> <a class="view-vending" data-toggle="modal" data-target="#exampleModal" data-vending="'+value['id']+'">Beijk Voorraad</a>.');

                    marker["id"]=value['id'];
                    marker["lat"]=value['lat'];
                    marker["long"]=value['long'];
                    markers.push(marker);

                });
                console.table(markers)
            }
        });

        map.on('popupclose', function(e) {
            $(".dblVending").removeClass("active");
        });

        $(".dblVending").on("click", function(){


            markerId = $(this).data('marker');

            $(".dblVending").removeClass("active");

            $.each(markers, function(index, value){

                if (value['id'] == markerId) 
                {
                    value.openPopup();

                    map.setView([value['lat'], value['long']], 15);


                }

            })

            $(this).addClass( "active" );

        }); 

        $("body").on("click", ".view-vending", function(){
            id = $(this).data("vending");

            console.log(id);

             $.ajax({ 
                type: "POST",
                dataType: "json",
                data:{id: id},
                url: "inc/admin/getstock.php",

                success: function(data)
                {  

                    $(".vending-name").text(data[0]['vending_name']);

                    mustache(data, "#vending-machine-template", "#vending-machine");

                    console.table(data);

                }
            });

        });
                </script>
</html>