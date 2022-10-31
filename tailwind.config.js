const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
	],

	theme: {
		extend: {
			fontFamily: {
				sans: ['Nunito Sans', ...defaultTheme.fontFamily.sans],
			},
			colors: {
				'reserved-confirmed': '#A7D7E7',
				'reserved-tentative': '#F0E68C',
				'no-show': '#8080FF',
				'registered': '#90EE90',

				'primary': '#30579A',
				'vacant': '#E2F1F1',
				'occupy': '#90EE90',
				'arrival': '#FFC0CB',
				'departure': '#F0E68C',
				'longStay': '#74BABA',
				'dirty': '#8080FF',
				'oos': '#8B4513',
				'ooo': '#FF0000',
			}
		},
	},

	plugins: [require('@tailwindcss/forms')],
};
