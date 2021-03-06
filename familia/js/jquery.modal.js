/**
 * Simple Modal
 * @description Extremely simple jQuery modal window
 * @author EG Studio <www.egstidio.biz>
 * @version 1.0
 */

(function($){  

$.fn.simplemodal = function(options) {  
	
   var defaults = {};  
   var options = $.extend(defaults, options); 

   return this.each(function() {  

	   $(this).click(function(){
	   		var $modal = $("<div id=\"simplemodal\"></div>");
	   		var offsetY = $(window).scrollTop();
	   		var height = $(document).height(); 
	   	
	   		$("body").append($modal);
	   	
	   		var toLoad = $(this).attr('href'); 
	   		$($modal).show();
	   		$($modal).load(toLoad);
	   	
	   		$($modal).css({'height' : height+'px', 'padding-top' : offsetY+'px'});
	   	
	   		
	   		$(document).click(function(e){
	   			
	   			var $target = $(e.target);
	   			var id = $($target).attr('id');

	   			if(id == "simplemodal"){
	   				$($modal).fadeOut("slow", function(){
	   					$(this).remove();
	   				});
	   				
	   			}
	   		});
	   		
	   		$($modal).find(".close").click(function(){
	   			$($modal).fadeOut("slow", function(){
   					$(this).remove();
   				});
	   		});
	   		
	   		
	   		return false;
	   		
	   });

   });  
};

})(jQuery);  