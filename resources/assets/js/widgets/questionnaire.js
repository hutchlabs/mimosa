Vue.component('gl-questionnaire', {
    props: ['authUser','qid', 'input'],

    mounted: function () {
        console.log("Questionnaire id: "+this.qid);
        if (this.qid!==null && this.qid>0) {
            this.boot();
        }
    },

    watch: {
        'qid': function(v) { if (v!==null && v>0) { this.boot(); } }
    },

    events: {},

    notifications: {
      showError: {
          title: 'Questionnaire Error',
          message: 'Failed to reach server',
          type: 'error'
        },
        showSuccess: {
          title: 'Questionnaire success',
          message: 'Successfully modified education',
          type: 'success'
      },
    },

    data: function () {
        return {
            baseUrl: '/',
            template: null,
            questionnaire: null,
			doneBuilding: false,
			htmlcode: '',
        }
    },

    methods: {
        boot: function() {
            this.getQuestionnaire();
        },
        
        buildForm: function() {
            var self = this;
       		if (self.questionnaire!==null && self.questionnaire.numquestions > 0) {
				this.htmlcode += "'<fieldset>"; 
				this.htmlcode += "<label>"+self.questionnaire.name+"</label>"; 
				this.htmlcode += "</fieldset>'"; 
			} else {
				this.htmlcode += "<div>No Questionnaire. Please proceed</div>"; 
			}
			this.doneBuilding = true;	 
        },

        removeFromList: function (list, item) {
            return _.reject(list, function (i) { return i.id === item.id; });
        },

        getQuestionnaire: function () {
            var self = this;
            this.$http.get(self.baseUrl+'questionnaires/'+self.qid)
                .then(function (resp) {
                    self.questionnaire = resp.data.data; 
                    self.buildForm();
                }, function(resp) {
                    self.showError({'message': resp.error[0]});
                });
        },
    }
});
