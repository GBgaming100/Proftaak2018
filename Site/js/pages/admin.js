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

      getVendingMachine(id);

  });

  getProducts();
  getCategories();

  function getVendingMachine(id)
  {
    $.ajax({ 
          type: "POST",
          dataType: "json",
          data:{id: id},
          url: "inc/admin/getstock.php",

          success: function(data)
          {  
              mustache(data, "#vending-machine-template", "#vending-machine");

              $(".machineId").val(id);

              $(".vending-name").text(data[0]['vending_name']);
          }
      });
  }

  function getProducts()
  {
    $.ajax({ 
          type: "GET",
          dataType: "json",
          url: "inc/admin/getproducts.php",

          success: function(data)
          {  
              mustache(data, "#products-template", "#products");
          }
      });
  }

  $("table").on('input', ".add-product input", function()
  {
    var oldVal = $(this).val();

    console.log(oldVal)

    $(this).val("");

    var input = $(this).closest("tr").clone();

    $(this).val(oldVal);

    var inputval = $(this).val();

    $(this).closest("tr").next().remove();

    if (inputval != "") 
    {

      $(input).find("input").val("");
      $(this).closest( "table" ).append(input);

    }
  });

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });

  $(".btn-save").on("click", function(){
    $(".update-row").each(function(index, value)
    {
      var id =            $(value).find("input[name='id']").val();
      var position =      $(value).find("input[name='position']").val();
      var product_id =    $(value).find("select").val();
      var stock =         $(value).find("input[name='stock']").val();

       $.ajax({ 
          type: "POST",
          dataType: "json",
          data:{id: id,
                position: position,
                product: product_id,
                stock: stock
              },
          url: "inc/admin/updatevending.php"
      });
    })

    $(".insert-row").each(function(index, value)
    {
      var machineId =     $(value).find(".machineId").val();
      var position =      $(value).find("input[name='position']").val();
      var product_id =    $(value).find("select").val();
      var stock =         $(value).find("input[name='stock']").val();

      if (position != "")
      {
        $.ajax({ 
          type: "POST",
          dataType: "json",
          data:{
                machineId: machineId,
                position: position,
                product: product_id,
                stock: stock
              },
          url: "inc/admin/insertvending.php"
        });
      }
    });
  });

  $("body").on("click", ".bnt-delete-item", function()
  {

    id = $(this).val();

    product = $(this).data("product-id");

    vending = $(".machineId").val()

    console.log("item id: " + id);
    console.log("product id: " + product);
    console.log("vending id: " + vending);

    $.ajax({ 
      type: "POST",
      dataType: "json",
      data:{
            id: id,
                product: product,
                vending: vending

          },
      url: "inc/admin/deletevending.php"
    });

    getVendingMachine($(".machineId").val());

  });
  editProduct();

  function editProduct()
  {
    $(".color-text").on("input", function()
    {
      color = $(this).val();
      $(this).closest("tr").find(".product-img").css("background", color);;

      $(this).closest("tr").find(".color-selector").val(color);
    });

    $(".color-selector").on("change", function()
    {
      color = $(this).val();
      $(this).closest("tr").find(".product-img").css("background", color);;

      $(this).closest("tr").find(".color-text").val(color);
    });

    $("body").on("click", ".bnt-delete-product", function(){
      p_id = $(this).val();

      $.ajax({ 
      type: "POST",
      dataType: "json",
      data:{
          id: p_id
            },
        url: "inc/admin/deleteproduct.php",
        error: function(data){
            console.log(data);
          }
      });

      getProducts();
    })

    $(".bnt-save-product").on("click", function(){

      console.log("------Update------")
      $(".update-product-row").each(function(index, value)
      {
        var id = $(value).find(".product-id").text();
        var name = $(value).find(".product-name-input").val();
        var price =$(value).find(".product-price").val();
        var img = $(value).find(".product-img").attr("src");
        var cat = $(value).find(".categorie-select").val();
        var color = $(value).find(".color-text").val();

        $.ajax({ 
          type: "POST",
          dataType: "json",
          data:{
                id: id,
                name: name,
                price: price,
                img: img,
                cat: cat,
                color: color
              },
          url: "inc/admin/updateproduct.php"
        });
      });

      console.log("------Insert------");
      $(".insert-product-row").each(function(index, value)
      {
        var name = $(value).find(".product-name-input").val();
        var price =$(value).find(".product-price").val();
        var img = $(value).find(".product-img").attr("src");
        var cat = $(value).find(".categorie-select").val();
        var color = $(value).find(".color-text").val();

        if (name != "" && price != 0 && img != "" && color != "") 
        {
         $.ajax({ 
          type: "POST",
          dataType: "json",
          data:{
                name: name,
                price: price,
                img: img,
                cat: cat,
                color: color
              },
          url: "inc/admin/insertproduct.php"
        });
        }
      });

      getProducts();

    });

    $(".product-img").on("click", function(){

      productimg = $(this);

      imgUrl = $(this).attr('src');

      $(".imgUrl-input").val(imgUrl);
      $(".imgUrl-img").attr('src', imgUrl);

      $(".imgUrl-input").on("input", function(){
        $(".imgUrl-img").attr('src', $(this).val());
      });

      $(".btn-change-product-img").on("click", function(){

        productimg.attr('src', $(".imgUrl-img").attr('src'));

      });

    });

    $("table").on('input', ".insert-product-row input", function()
      {
        var oldVal = $(this).val();

        console.log(oldVal)

        $(this).val("");

        var input = $(this).closest("tr").clone();

        $(this).val(oldVal);

        var inputval = $(this).val();

        $(this).closest("tr").next().remove();

        if (inputval != "") 
        {

          $(input).find("input").val("");
          $(this).closest( "table" ).append(input);

        }
      });


  }

  function getCategories()
  {
    $.ajax({ 
          type: "GET",
          dataType: "json",
          url: "inc/admin/getcategories.php",

          success: function(data)
          {  
              console.table(data);

              mustache(data, "#categories-template", "#categories");
          }
      });

    $("table").on('input', ".insert-categories-row input", function()
      {
        var oldVal = $(this).val();

        console.log(oldVal)

        $(this).val("");

        var input = $(this).closest("tr").clone();

        $(this).val(oldVal);

        var inputval = $(this).val();

        $(this).closest("tr").next().remove();

        if (inputval != "") 
        {

          $(input).find("input").val("");
          $(this).closest( "table" ).append(input);

        }
      });
  }

  $("body").on("click", ".btn-delete-categories", function()
    {

      var id = $(this).val();

      $.ajax({ 
            type: "POST",
            dataType: "json",
            data:{
                  id: id
                },
            url: "inc/admin/deletecategories.php"
          });

      getCategories();

    });

      $("body").on("click", ".btn-save-categories", function()
    {

      $(".update-categories-row").each(function(index, value)
      {
        var id = $(value).find(".categorie-id").html();
        var name = $(value).find("input").val();

        console.log(name);

        $.ajax({ 
          type: "POST",
          dataType: "json",
          data:{
                id: id,
                name: name
              },
          url: "inc/admin/updatecategories.php"
        });

      });

      $(".insert-categories-row").each(function(index, value)
      {
        var name = $(value).find("input").val();

        if (name != "") 
        {

          $.ajax({ 
            type: "POST",
            dataType: "json",
            data:{
                  name: name
                },
            url: "inc/admin/insertcategories.php"
          });
        }

        name = "";
      });

      getCategories();

    });