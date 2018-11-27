function mustache(data, template, outerTemplate)
{
	console.table(data);
	
	if ($(outerTemplate).data('template')) 
		{
			var template = $(outerTemplate).data('template');
		}
	else
		{
			var template = $(template).html();
			$(outerTemplate).data('template', template);
		}

	var renderTemplate = Mustache.render(template, data);

	$(outerTemplate).html(renderTemplate);
}