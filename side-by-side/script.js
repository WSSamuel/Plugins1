jQuery(document).ready(function(){sideBySide.activateSideBySide();});

sideBySide = new function(){
	
	this.boxClass='skewed-boxes'
	this.skewedBoxClass='left-skewed-box'
	this.contentBoxClass='left-content-box'
	this.tanSkewAngle=1;//45deg
	
	this.activateSideBySide = function (){
		jQuery('.skewed-boxes').mousemove(function(event){sideBySide.handleMouseMove(event);});
	}
	
	this.handleMouseMove = function (mouseMoveEvent){
		var box=jQuery(mouseMoveEvent.target).parents('.'+sideBySide.boxClass);
		var skewedBox=box.children('.'+sideBySide.skewedBoxClass);
		var contentBox=skewedBox.children('.'+sideBySide.contentBoxClass);
		
		var boxOffset=box.offset();
		var boxHeight=box.height();
		
		var mousePositionLeft=mouseMoveEvent.pageX-boxOffset.left;
		var mousePositionTop=mouseMoveEvent.pageY-boxOffset.top;
		
		var mouseProjectedToMiddleLine=mousePositionLeft+(mousePositionTop-boxHeight/2)*sideBySide.tanSkewAngle;
		var positionLeft=2*box.width()-mouseProjectedToMiddleLine;

		skewedBox.css('left',-positionLeft);
		contentBox.css('left',positionLeft);
		
	}
	
}