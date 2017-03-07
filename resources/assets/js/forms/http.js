module.exports = {
    post: function (uri, form) { return Spark.sendForm('post', uri, form); },

    put: function (uri, form) { return Spark.sendForm('put', uri, form); },

    delete: function (uri, form) { return Spark.sendForm('delete', uri, form); },

    sendForm: function (method, uri, form) {
        return new Promise(function (resolve, reject) {
            form.startProcessing();

            Vue.http[method](uri, form)
                .then(function (response) {
                    form.finishProcessing();
                    var vals = (typeof response.data.data != 'undefined') ? response.data.data : response.data;
                    resolve(vals);
                },function (response) {
                    var errs = (typeof response.data.errors != 'undefined') ? response.data.errors : response.data;
                    form.errors.set(errs);
                    form.busy = false;
                    reject(errs);
                });
        });
    }
};
