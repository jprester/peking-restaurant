$(document).ready(function(){	
	$('.mobile-meninav a').click(function(){ 
		event.preventDefault()
		$('.mobile-menilist').slideToggle();
	});

	$('.mmenu a').click(function(){ 
		$('.mnav').slideToggle();
	}); 
});