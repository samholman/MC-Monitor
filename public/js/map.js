var Map = Class.create(
{
	initialize: function()
	{
		this.container = $('map');
		
		new Draggable('map');
	},
});

document.observe('dom:loaded', function() {
	if ($('map'))
	{
		new Map();
	}
});