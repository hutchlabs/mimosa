Vue.component('spark-profile-summary', {
    props: ['profileid','userid','summary','title'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                    <h4 class="font-thin m-t-none m-b-none text-primary-lt">{{title}}</h4>\
                    <br/>\
                    <div id="editor-container" style="height: 100px"></div>\
                </div>\
               </div>',

    mounted: function () {
        var self = this;
        this.forms.updateForm.id = this.profileid;
        this.forms.updateForm.user_id = this.userid;
        this.forms.updateForm.summary = this.summary;
        this.initQuill(this.summary);
    },

    events: {},

    notifications: {
      showUpdateError: {
          title: 'Error Updating Summary',
          message: 'Failed to reach server',
          type: 'error'
        },
        showUpdateSuccess: {
          title: 'Updating Summary successful',
          message: 'Successfully updated summary',
          type: 'success'
      },
    },

    data: function () {
        return {
            baseUrl: '/',

            quill: '',

            config: {
                    placeholder: 'Describe yourself and aspirations',
                    theme: 'snow',
                    modules: {
                        toolbar: [
                           ['bold', 'italic'],
                           ['link', 'blockquote', 'image'],
                           [{ list: 'ordered' }, { list: 'bullet' }],
                           ['save']
                       ]
                    },
            },

            forms: {
                updateForm: new SparkForm ({
                    id: '',
                    user_id: '',
                    summary: '',
                }),
            },
        }
    },

    methods: {
        initQuill: function(text) {
            this.quill = new Quill('#editor-container', this.config);
            if (typeof text!='undefined') {
                this.quill.setText(text);
            }
            this.dehighlight();
            $('.ql-save').on('click', function() { self.doUpdate(); });
            this.quill.on('text-change', function(change) {  this.highlight(); });
        },
        highlight: function() {
            $('.ql-save').css({'background-color': '#5bc0de', 'color': 'white'});
        },
        dehighlight: function() {
            $('.ql-save').css({'background-color': 'white', 'color': 'black'});
        },
		doUpdate: function() {
			var self = this;
            this.forms.updateForm.summary = this.quill.getText();
            this.$http.put(this.baseUrl+'profiles/users/'+this.userid, this.forms.updateForm)
                .then(function (resp) {
                    self.showUpdateSuccess();
                    self.dehighlight();
                    bus.$emit('updateAuthUser');
                }, function(resp) {
                    var errors = "";
                    $.each(resp.data, function(i, e) {
                        errors +=  e + " and ";
                    });
                    console.log(errors);
                    self.showUpdateError({'message': errors});
			    });
		},
    }
});
