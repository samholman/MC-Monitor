var Map = Class.create(
{
	initialize: function()
	{
		this.mapContainer = $('map');
		
		this.dimensions = this.mapContainer.up(".mapBox").getDimensions();
		
		new Draggable('map', {onEnd: this.catchDrop.bind(this)});
	},
	
	catchDrop: function(event)
	{
		this.dimensions = this.mapContainer.up(".mapBox").getDimensions();
		
		var mapPos = $('map').positionedOffset();
		
		//if map goes too far right, bring it back a bit
		if(mapPos[0] > this.dimensions.width)
		{
			this.mapContainer.setStyle({
				'left': '0px'
			});
		}
		
		//if map goes too far down, bring it back a bit
		if(mapPos[1] > this.dimensions.height)
		{
			this.mapContainer.setStyle({
				'top': '0px'
			});
		}
	}
});

document.observe('dom:loaded', function() {
	if ($('map'))
	{
		new Map();
	}
});