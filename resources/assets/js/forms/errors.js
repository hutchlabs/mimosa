window.SparkFormErrors = function () {
    this.errors = {};
    this.rerrors = {};

    this.hasErrors = function () { return !_.isEmpty(this.errors); };
    this.hasrErrors = function () { return !_.isEmpty(this.rerrors); };

    this.has = function (field) { return _.indexOf(_.keys(this.errors), field) > -1; };

    this.all = function () { return this.errors; };

    this.flatten = function () { return _.flatten(_.toArray(this.errors)); };

    this.get = function (field) {
        if (this.has(field)) {
            return this.errors[field][0];
        }
    };

    this.set = function (errors) {
        if (typeof errors === 'object') {
            this.errors = errors;
        } else {
            this.errors = {'field': ['Something went wrong. Please try again.']};
        }
    };

    this.forget = function () { this.errors = {};  };

    this.rset = function (name) { this.rerrors[name] = name+' is required'; };
    this.rforget = function (name) { delete this.rerrors [name]; };
};
