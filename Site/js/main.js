$.getScript( "js/functions/function_mustache.js" );
$.getScript( "js/functions/function_debug.js" );

$( document ).ready(function() {

  	sal();

  	removeFromCard();
  	getCard();

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