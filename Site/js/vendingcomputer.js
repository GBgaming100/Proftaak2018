$( document ).ready(function() {

  scanner(false);

});

function scanner(active)
{
    //makes a new QR code reader
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

    //searchers the camera input for a QR code
    scanner.addListener('scan', function (content) 
    {
      vendingdata(content);

      //checks if the content contains a website
      if(content.indexOf("https") != -1 || content.indexOf("http") != -1)
      {
        window.open(content,'_blank')
      }
    });

    if(active == false)
    {
      active = true;

      //turns the webcam on
      Instascan.Camera.getCameras().then(function (cameras) {
        //checks if the computer has any cameras
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
    }
    else
    {
      active = false;

      //turns the webcam off
      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.stop(cameras[0]);
        }
      }).catch(function (e) {
        console.error(e);
      });
    }
}

function vendingdata(value)
{
  var vendingId = value.substr(0, value.indexOf('(')); 

  var productsarray = value.substring(
      value.lastIndexOf("(") + 1, 
      value.lastIndexOf(")")
  );

  var userId = value.split(")").pop();

  console.log("User:" + userId);

  var products = [];

  var p = productsarray.length;
  var number = "";

  for (p = 0; p < productsarray.length; p++) { 

    if (productsarray.charAt(p) == ",") 
    {
      products.push(number);
      number = "";
    }
    else
    {
      number += productsarray.charAt(p);
    }
  }

  products.push(number);
  number = "";

  console.table(products);

  $.each(products, function(index, value){

    // voor elke position word het product er uit gehaald

    console.log(value);

    $.ajax({
        url: "http://192.168.0.40/", //IP of Arduino
        type: "POST",
        data: {$vendingId: vendingId, productPosition: value+"@"},
        dataType: 'jsonp',
        contentType: 'application/json',
        crossDomain: true,

    });

    // elk product waar het postion- en user-id zijn gebruik word verwijderd uit het winkelmandje.

    // geld word van rekening afgehaald

    // transactie toevoegen aan transacties tabel

  });

}