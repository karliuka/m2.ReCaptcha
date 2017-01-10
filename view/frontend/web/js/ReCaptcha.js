define(['jquery'],
function ($) {
    'use strict';
    console.log(grecaptcha);
	return {
        config:{
            containerId: 'faonni-recaptcha'
        },	
        init:function(config){
			this.config = $.extend({}, this.config, config);
			console.log(grecaptcha);
			grecaptcha.render(this.config.containerId, {
			  'sitekey' : '6Lfjkw4UAAAAADq98On9wASnFwWfgvY4pGZg0kYl'//,
			  //'callback' : verifyCallback,
			  //'theme' : 'dark'
			});

        },		
    };	
}); 
