
/**
 * Autocomplete class.
 *
 * @author Gustavo Ocanto <gustavoocanto@gmail.com>
 * @license https://github.com/gocanto/google-autocomplete/blob/master/LICENSE.md
 */

import Loader from './Loader';

class Autocomplete
{
	constructor(ref)
	{
		this.place = {};
		this.autocomplete = null;
		this.ref = document.getElementById(ref);
		this.boot();
	}

	/**
	 * Create a new google map instance.
	 *
	 */
	static make(ref)
	{
		return new Autocomplete(ref);
	}

	/**
	 * Load the google places API.
	 *
	 * @return {Void}
	 */
	boot()
	{
		Loader.load(() => { return this.bind(this); });
	}

	/**
	 * Binds the autocomplete to the given reference.
	 *
	 * @param {Self}
	 */
	bind(obj)
	{
		obj.autocomplete = new google.maps.places.Autocomplete(obj.ref, { types: ['geocode'] });
	    obj.autocomplete.addListener('place_changed', obj.pipe());
	}

	/**
	 * Pipes out the retrieved place information.
	 *
	 * @return {Void}
	 */
	pipe()
	{

        console.log(this.autocomplete.getPlace());

		let data  = {};
		let place = this.autocomplete.getPlace();
		let googleInputs = window.GOOGLE_AUTOCOMPLETE.inputs;

        if (typeof place != 'undefined') {
		if (place.address_components !== undefined) {

			for (let i = 0; i < place.address_components.length; i++) {

				let input = place.address_components[i].types[0];

				if (googleInputs[input]) {
					data[input] = place.address_components[i][googleInputs[input]];
				}
			}

			this.place = JSON.parse(
				JSON.stringify(data)
			);
		}
        }
	}

	/**
	 * Bind the browser location to the given input.
	 *
	 * @return {Void}
	 */
	geolocate()
	{
		if (navigator.geolocation) {

			navigator.geolocation.getCurrentPosition( position => {

				let geolocation = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
				};

				let circle = new google.maps.Circle({
					center: geolocation,
					radius: position.coords.accuracy
				});

				this.autocomplete.setBounds(circle.getBounds());
			});
		}
	}

	/**
	 * Returns the retrieved address.
	 *
	 * @return {Object}
	 */
	getPlace()
	{
		return this.place;
	}

	/**
	 * Returns the google autocomplete object.
	 *
	 * @return {Object}
	 */
	getInstance()
	{
		return this.autocomplete;
	}
}

export default Autocomplete;
