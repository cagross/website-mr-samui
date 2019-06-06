window.onload = function () {

/* Adds Wet Dream Samui ribbons to home page boat tour category images. */
(function() {
	"use strict";

	var i;
	var j;

	var msClassName = 'ms-cat-img';// This is the custom class given to the WPBakery row in-question.

	var node = document.getElementsByClassName(msClassName)[0].getElementsByClassName('swiper-slide');
	var node_length = node.length;

	for (i = 0; i < node_length; i += 1) {

		var titleNode = node[i].getElementsByTagName("div");// Find all <div> elements within the node.
		var titleNode_length = titleNode.length;

		for (j = 0; j < titleNode_length; j += 1) {// Loop through all <div> elements within the node and carry out a text search for 'boat.'
			var pos = titleNode[j].textContent.toLowerCase().search("boat");
			if (pos > 0) {

				var newDiv = document.createElement("div");
				newDiv.className = "ribbon ribbon-top-left";
				var newSpan = document.createElement("span");
				newSpan.className = "ms-wts-ribbon";
				newDiv.appendChild(newSpan); 
				
				node[i].appendChild(newDiv); 
			}
		}
	}
})();
};