<?php
/**
 * @package   Versatility4 Template - RocketTheme
 * @version   1.0 October 28, 2011
 * @author    RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2011 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Rockettheme Versatility4 Template uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
 *
 */
// no direct access
defined('_JEXEC') or die;
?>

<?php if($this->error): ?>
<div class="error">
			<?php echo $this->escape($this->error); ?>
</div>
<?php endif; ?>
