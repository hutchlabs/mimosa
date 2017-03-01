	/**
	 * The google autocomplete component.
	 *
	 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
	 * @license https://github.com/gocanto/google-autocomplete/blob/master/LICENSE.md
	 */
import Loader from './Loader';

Vue.component('google-autocomplete', {

		props: [ 'placeholder', 'input_id', 'form' ],

        template: '<input class="form-control" :placeholder="placeholder" :id="input_id" type="text">',

		data: function () {
			return {
                'ref': null,
				'autocomplete': null,
				'address': '',
                'place': '',
			}
		},

		computed: { },

        mounted: function() {
		    Loader.load(() => { return this.boot(this); });
		},

		watch: {
            'place': function() {
                console.log(bus);
                //bus.$emit('setAddress', this.place);
			}
		},

		methods:
		{
            boot: function() {
                var self = this;
		        this.ref = document.getElementById(this.input_id);
		        this.autocomplete = new google.maps.places.Autocomplete(this.ref, { types: ['geocode'] });
	            this.autocomplete.addListener('place_changed', function() {
						let data  = {};
						let place = self.autocomplete.getPlace();
						let googleInputs = window.GOOGLE_AUTOCOMPLETE.inputs;
				
				        if (typeof place != 'undefined') {
							if (place.address_components !== undefined) {
					
								for (let i = 0; i < place.address_components.length; i++) {
									let input = place.address_components[i].types[0];
									if (googleInputs[input]) {
										data[input] = place.address_components[i][googleInputs[input]];
									}
								}
								self.place = JSON.parse(JSON.stringify(data));
							}
				        }
					});
            },
            hasAutocompleteInstance: function() { return this.autocomplete != null; },
		}
});
