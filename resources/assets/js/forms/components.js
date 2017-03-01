var _moment = require('moment');

Vue.component('gl-checkbox', {
    props: ['display', 'form', 'name', 'input'],

    template: '<div class="form-group pull-in clearfix" :class="{\'has-error\': form.errors.has(name)}">\
                 <div class="form-group">\
                      <div class="col-sm-12">\
                           <div class="checkbox" style="margin-top:25px">\
                              <label class="i-checks">\
                         		<input type="checkbox" v-model="fieldValue" :id="name" :name="name" class="form-control"><i></i> {{ display }}\
                              </label>\
                           </div>\
                  	   </div>\
                	</div>\
              	</div>',

    watch: {
        'fieldValue': function (v) { this.form[this.name] = v; },
        'input': function (v) { this.fieldValue = this.input; }
    },
    mounted: function () {
        this.fieldValue = this.input;
    },
    data: function () {
        return { fieldValue: ''}
    },
});


Vue.component('gl-date', {
    props: ['display', 'form', 'name', 'input', 'placeholder', 'start'],

    components: { 'date-picker': myDatepicker },

    template: '<div class="form-group pull-in clearfix" :class="{\'has-error\': form.errors.has(name)}">\
          <div class="col-sm-12">\
            <label class="control-label">{{ display }}</label>\
            <date-picker :name="name" :date="startTime" :option="option" :limit="limit"></date-picker>\
        	<span class="help-block" v-show="form.errors.has(name)">\
            	<small>{{ form.errors.get(name) }}</small>\
        	</span>\
          </div>\
        </div>',

    watch: {
        'start': function(v) {
            this.limit[0].from = v;
        }
    },

    mounted: function () {
        var self = this;
        //console.log(this.name+" Date: "+this.input);
        this.startTime = (this.input=='') ? { time: '' } : { time: this.input };
        this.option.placeholder = (this.placeholder=='') ? this.option.placeholder : this.placeholder;

        if (this.start) { this.limit[0].from = this.start; }

        bus.$on('change_'+this.name, function (time) { self.form[self.name] = time; });
    },

    data: function () {
        return {
 			startTime: { time: '' },
      		endtime: { time: '' },

      		option: {
		        type: 'day',
		        week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
		        month: ['January','February','March','April','May','June','July','August','September','October','November','December'],
		        format: 'YYYY-MM-DD',
		        placeholder: 'when?',
		        inputStyle: {
		          'display': 'inline-block',
		          'padding': '6px',
		          'line-height': '22px',
		          'font-size': '16px',
		          'border': '2px solid #fff',
		          'box-shadow': '0 1px 3px 0 rgba(0, 0, 0, 0.2)',
		          'border-radius': '2px',
		          'color': '#5F5F5F'
		        },
		        color: { header: '#29d9c2', headerText: '#fff' },
		        buttons: { ok: 'Ok', cancel: 'Cancel' },
		        overlayOpacity: 0.5, // 0.5 as default
		   	},
			limit: [ { type: 'fromto', from: _moment().format('YYYY-MM-DD'), to: '2050-01-01' }],
        }
    },
});

Vue.component('gl-file', {
    props: ['display', 'form', 'name', 'input','filename', 'warning'],

    template: '<div class="form-group pull-in clearfix" :class="{\'has-error\': form.errors.has(name)}">\
                <div class="col-md-12">\
                    <label class="control-label">{{ display }}</label>\
                    <input type="file" class="form-control" @change="onFileChange">\
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
        'fieldName': function (v) {
            this.$emit('updated',v);
        },
        'input': function (v) {
            this.fieldValue = this.input;
        }
    },
    mounted: function () {
        this.fieldValue = this.input;
		this.fieldName = this.filename;
    },
    data: function () {
        return {
            fieldValue: '',
			fieldName: ''
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
				this.fieldName = file.name;
                reader.onload = (e) => {
                    vm.fieldValue = e.target.result
                };
                reader.readAsDataURL(file);
            },
    },
});

