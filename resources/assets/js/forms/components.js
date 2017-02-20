Vue.component('spark-text', {
    props: ['display', 'form', 'name', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <input type="text" class="form-control spark-first-field" v-model="fieldValue">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <small>{{ form.errors.get(name) }}</small>\
        </span>\
    </div>\
</div>',

    watch: {
        'fieldValue': function (v) {
            this.form[this.name] = v;
        },
        'input': function (v) {
            this.fieldValue = this.input;
        }
    },
    mounted: function () {
        this.fieldValue = this.input;
    },
    data: function () {
        return {
            fieldValue: ''
        }
    }
});

Vue.component('spark-text2', {
    props: ['display', 'form', 'name', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="control-label">{{ display }}</label>\
        <input type="text" class="form-control spark-first-field" v-model="fieldValue">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <small>{{ form.errors.get(name) }}</small>\
        </span>\
</div>',

    watch: {
        'fieldValue': function (v) {
            this.form[this.name] = v;
        },
        'input': function (v) {
            this.fieldValue = this.input;
        }
    },
    mounted: function () {
        this.fieldValue = this.input;
    },
    data: function () {
        return {
            fieldValue: ''
        }
    }
});

Vue.component('spark-textarea', {
    props: ['display', 'form', 'name', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="control-label">{{ display }}</label>\
        <textarea class="form-control spark-first-field" v-model="fieldValue" style="height:120px"></textarea>\
        <span class="help-block" v-show="form.errors.has(name)">\
            <small>{{ form.errors.get(name) }}</small>\
        </span>\
</div>',

    watch: {
        'fieldValue': function (v) {
            this.form[this.name] = v;
        },
        'input': function (v) {
            this.fieldValue = this.input;
        }
    },
    mounted: function () {
        this.fieldValue = this.input;
    },
    data: function () {
        return {
            fieldValue: ''
        }
    }
});


Vue.component('spark-hidden', {
    props: ['display', 'form', 'name', 'input'],
    template: '<input type="hidden" class="form-control" v-model="fieldValue" />',
    watch: {
        'fieldValue': function (v) {
            this.form[this.name] = v;
        },
        'input': function (v) {
            this.fieldValue = this.input;
        }
    },
    mounted: function () {
        this.fieldValue = this.input;
    },
    data: function () {
        return {
            fieldValue: ''
        }
    }
});

Vue.component('spark-email', {
    props: ['display', 'form', 'name', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <input type="email" class="form-control spark-first-field" v-model="fieldValue">\
        <span class="help-block" v-show="form.errors.has(name)"> \
            <small>{{ form.errors.get(name) }}</small>\
        </span>\
    </div>\
</div>',
    watch: {
        'fieldValue': function (v) {
            this.form[this.name] = v;
        },
        'input': function (v) {
            this.fieldValue = this.input;
        }
    },
    mounted: function () {
        this.fieldValue = this.input;
    },
    data: function () {
        return {
            fieldValue: ''
        }
    }
});

Vue.component('spark-file-simple', {
    props: ['display', 'form', 'name', 'input', 'warning'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <input type="file" data-edit="insertImage" class="form-control spark-first-field" v-on:change="updateFile">\
        <p class="help-block"><span style="color: red">{{ warning }}</span> </p>\
        <span class="help-block" v-show="form.errors.has(name)">\
            <small>{{ form.errors.get(name) }}</small>\
        </span>\
    </div>\
</div>',
    watch: { },
    mounted: function () { },
    data: function () { return { } },
    methods: { 
        updateFile: function(file) {
            console.log(file);
            console.log(file.target.files[0]);
            this.form[this.name] = file.target.files[0];
        },
    },
});

Vue.component('spark-file', {
    props: ['display', 'form', 'name', 'input', 'warning'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <input type="file" class="form-control spark-first-field" @change="onFileChange">\
        <p class="help-block"><span style="color: red">{{ warning }}</span> </p>\
        <span class="help-block" v-show="form.errors.has(name)">\
            <small>{{ form.errors.get(name) }}</small>\
        </span>\
    </div>\
</div>',
    watch: {
        'fieldValue': function (v) {
            this.form[this.name] = v;
        },
        'input': function (v) {
            this.fieldValue = this.input;
        }
    },
    mounted: function () {
        this.fieldValue = this.input;
    },
    data: function () {
        return {
            fieldValue: ''
        }
    },

    methods: {
        onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createFile(files[0]);
            },
            createFile(file) {
                var reader = new FileReader();
                var vm = this;
                reader.onload = (e) => {
                    vm.fieldValue = e.target.result
                };
                reader.readAsDataURL(file);
            },
    },
});

Vue.component('spark-password', {
    props: ['display', 'form', 'name', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <input type="password" class="form-control spark-first-field" v-model="fieldValue">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <small>{{ form.errors.get(name) }}</small>\
        </span>\
    </div>\
</div>',
    watch: {
        'fieldValue': function (v) {
            this.form[this.name] = v;
        },
        'input': function (v) {
            this.fieldValue = this.input;
        }
    },
    mounted: function () {
        this.fieldValue = this.input;
    },
    data: function () {
        return {
            fieldValue: ''
        }
    },
});

Vue.component('spark-select', {
    props: ['display', 'form', 'name', 'items', 'input', 'placetext'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <select class="form-control spark-first-field" v-model="fieldValue" :placeholder="placetext">\
            <option v-for="item in items" :value="item.value">\
                {{ item.text }}\
            </option>\
        </select>\
        <span class="help-block" v-show="form.errors.has(name)">\
            <small>{{ form.errors.get(name) }}</small>\
        </span>\
    </div>\
</div>',
    watch: {
        'fieldValue': function (v) {
            this.form[this.name] = v;
        },
        'input': function (v) {
            this.fieldValue = this.input;
        }
    },
    mounted: function () {
        this.fieldValue = this.input;
    },
    data: function () {
        return {
            fieldValue: ''
        }
    },
});

Vue.component('spark-date', {
    props: ['display', 'form', 'name', 'input'],

    components: {
        Datepicker
    },

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
       <div class="form-group">\
          <label class="col-md-4 control-label">{{ display }}</label>\
          <div class="col-md-6">\
            <datepicker v-model="fieldValue" :input-class="\'form-control\'"></datepicker>\
        	<span class="help-block" v-show="form.errors.has(name)">\
            	<small>{{ form.errors.get(name) }}</small>\
        	</span>\
          </div>\
        </div>',

    watch: {
        'fieldValue': function (v) {
            this.form[this.name] = v;
        },
        'input': function (v) {
            this.fieldValue = this.input;
        }
    },
    mounted: function () {
        this.fieldValue = this.input;
    },
    data: function () {
        return {
            fieldValue: ''
        }
    },
});

Vue.component('spark-progressbar', {
    props: ['type','clss','value','max','percent'],

   template: '<div class="progress" style="height:3px">\
    		  	<div :class="getClass()" role="progressbar" \
					 :aria-valuenow="getValue()" :aria-valuemin="0" :aria-valuemax="getMax()" :style="getStyle()" \
					 :aria-valuetext="getValueText()"></div>\
			 </div>',
    watch: {
        'percent': function(v) {
            this.p = v;
        },
    },
    mounted: function () {
        this.p = (this.percent>0) ? this.percent:0;
    },
    data: function () {
        return {
            p: 0,
        }
    },
	methods:  {
		getValue: function () { return this.value; },
		getValueText: function () { return this.p + '%'; },
		getMax: function () { return this.max; },
		getClass: function () { return  "progress-bar progress-bar-"+this.type+' '+ this.clss; },
		getStyle: function () { return 'width: '+ this.p + '%'; },
	},
});
