$.getScript( "js/functions/function_mustache.js" );
$.getScript( "js/functions/function_debug.js" );

var user = $("#mycard").data("user");
console.log(user);

$( document ).ready(function() {
	navbarSpacer();
  	sal();

  	removeFromCard();
  	getCard();
  	cardPay();

  	alerts();

  	lazyloading();

  	transactions();
});

$(window).resize(function(){

	

})


function removeFromCard()
{

	$("body").on("click", ".btn-deleteCardItem", function(){

		var id = $(this).data("product");

		// console.log(id);

		$.ajax({ 
			type: "POST",
			dataType: "json",
			data: {
				productId: id,
				userId: user
			},

			url: "inc/card/removeFromCard.php"
			
		});


		getCard();

		alerts();
		alerts();
	});

}

function getCard()
{	
	$.ajax({ 
			type: "POST",
			dataType: "json",
			data: {
				userId: user
			},

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

					saldo(value);

				});


			}
		});
}

function saldo(value)
{
	var totalPrice = 0.00;

	$.each(value['card'], function(index, value)
	{
		totalPrice += parseFloat(value['price']);
	});

	// console.log("Total Prince: €" + totalPrice);

	$("#totalPrice-"+value['id']).text(totalPrice);

	var currentSaldo = $("#saldoCurrent-"+value['id']).text();

	var saldoAfter = (currentSaldo - totalPrice).toFixed(2);4
	
	var saldoField = $("#saldoAfter-"+value['id']);

	saldoField.text(saldoAfter);

	if (saldoAfter < 0) 
	{
		saldoField.css("color", "red");
	}
}

function cardPay()
{

	$("body").on("click", ".btn-genratebarcode", function()
	{
		var id = $(this).val();

		$.ajax({ 
			type: "POST",
			dataType: "json",
			data:{
				machine: id
			},

			url: "inc/card/receiveposition.php",

			success: function(data)
			{  

				// console.log(data);

				var string = "";

				string = id + "(";
				var positions = [];

				$.each(data['positions'], function(index, value)
				{

					positions.push(value['position']);

				})
				string += positions;
				string += ")";

				string += data['user'];
				string += ",";

				var now = new Date();
    			var timenow = now.getTime();

				string += timenow;

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

function alerts()
{

	$.ajax({ 
		type: "GET",
		dataType: "json",

		url: "inc/messages/messages.php",

		success: function(data)
		{  

			$.each(data, function(i, v)
			{
				$(".alert-container").append('<div class="alert alert-'+v['Type']+' m-t-1 text-xs-center" role="alert"><i class="'+v['Icon']+' fa-fw fa-lg"></i> '+v['Text']+'</div>');
				$(".alert:last-child").slideUp( 0 ).slideDown( "slow" ).delay( 8000 ).slideUp( "slow" );
			})

		}
	});
}

function lazyloading()
{
	var lazy = [];

	registerListener('load', setLazy);
	registerListener('load', lazyLoad);
	registerListener('scroll', lazyLoad);
	registerListener('resize', lazyLoad);

	function setLazy(){    
	    lazy = document.getElementsByClassName('lazy');
	    // console.log('Found ' + lazy.length + ' lazy images');
	} 

	function lazyLoad(){
	    for(var i=0; i<lazy.length; i++){
	        if(isInViewport(lazy[i])){
	            if (lazy[i].getAttribute('data-full-src')){
	                lazy[i].src = lazy[i].getAttribute('data-full-src');
	                lazy[i].removeAttribute('data-full-src');
	            }
	        }
	    }
	    
	    cleanLazy();
	}

	function cleanLazy(){
	    lazy = Array.prototype.filter.call(lazy, function(l){ return l.getAttribute('data-full-src');});
	}

	function isInViewport(el){
	    var rect = el.getBoundingClientRect();
	    
	    return (
	        rect.bottom >= 0 && 
	        rect.right >= 0 && 
	        rect.top <= (window.innerHeight + 150 || document.documentElement.clientHeight + 150) && 
	        rect.left <= (window.innerWidth || document.documentElement.clientWidth)
	     );
	}

	function registerListener(event, func) {
	    if (window.addEventListener) {
	        window.addEventListener(event, func)
	    } else {
	        window.attachEvent('on' + event, func)
	    }
	}

	
}

function imgWidth(imgClass, classOfElementForWitdh)
{
	$(imgClass).attr("width", $(classOfElementForWitdh).width());
}


var totalShown = 5;
var expandWith = 5;
var maxAmount = 0;
function transactions()
{
	console.log("transactions ready");
	$.ajax({ 
			type: "POST",
			dataType: "json",
			data:{
				userId: user
			},

			url: "inc/user/gettransactions.php",

			success: function(data)
			{  
				$.each(data, function(index){
					maxAmount++;
				})
				data = data.slice(0, totalShown);
				mustache(data, "#transactions-template", "#transactions");

			}
		});
}

$(".btn-loadmore").on("click", function(){
		console.log(maxAmount)
		
		if (totalShown + expandWith < maxAmount) {
			totalShown += expandWith;
		}

		transactions()
	});

function navbarSpacer()
{
	var spacer = $(".navbar-spacer");
	$(".navbar-spacer").css("margin-top", ( $(".navbar").height() + 30 ) + "px");
}