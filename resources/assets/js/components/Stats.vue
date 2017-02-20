Vue.component('gradlead-stats-screen', {

    props: ['authUser', 'usertype', 'permissions'],

    mounted: function() {
		for (var i = 0; i < 20; ++i) {
      		this.d2.push([i, Math.sin(i)]);
    	}
    	this.d4 = this.getRandomData();

        plot1 = [
				  { 
					data: this.d0_1, label:'Jobs', 
                    points: { show: true, radius: 1}, 
                    splines: { show: this.showSpline, tension: 0.4, lineWidth: 1, fill: 0.8 } 
                  },
                  {	 
                    data: this.d0_2, label:'Profiles', 
                    points: { show: true, radius: 1}, 
                    splines: { show: this.showSpline, tension: 0.4, lineWidth: 1,   fill: 0.8 } 
                  }
                ]; 
        plot2 = [
                  { data: this.d4, lines: { show: true, lineWidth: 1, fill:true, fillColor: { colors: [{opacity: 0.2}, {opacity: 0.8}]}} }
                ]; 

        plot1C = [this.colors.info, this.colors.primary];
        plot2C = [this.colors.light];
    },

    data: function() {
        return {
            badges: [],
			data1: [ 106,108,110,105,110,109,105,104,107,109,105,100,105,102,101,99,98 ],
			data2: [ 105,102,106,107,105,104,101,99,98,109,105,100,108,110,105,110,109 ],
    		d: [ [1,6.5],[2,6.5],[3,7],[4,8],[5,7.5],[6,7],[7,6.8],[8,7],[9,7.2],[10,7],[11,6.8],[12,7] ],
    		d0_1: [ [0,7],[1,6.5],[2,12.5],[3,7],[4,9],[5,6],[6,11],[7,6.5],[8,8],[9,7] ],
    		d0_2: [ [0,4],[1,4.5],[2,7],[3,4.5],[4,3],[5,3.5],[6,6],[7,3],[8,4],[9,3] ],
    		d1_1: [ [10, 120], [20, 70], [30, 70], [40, 60] ],
    		d1_2: [ [10, 50],  [20, 60], [30, 90],  [40, 35] ],
    		d1_3: [ [10, 80],  [20, 40], [30, 30],  [40, 20] ],
    		d2: [],
			d4: [],

			plot1: [],
            plot2: [],
            plot1C: [],
            plot2C: [],
            plot1T: { content: 'Visits of %x.1 is %y.4',  defaultTheme: false, shifts: { x: 10, y: -25 } },
            plot2T: { content: '%s of %x.1 is %y.4',  defaultTheme: false, shifts: { x: 10, y: -25 } },

 		 	colors: {
          				primary: '#7266ba',
          				info:    '#23b7e5',
          				success: '#27c24c',
          				warning: '#fad733',
          				danger:  '#f05050',
          				light:   '#e8eff0',
          				dark:    '#3a3f51',
          				black:   '#1c2b36'
			},

            showSpline: true,
        };
    },

    events: {
    },

    computed: {
    },

    methods: {

		getRandomData: function() {
      		var data = [],
      		totalPoints = 150;
      		if (data.length > 0)
        		data = data.slice(1);
      		
			while (data.length < totalPoints) {
        		var prev = data.length > 0 ? data[data.length - 1] : 50,
          		y = prev + Math.random() * 10 - 5;
        		if (y < 0) {
          			y = 0;
        		} else if (y > 100) {
          			y = 100;
        		}
        		data.push(y);
      		}
      
			// Zip the generated y values with the x values
      		var res = [];
      		for (var i = 0; i < data.length; ++i) {
        		res.push([i, data[i]])
      		}
      		return res;
    	},

        // Ajax calls
        getStatus: function () {
            var self = this;
            this.$http.get('/badges')
                .then(function (resp) {
                    self.badges = resp.data;
                });
        },
    },

    filters: {
        capitalize: function(value) {
            return value[0].toUpperCase() + value.substring(1);
        },
    },
});
