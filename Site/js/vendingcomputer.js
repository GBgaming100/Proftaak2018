(function(window) {
  'use strict';
  var decoder = $('#qr-canvas'),
    sl = $('.scanner-laser'),
    si = $('#scanned-img'),
    sQ = $('#scanned-QR')
    $('[data-toggle="tooltip"]').tooltip();
  sl.css('opacity', .5);
  $( document ).ready(function() {
    if (typeof decoder.data().plugin_WebCodeCam == "undefined") {
      decoder.WebCodeCam({
        videoSource: {
          id: $('select#cameraId').val(),
          maxWidth: 640,
          maxHeight: 480
        },
        autoBrightnessValue: 120,
        resultFunction: function(text, imgSrc) {
          vendingdata(text);
        },
        getUserMediaError: function() {
          alert('Sorry, the browser you are using doesn\'t support getUserMedia');
        },
        cameraError: function(error) {
          var p, message = 'Error detected with the following parameters:\n';
          for (p in error) {
            message += p + ': ' + error[p] + '\n';
          }
          alert(message);
        }
      });
    } else {
      decoder.data().plugin_WebCodeCam.cameraPlay();
    }
  });

  function gotSources(sourceInfos) {
    for (var i = 0; i !== sourceInfos.length; ++i) {
      var sourceInfo = sourceInfos[i];
      var option = document.createElement('option');
      option.value = sourceInfo.id;
      if (sourceInfo.kind === 'video') {
        var face = sourceInfo.facing == '' ? 'unknown' : sourceInfo.facing;
        option.text = sourceInfo.label || 'camera ' + (videoSelect.length + 1) + ' (facing: ' + face + ')';
        videoSelect.appendChild(option);
      }
    }
  }
  if (typeof MediaStreamTrack.getSources !== 'undefined') {
    var videoSelect = document.querySelector('select#cameraId');
    $(videoSelect).change(function(event) {
      if (typeof decoder.data().plugin_WebCodeCam !== "undefined") {
        decoder.data().plugin_WebCodeCam.options.videoSource.id = $(this).val();
        decoder.data().plugin_WebCodeCam.cameraStop();
        decoder.data().plugin_WebCodeCam.cameraPlay(false);
      }
    });
    MediaStreamTrack.getSources(gotSources);
  } else {
    document.querySelector('select#cameraId').remove();
  }
}).call(window.Page = window.Page || {});

function vendingdata(value)
{
  console.log(value);
  
  var Time_out = value.split(",").pop();

  var now = new Date();
  var timenow = now.getTime();

  console.log(timenow - Time_out);

  if((timenow - Time_out) < 300000)
  {
    console.log(Time_out);

    var vendingId = value.substr(0, value.indexOf('(')); 

    var productsarray = value.substring(
        value.lastIndexOf("(") + 1, 
        value.lastIndexOf(")")
    );
    console.log("productsarray:" + productsarray);

    var userId = value.substring(
        value.lastIndexOf(")") + 1, 
        value.lastIndexOf(",")
    );;

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

      // stock van product gaat omlaag

      $.ajax({ 
        type: "POST",
        dataType: "json",
        data:{
          vendingId: vendingId,
          productPosition: value
        },

        url: "inc/vending/removestock.php"
      });

      // elk product waar het postion- en user-id zijn gebruik word verwijderd uit het winkelmandje.

      

      // geld word van rekening afgehaald

      // transactie toevoegen aan transacties tabel

      $.ajax({ 
        type: "POST",
        dataType: "json",
        data:{
          userId: userId,
          vendingId: vendingId,
          productPosition: value
        },

        url: "inc/user/paymoney.php"
      });

    });
  }
  else
  {
    console.log("Code is too old!");
  }

}