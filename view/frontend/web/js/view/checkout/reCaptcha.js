/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'uiComponent',
	'ko'
],
function ($, Component) {
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
         * initialize Component
         * @return {Void}
         */	
        initialize: function () {
            this._super();
            if (window[this.configSource] && window[this.configSource].recaptcha) {
                var config = window[this.configSource].recaptcha;
            }			
        },
		
        /**
         * Check Functionality Should be Enabled
         * @return {Boolean}
         */
        isEnabled: function () {
            return true;
        }
    });
});