Vue.component('gl-location', {

    props: ['display', 'form', 'name', 'id', 'input', 'placeholder'],

    template: '<div class="form-group pull-in clearfix" :class="{\'has-error\': form.errors.has(name)}">\
                    <div class="col-sm-12">\
                       <label class="control-label">{{ display }}</label>\
                       <input class="form-control" :placeholder="placeholder" :id="id" type="text">\
                        <span class="help-block" v-show="form.errors.has(name) || (sent && isInValid())">\
                            <small v-if="sent && isInValid()">Please enter correct address</small>\
                            <small v-else>{{ form.errors.get(name) }}</small>\
                        </span>\
                    </div>\
                </div>',

	data: function () {
			return {
                ref: null,
				autocomplete: null,
				address: '',
                place: '',
                sent: false,

			}
	},

	computed: { },

    mounted: function() {
        //Loader.load(() => { return this.boot(this); });
        this.boot();
	},

	watch: {
        'place': function(address) {
           if (Object.keys(address).length > 0) {
               this.address = address;
               this.form['country'] = address.country;
               this.form['city'] = address.locality;
               this.form['neighborhood'] = address.neighborhood;
           }
		}
	},

	methods:
	{
       boot: function() {
                var self =  this;
		        this.ref = document.getElementById(this.id);
                if (typeof google !='undefined') {
                    this.autocomplete = new google.maps.places.Autocomplete(this.ref, { types: ['geocode'] });
                    this.autocomplete.addListener('place_changed', function() {
                            let data  = {};
                            let place = self.autocomplete.getPlace();
                            let googleInputs = window.GOOGLE_AUTOCOMPLETE.inputs;
                            if (typeof place != 'undefined') {
                                if (place.address_components !== undefined) {
                                    for (let i = 0; i < place.address_components.length; i++) {
                                        let input = place.address_components[i].types[0];
                                        if (googleInputs[input]) {
                                            data[input] = place.address_components[i][googleInputs[input]];
                                        }
                                    }
                                    self.place = JSON.parse(JSON.stringify(data));
                                }
                            } else {
                                self.sent=true;
                            }
                    });
                }
                //console.log("Location: "+this.input);
                if (this.input != '')  { this.ref.value= this.input; }
        },
        isValid: function() { return (this.place!=null) && (Object.keys(this.place).length > 0); },
        isInValid: function() { return !this.isInValid(); },
        hasAutocompleteInstance: function() { return this.autocomplete != null; },
	}
});

Vue.component('gl-text', {
    props: ['display', 'form', 'name', 'input','maxlength','placeholder'],

    template: '<div class="form-group pull-in clearfix" :class="{\'has-error\': form.errors.has(name)}">\
                    <div class="col-sm-12">\
                        <label class="control-label">{{ display }}</label>\
                        <input :placeholder="placeholder" :name="name" type="text" class="form-control" v-model="fieldValue">\
                        <span class="help-block" v-show="form.errors.has(name)">\
                            <small>{{ form.errors.get(name) }}</small>\
                        </span>\
                    </div>\
                </div>',

    watch: {
        'fieldValue': function (v) {
            if (v!=null) {
                if (v.length > this.textLength) {
                    this.form.set(this.textError);
                } else {
                    this.form[this.name] = v;
                }
            }
        },
        'input': function (v) {
            this.fieldValue = this.input;
        }
    },
    mounted: function () {
        this.fieldValue = this.input;
        this.textLength = (typeof this.maxlength != 'Undefined') ? this.maxlength : this.textLength;
        this.textError[this.name] = ['Value cannot be longer than '+this.textLength+' characters'];
    },
    data: function () {
        return {
            fieldValue: '',
            textLength: 255,
            textError: {},
        }
    }
});

