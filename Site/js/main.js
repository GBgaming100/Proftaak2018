$.getScript( "js/functions/function_mustache.js" );
$.getScript( "js/functions/function_debug.js" );


$( document ).ready(function() {

  	sal();

  	removeFromCard();
  	getCard();
  	cardPay();

});


function removeFromCard()
{

	$("body").on("click", ".btn-deleteCardItem", function(){
		var id = $(this).data("product");

		console.log(id);

		$.ajax({ 
			type: "POST",
			dataType: "json",
			data: {
				productId: id
			},

			url: "inc/card/removeFromCard.php"
			
		});

		getCard();
	});

}

function getCard()
{
	$.ajax({ 
			type: "GET",
			dataType: "json",

			url: "inc/card/receiveCard.php",

			error: function(e)
			{

				emptydata = [];
				mustache(emptydata, "#card-items-template", "#card-items");

				$("#card-items").text("Mijn Lijst is leeg")
			},

			success: function(data)
			{  

				mustache(data, "#card-items-template", "#card-items");


				$.each(data, function(index, value)
				{
					var totalPrice = 0.00;

					$.each(value['card'], function(index, value)
					{
						totalPrice += parseFloat(value['price']);
					});

					console.log(totalPrice);

					// $(".totalPrice").text(totalPrice);
				});

				// saldo(totalPrice);

			}
		});
}

function saldo(totalPrice)
{
	var currentSaldo = $("#saldoCurrent").text();

	var saldoAfter = (currentSaldo - totalPrice).toFixed(2);

	var saldoField = $("#saldoAfter");

	saldoField.text(saldoAfter);

	if (saldoAfter < 0) 
	{
		saldoField.css("color", "red");
	}
	else
	{
		saldoField.css("color", "green");
	}
}

function cardPay()
{

	$("body").on("click", ".btn-genratebarcode", function()
	{
		var id = ($(this).val() - 1);

		$.ajax({ 
			type: "GET",
			dataType: "json",

			url: "inc/card/receiveCard.php",

			success: function(data)
			{  
				var string = "1(1,2,3,4)";

				string = (id + 1) + "(";
				var products = data[id]['card'];
				var productIds = [];

				$.each(products, function(index, value)
				{

					productIds.push(value['id']);

				})
				string += productIds;
				string += ")";


				console.log(string);
				generateQR("#testQR", string, "svg");
			}
		});
	});
}

function generateQR(container, text, type){
	console.log("runnning")
  $(container).html('');
  $(container).qrcode({
    // render method: 'canvas', 'image' or 'div'
    render: type,

    // version range somewhere in 1 .. 40
    minVersion: 1,
    maxVersion: 40,

    // error correction level: 'L', 'M', 'Q' or 'H'
    ecLevel: 'L',

    // offset in pixel if drawn onto existing canvas
    left: 0,
    top: 0,

    // size in pixel
    // size: 500,

    // code color or image element
    fill: '#000',

    // background color or image element, null for transparent background
    background: null,

    // content
    text: text,

    // corner radius relative to module width: 0.0 .. 0.5
    radius: 0,

    // quiet zone in modules
    quiet: 0,

    // modes
    // 0: normal
    // 1: label strip
    // 2: label box
    // 3: image strip
    // 4: image box
    mode: 0,

    mSize: 0.1,
    mPosX: 0.5,
    mPosY: 0.5,

    label: 'no label',
    fontname: 'sans',
    fontcolor: '#000',

    image: null
  });
}