Vue.component('gradlead-resumes-screen', {
    
    props: ['authUser', 'usertype', 'permissions'],

    mounted: function () {
        this.resumes = this.authUser.resumes;
        this.setDefaults();
        this.setupListeners();
    },

    data: function () {
        return {
            baseUrl: '/',
            modname: 'Resumes',

			resumes: [],
            docs: [],
            defaults: [],

 			forms: {
                addResume: new SparkForm({
                    name: '',
                    user_id: '',
                    description: '',
                    default: '',
                    pdf_file: '',
                    file_name: '',
                }),
                addDoc: new SparkForm({
                    name: '',
                    user_id: '',
                    description: '',
                    pdf_file: '',
                    file_name: '',
                }),
                updateDefault: new SparkForm({
                    id: '',
                    default: '',
                }),
            },
        };
    },

    watch: { },

    events: {},

    computed: {
        everythingLoaded: function () { return this.authUser != null },
    },

    methods: {
        setDefaults: function() {
            var self = this;
            this.defaults=[];
            $.each(this.resumes, function(i, r) {
                self.defaults[r.id] = r.default; 
            });
        },

        addResume: function() {
            this.forms.addResume.name = '';
            this.forms.addResume.user_id = this.authUser.id;
            this.forms.addResume.description = '';
            this.forms.addResume.default = '';
            this.forms.addResume.pdf_file = '';
            $('#modal-add-resume').modal('show');
        },
        addDoc: function() {
            this.forms.addDoc.name = '';
            this.forms.addDoc.user_id = this.authUser.id;
            this.forms.addDoc.description = '';
            this.forms.addDoc.pdf_file = '';
            $('#modal-add-doc').modal('show');
        },

        setFileName: function(name) {
            this.forms.addResume.file_name = name;
        },
        setDocFileName: function(name) {
            this.forms.addDoc.file_name = name;
        },

		getFileUrl: function(rid) {
            return '/profiles/pdf/'+rid+'?'+new Date(); 
        },
		getDocUrl: function(rid) {
            return '/profiles/doc/'+rid+'?'+new Date(); 
        },

        setupListeners: function () {
            var self = this;
            bus.$on('authUserSet', function (user) { 
                self.resumes = user.resumes; 
                self.docs = user.docs;
                self.setDefaults();
            });
            bus.$emit('screenLoaded',self.modname);
        },

        addNewResume: function() { 
            var self = this;
            Spark.post(self.baseUrl+'profiles/users/resume', this.forms.addResume)
                .then(function () {
                    $('#modal-add-resume').modal('hide');
                    bus.$emit('updateAuthUser');
            });
        },
        addNewDoc: function() { 
            var self = this;
            Spark.post(self.baseUrl+'profiles/users/doc', this.forms.addDoc)
                .then(function () {
                    $('#modal-add-doc').modal('hide');
                    bus.$emit('updateAuthUser');
            });
        },
        
       removeResume: function(r) { 
            var self = this;
            Spark.delete(self.baseUrl+'profiles/users/resume/'+r.id)
                .then(function () {
                    bus.$emit('updateAuthUser');
            });
       },
       removeDoc: function(doc) { 
            var self = this;
            Spark.delete(self.baseUrl+'profiles/users/doc/'+doc.id)
                .then(function () {
                    bus.$emit('updateAuthUser');
            });
       },

       updateDefault: function (resume) {
            var self = this;
            this.forms.updateDefault.id = resume.id; 

            var newval =  !this.defaults[resume.id];

            if (newval) {
                $.each(this.defaults, function(i,d) {
                    if (i==resume.id) { self.defaults[i] = newval; }
                    else { self.defaults[i] = !newval; }
                });
            } else {
                this.defaults[resume.id]=newval;
            }

            this.forms.updateDefault.default = this.defaults[resume.id]; 

            Spark.put(self.baseUrl+'profiles/users/resume/default/'+resume.id, this.forms.updateDefault).then(function(resp) {
                bus.$emit('updateAuthUser');
            });
        },
    },

    filters: { },
});
