/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'uiComponent',
	'ko',
	'domReady!'
],
function ($, Component, ko) {
    'use strict';
	
    return Component.extend({
        /**
         * Default Config Option
         * @var {Object}
         */			
        defaults: {
            template: 'Faonni_ReCaptcha/checkout/reCaptcha'
        },
		
        /**
         * Config Option
         * @var {Object}
         */		
		config: {
			enabled: false,
			type: 'image',
			size: 'normal',
			theme: 'light',
			sitekey: null
		},
		
        /**
         * initialize Component
         * @return {Void}
         */	
        initialize: function () {
            this._super();
            if (window[this.configSource] && window[this.configSource].recaptcha) {
                $.extend(this.config, window[this.configSource].recaptcha);
            }
        },
		
        /**
         * Check Functionality Should be Enabled
         * @return {Boolean}
         */
        isEnabled: function () {
            return this.config.enabled;
        },
		
        /**
         * Retrieve Config
         * @return {Object}
         */
        getConfig: function () {
            return this.config;
        }	
    });
});
