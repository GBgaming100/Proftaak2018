var dataArray = [];

var debug = true;

var url = window.location.href;

if (get_hostname(url) == "http://renegadenetwork.tk")
{
	debug = false;
}

function get_hostname(url) {
    var m = url.match(/^http:\/\/[^/]+/);
    console.log(m ? m[0] : null);
    return m ? m[0] : null;
}

function debugArray(array)
{
	if (debug == true) 
	{
		console.table(array);
	}
}

function debug(val)
{
	if (debug == true) 
	{
		console.log(val);
	}
}