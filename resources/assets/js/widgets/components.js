Vue.component('gradlead-sparkline-bar', {
    props: ['data'],
    template: '<div ui-jq="sparkline" ui-options="data, {type:\'bar\', height:20, barWidth:5, barSpacing:1, barColor:\'#dce5ec\'}" class="sparkline inline">loading...</div>', 
    mounted: function () {
        this.d = this.data;
    },
    data: function () {
        return {
            d: [],
        }
    }
});

Vue.component('gradlead-plot', {
    props: ['data','showSpline', 'colors','tips'],
    template: '<div ui-jq="plot" ui-refresh="refresh" ui-options="options" style="height:246px"></div>', 
    mounted: function () {
        this.options.push(this.data);
        this.options.push(this.uioptions);
		this.refresh = showSpline;
    },
    watch: {
        'showSpline': function (v) {
            this.refresh = this.showSpline;
        },
    },
    data: function () {
        return {
			refresh: true,
            options: [],
            uioptions: { 
                colors: this.colors, 
                series: { shadowSize: 3 },
                xaxis:{ font: { color: '#a1a7ac' } },
                yaxis:{ font: { color: '#a1a7ac' }, max:20 },
                grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#dce5ec' },
                tooltip: true,
                tooltipOpts: this.tips
              },      
		}
    }
});
