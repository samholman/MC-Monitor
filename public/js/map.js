var Map = Class.create(
{
	initialize: function()
	{
		this.mapContainer = $('map');
		
		this.mapDimensions = this.mapContainer.getDimensions();
		this.containerDimensions = this.mapContainer.up(".mapBox").getDimensions();
		
		new Draggable('map', {onEnd: this.catchDrop.bind(this)});
	},
	
	catchDrop: function(event)
	{
		this.mapDimensions = this.mapContainer.down("img").getDimensions();
		this.containerDimensions = this.mapContainer.up(".mapBox").getDimensions();
		
		var mapPos = $('map').positionedOffset();
		
		//if map goes too far right, bring it back a bit
		if(mapPos[0] > this.containerDimensions.width)
		{
			this.mapContainer.setStyle({
				'left': '0px'
			});
		}
		
		//if map goes too far down, bring it back a bit
		if(mapPos[1] > this.containerDimensions.height)
		{
			this.mapContainer.setStyle({
				'top': '0px'
			});
		}
		
		//if map goes too far left, bring it back a bit
		if(mapPos[0] < (this.mapDimensions.width*-1))
		{
			var newPos = this.mapDimensions.width*-1 + this.containerDimensions.width;
			this.mapContainer.setStyle({
				'left': newPos +'px'
			});
		}
		
		//if map goes too far up, bring it back a bit
		if(mapPos[1] < (this.mapDimensions.height*-1))
		{
			var newPos = this.mapDimensions.height*-1 + this.containerDimensions.height;
			this.mapContainer.setStyle({
				'top': newPos +'px'
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