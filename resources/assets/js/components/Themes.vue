Vue.component('gradlead-themes-screen', {

    mounted: function() {
        this.getThemes();
    },

    data: function() {
        return {
            baseUrl: '/',
            modname: 'Themes',
            
            theme: null,

            forms: {
                updateTheme: new SparkForm ({
                    id: '',
					home_header: '',
           			schools_header: '',
		           	contact_header: '',
		           	home_first_title: '',
		           	home_second_title: '',
		           	home_third_title: '',
		           	home_first: '',
		           	home_second: '',
		           	home_third: '',
                    schools_first_title: '',
		           	schools_second_title: '',
		           	schools_third_title: '',
		           	schools_first: '',
		           	schools_second: '',
		           	schools_third: '',
                    contact_first_title: '',
		            contact_second_title: '',
		           	contact_third_title: '',
		           	contact_first: '',
		           	contact_second: '',
		           	contact_third: '',
		           	home_hero: '',
		           	schools_hero: '',
		           	contact_hero: '',
                }),
            }
        };
    },
    
    events: {
    },

    computed: {
        everythingLoaded: function () {
            return this.theme != null;
        }
    },

    methods: {
        // Ajax calls
        updateTheme: function () {
            var self = this;
            $('#modal-edit-theme').modal('show');

            Spark.put(self.baseUrl+'themes/' + this.forms.updateTheme.id, this.forms.updateTheme)
                .then(function () {
                    self.getThemes();
                    $('#modal-edit-theme').modal('hide');
            });
        },

        getThemes: function () {
            var self = this;
            this.$http.get(self.baseUrl+'themes')
                .then(function (resp) {
                    self.theme = resp.data.data[0];
					self.forms.updateTheme.id = self.theme.id;
					self.forms.updateTheme.home_header = self.theme.home_header;
					self.forms.updateTheme.schools_header = self.theme.schools_header;
					self.forms.updateTheme.contact_header = self.theme.contact_header;
					self.forms.updateTheme.home_first_title = self.theme.home_first_title;
					self.forms.updateTheme.home_second_title = self.theme.home_second_title;
					self.forms.updateTheme.home_third_title = self.theme.home_third_title;
					self.forms.updateTheme.home_first = self.theme.home_first;
					self.forms.updateTheme.home_second = self.theme.home_second;
					self.forms.updateTheme.home_third = self.theme.home_third;
                    
                    self.forms.updateTheme.schools_first_title = self.theme.schools_first_title;
					self.forms.updateTheme.schools_second_title = self.theme.schools_second_title;
					self.forms.updateTheme.schools_third_title = self.theme.schools_third_title;
					self.forms.updateTheme.schools_first = self.theme.schools_first;
					self.forms.updateTheme.schools_second = self.theme.schools_second;
					self.forms.updateTheme.schools_third = self.theme.schools_third;
                
                    self.forms.updateTheme.contact_first_title = self.theme.contact_first_title;
					self.forms.updateTheme.contact_second_title = self.theme.contact_second_title;
					self.forms.updateTheme.contact_third_title = self.theme.contact_third_title;
					self.forms.updateTheme.contact_first = self.theme.contact_first;
					self.forms.updateTheme.contact_second = self.theme.contact_second;
					self.forms.updateTheme.contact_third = self.theme.contact_third;
                
					self.forms.updateTheme.home_hero = self.theme.home_hero;
					self.forms.updateTheme.schools_hero = self.theme.schools_hero;
					self.forms.updateTheme.contact_hero = self.theme.contact_hero;
             });
		},
    },

    filters: { },
});
