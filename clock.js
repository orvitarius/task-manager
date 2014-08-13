

var clock = {
	
	hours   : 0,
	minutes : 0,
	seconds : 0,
	
	
	setClock: function() {
		this.hours = 0;
		this.minutes = 0;
		this.seconds = 0;
	},
	
	secondUp: function() {
		this.seconds ++;
		if (this.seconds > 59) {
			this.seconds = 0;
			this.minutes ++;
			if (this.minutes > 59) {
				this.hours ++;
			}
		}
		//console.log('sec: '+this.seconds);
	},
	
	
	start: function() {
		this.setClock();
		var that = this;
		setInterval(function() {
		    that.secondUp();
		    //console.log('hola');
		}, 1000);
	},
	
	
};