Vue.component('gl-textarea', {
    props: ['id','display', 'form', 'name', 'input', 'placeholder'],

    template: '<div class="form-group pull-in clearfix" :class="{\'has-error\': form.errors.has(name)}">\
                <div class="col-sm-12">\
                    <label class="control-label">{{ display }}</label><br/>\
                    <div :id="id" :name="name" style="height: 100px"></div>\
                    <span class="help-block" v-show="form.errors.has(name)">\
                        <small>{{ form.errors.get(name) }}</small>\
                    </span>\
                </div>\
               </div>',

    watch: {},

    mounted: function () {
        this.config.placeholder = this.placeholder;
        this.initQuill(this.input);
    },

    data: function () {
        return {
            quill: '',
            config: {
                    placeholder: '',
                    theme: 'snow',
                    modules: {
                        toolbar: [
                           ['bold', 'italic'],
                           ['link', 'blockquote', 'image'],
                           [{ list: 'ordered' }, { list: 'bullet' }],
                       ]
                    },
            },

        }
    },
    methods: {
        initQuill: function(text) {
            var self = this;
            this.quill = new Quill('#'+this.id, this.config);
            this.quill.setText(text);
            this.quill.on('text-change', function(change) {
                self.form[self.name] = self.quill.getText();
            });
        }
    },
});

Vue.component('gl-select', {
    props: ['display', 'form', 'name', 'items', 'input', 'placetext'],

    template: '<div class="form-group pull-in clearfix" :class="{\'has-error\': form.errors.has(name)}">\
                    <div class="col-sm-12">\
                       <label class="control-label">{{ display }}</label><br/>\
                        <select :name="name" class="form-control" v-model="fieldValue" :placeholder="placetext">\
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
        'fieldValue': function (v) { this.form[this.name] = v; },
        'input': function (v) { this.fieldValue = this.input; }
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


// ----------------


Vue.component('spark-text', {
    props: ['display', 'form', 'name', 'input','maxlength','placeholder'],

    template: '<div class="form-group pull-in clearfix" :class="{\'has-error\': form.errors.has(name)}">\
                    <div class="col-sm-12">\
                        <label>{{ display }}</label>\
                        <input :placeholder="placeholder" :name="name" type="text" class="form-control" v-model="fieldValue">\
                        <span class="help-block" v-show="form.errors.has(name)">\
                            <small>{{ form.errors.get(name) }}</small>\
                        </span>\
                    </div>\
                </div>',

    watch: {
        'fieldValue': function (v) {
            if (v!=null) {
                if (v.length > this.textLength) {
                    this.form.set(this.textError);
                } else {
                    this.form[this.name] = v;
                }
            }
        },
        'input': function (v) {
            this.fieldValue = this.input;
        }
    },
    mounted: function () {
        this.fieldValue = this.input;
        this.textLength = (typeof this.maxlength != 'Undefined') ? this.maxlength : this.textLength;
        this.textError[this.name] = ['Value cannot be longer than '+this.textLength+' characters'];
    },
    data: function () {
        return {
            fieldValue: '',
            textLength: 255,
            textError: {},
        }
    }
});

Vue.component('spark-select', {
    props: ['display', 'form', 'name', 'items', 'input', 'placetext'],

    template: '<div class="form-group pull-in clearfix" :class="{\'has-error\': form.errors.has(name)}">\
                    <div class="col-sm-12">\
                       <label>{{ display }}</label><br/>\
                        <select class="form-control" v-model="fieldValue" :placeholder="placetext">\
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
            this.form[this.name] = file.target.files[0];
        },
    },
});

Vue.component('spark-file', {
    props: ['display', 'form', 'name', 'input','filename', 'warning'],

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
        'fieldName': function (v) {
            this.$emit('updated',v);
        },
        'input': function (v) {
            this.fieldValue = this.input;
        }
    },
    mounted: function () {
        this.fieldValue = this.input;
		this.fieldName = this.filename;
    },
    data: function () {
        return {
            fieldValue: '',
			fieldName: ''
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
				this.fieldName = file.name;
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

Vue.component('spark-checkbox', {
    props: ['display', 'form', 'name', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
         <div class="form-group">\
              <label class="col-md-4 control-label">{{ display }}</label>\
              <div class="col-sm-6">\
                   <div class="checkbox">\
                      <label class="i-checks">\
                 		<input type="checkbox" v-model="fieldValue" :id="name" :name="name" class="form-control"><i></i> \
                      </label>\
                   </div>\
          	   </div>\
        	</div>\
      	</div>',

    watch: {
        'fieldValue': function (v) { this.form[this.name] = v; },
        'input': function (v) { this.fieldValue = this.input; }
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
