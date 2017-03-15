Vue.component('spark-profile-summary', {
    props: ['profileid','userid','summary','title'],

    template: '<div class="panel hbox hbox-auto-xs no-border">\
                <div class="col wrapper">\
                    <i class="fa fa-circle-o text-info m-r-sm pull-right"></i>\
                    <h4 class="font-thin m-t-none m-b-none text-primary-lt">{{title}}</h4>\
                    <br/>\
                    <gl-textarea :id="\'editor-container\'" :display="\'\'" :form="forms.updateForm" :name="\'summary\'" :placeholder="\'Describe your self and your achievements\'" :input.sync="forms.updateForm.summary"></gl-textarea>\
                </div>\
               </div>',

    mounted: function () {
        var self = this;
        this.forms.updateForm.id = this.profileid;
        this.forms.updateForm.user_id = this.userid;
        this.forms.updateForm.summary = this.summary;
    },

    watch: {
        'forms.updateform.summary': function(v) {
            this.doUpdate();
        }
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
		doUpdate: function() {
			var self = this;
            this.$http.put(this.baseUrl+'profiles/users/'+this.userid, this.forms.updateForm)
                .then(function (resp) {
                    self.showUpdateSuccess();
                    bus.$emit('updateAuthUser');
                }, function(resp) {
                    var errors = "";
                    $.each(resp.data, function(i, e) { errors +=  e + " and "; });
                    console.log(errors);
                    self.showUpdateError({'message': errors});
			    });
		},
    }
});
