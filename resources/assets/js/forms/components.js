Vue.component('spark-text', {
    props: ['display', 'form', 'name', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <input type="text" class="form-control spark-first-field" v-model="fieldValue">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
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

Vue.component('spark-hidden', {
    props: ['display', 'form', 'name', 'input'],
    template: '<input type="hidden" class="form-control" v-model="input" />'
});

Vue.component('spark-email', {
    props: ['display', 'form', 'name', 'input'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <input type="email" class="form-control spark-first-field" v-model="fieldValue">\
        <span class="help-block" v-show="form.errors.has(name)"> \
            <strong>{{ form.errors.get(name) }}</strong>\
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

Vue.component('spark-file', {
    props: ['display', 'form', 'name', 'input', 'warning'],

    template: '<div class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-4 control-label">{{ display }}</label>\
    <div class="col-md-6">\
        <input type="file" class="form-control spark-first-field" @change="onFileChange">\
        <p class="help-block"><span style="color: red">{{ warning }}</span> </p>\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
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
            <strong>{{ form.errors.get(name) }}</strong>\
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
            <strong>{{ form.errors.get(name) }}</strong>\
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
