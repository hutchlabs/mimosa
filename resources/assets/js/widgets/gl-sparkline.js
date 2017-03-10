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
