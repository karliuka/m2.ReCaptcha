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
			if ($(this.element).hasClass('g-recaptcha')) {
				this._render(this.element.get(0));
			} else {
				$(this.element).find('.g-recaptcha').each(function(index, element) {
					this._render(element);
				}.bind(this));					
			}
		},
		
		/**
		 * Render reCaptcha
		 * @param {Element} element
		 * @returns {void}
		 */		
		_render: function(element) {
			if (typeof grecaptcha != 'undefined') {
				grecaptcha.render(element, this.options);
			}
		}			
	});
 
    return $.faonni.reCaptcha;
});