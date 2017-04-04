var _moment = require('moment');

Vue.component('gradlead-inbox-message', {
    props: ['message', 'inboxmsg','avatar'],

    template: '<div>\
                <div class="wrapper bg-light lter b-b">\
                    <div class="btn-group m-r-sm pull-right">\
                      <button v-show="inboxmsg" class="btn btn-sm btn-default w-xxs w-auto-xs" tooltip="Delete" @click.prevent="removeMessage"><i class="fa fa-trash-o"></i></button>\
                    </div>\
                    <a @click.prevent="goback" class="btn btn-sm btn-default w-xxs m-r-sm" tooltip="Back to Inbox"><i class="fa fa-long-arrow-left"></i></a>\
                 </div>\
                <div class="wrapper b-b">\
                    <h2 class="font-thin m-n">{{message.subject}}</h2>\
                  </div>\
                  <div class="wrapper b-b">\
                    <img :src="avatar" class="img-circle thumb-xs m-r-sm">\
                    from {{message.from.name}} ({{message.from.orgname}})  <span class="text-muted">{{message.created_at | fromNow }}</span>\
                  </div>\
                  <div class="wrapper" v-html="message.message"> </div>\
                  <div class="wrapper" v-show="inboxmsg">\
                    <div class="panel b-a">\
                      <div class="panel-heading" v-show="!reply">\
                        <div class="m-b-lg">\
                            Click here to <a href class="text-u-l" @click.prevent="reply=!reply">Reply</a>\
                        </div>\
                      </div>\
                      <div class="ng-hide" v-show="reply">\
                        <div class="panel-heading b-b b-light"> {{message.from.email}} </div>\
                        <div class="panel-heading b-b b-light"> Re: {{message.subject}} </div>\
                        <div class="wrapper" contenteditable="true" style="min-height:100px"></div>\
                        <gl-error-alert :form="forms.msgForm"></gl-error-alert>\
                        <form class="form-horizontal m-t-lg" role="form">\
                            <gl-textarea :required="true" :id="msgid()" :display="\'Message:\'" :form="forms.msgForm" :name="\'message\'" :placeholder="\'Your message\'" :input.sync="forms.msgForm.message"></gl-textarea>\
                            <div class="panel-footer bg-light lt">\
                                <button class="btn btn-link pull-right" @click.prevent="reply=!reply"><i class="fa fa-trash-o"></ i></button>\
                                <button class="btn btn-info w-xs font-bold" @click.prevent="sendMessage()">Send</button>\
                            </div>\
                        </form>\
                      </div>\
                    </div>\
                  </div>\
			</div>',

    notifications: {
      showError: {
          title: 'Reply Email Error',
          message: 'Failed to reach server',
          type: 'error'
        },
        showSuccess: {
          title: 'Reply success',
          message: 'Successfully sent message',
          type: 'success'
      },
    },


    mounted: function () {},

    computed: {},

    watch: { },

    events: {},

    data: function () {
        return {
            baseUrl: '/',
            reply: false,

            forms: {
                msgForm: new SparkForm ({
                    from:'',
                    to: '',
                    subject:'',
                    message:'',
                    tpl: '',
                }),
            },
        }
    },

    methods: {
        msgid: function() {
            return 'reply-container-'+this.message.id;
        },
        
        goback: function() { 
            this.forms.msgForm.to = '';
            this.forms.msgForm.subject = '';
            this.forms.msgForm.message = '';
            this.forms.msgForm.errors.forget();
            this.$emit('goback');  
        },

        removeMessage: function() { 
            this.$emit('deletemsg');  
        },

        sendMessage: function () {
            var self = this;

            Spark.post(self.baseUrl+'users/inbox', this.forms.msgForm)
                .then(function () {
                    self.showSuccess({message:'New message sent'});
                    bus.$emit('updateAuthUser');
                    self.goback();
                }, function(resp) {
                    self.forms.msgForm.busy = false;
                    self.showError({'message': resp.error[0]});
                });
        },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) { return i.id === item.id; });
        },
    },

    filters: { 
        fromNow: function(v) { return _moment(v).fromNow() },
    },
});
