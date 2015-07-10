/**
 * @package   MetaMorph Template - RocketTheme
 * @version   1.0 November 3, 2011
 * @author    RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2011 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Rockettheme MetaMorph Template uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */

var maxHeight = function(classname) {
    var divs = document.getElements(classname);
    var max = 0;
    divs.each(function(div) {
        max = Math.max(max, div.getSize().y);
    });
	divs.setStyle('height', max);
    return max;
};

window.addEvent('load', function() {
	if (!Browser.Engine.trident4) {
		maxHeight('#rightcol .sameheight');
		maxHeight('#rightcol .sameheight');
	}

	(function(){ maxHeight('.sameheight'); }).delay(2000);
});
