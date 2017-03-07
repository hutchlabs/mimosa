window.SparkForm = function (data) {
    var form = this;

    $.extend(this, data);

    this.errors = new SparkFormErrors();
    this.busy = false;
    this.successful = false;

    this.inValid = function() { return form.errors.hasErrors() || form.errors.hasrErrors(); };

    this.startProcessing = function () {
        form.errors.forget();
        form.busy = true;
        form.successful = false;
    };

    this.finishProcessing = function () {
        form.busy = false;
        form.successful = true;
    };
};
