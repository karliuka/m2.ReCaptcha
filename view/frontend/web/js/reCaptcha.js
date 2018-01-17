/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */ 
define([
    'jquery',
	'domReady!'
], 
function($) {
    'use strict';

	$.widget('faonni.reCaptcha', {
		
        /**
         * Widget Config Option
         * @var {Object}
         */		
		options: {
			type: 'image',
			size: 'normal',
			theme: 'light',
			sitekey: null		
		},
		
		/**
		* Initialize Widget
		* @returns {void}
		*/		
		_create: function() {
			if (typeof grecaptcha != 'undefined') {
				$(this.element).find('.g-recaptcha').each(function (index, element) {
					grecaptcha.render(element, this.options);
				}.bind(this));
			}
		}	
	});
 
    return $.faonni.reCaptcha;
});