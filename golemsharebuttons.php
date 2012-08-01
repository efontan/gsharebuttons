<?php 
/**
 * @package ElGolem
 * @subpackage plg_golem_sharebuttons
 * @version   1.2.3 - 01/08/2012
 * @author    Emmanuel Fontan
 * @copyright (C) 2012 Emmanuel Fontan (email : fontanemmanel@gmail.com)
 *
 * @license		GNU/GPL, see LICENSE.php
 * This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program.  If not, see http://www.gnu.org/licenses/.
 *
 *
 */

defined( '_JEXEC' ) or die( 'Restricted Access' );
jimport( 'joomla.plugin.plugin' );

class plgContentGolemShareButtons extends JPlugin {

	function plgContentGolemShareButtons( &$subject, $config ) {
		parent::__construct($subject, $config);
	}

	public function onContentPrepare($context, &$article, &$params, $page = 0) {
		// API
		$mainframe	= &JFactory::getApplication();
		$document 	= &JFactory::getDocument();

		//BASEURL
		$baseURL 	= JURI::base().'plugins/content/golemsharebuttons/';

		$view = JRequest::getCmd('view');

		//LOAD THE PLUGIN LANGUAGE
		JPlugin::loadLanguage('plg_content_golemsharebuttons', JPATH_ADMINISTRATOR);

		//GET PARAMETERS
		$buttons_position = $this->params->get('buttons_position','');
		$show_share_text = $this->params->get('show_share_text','');
		$share_text = $this->params->get('share_text','');
		$icons_size = $this->params->get('icons_size','');
		$load_css = $this->params->get('load_css','');

		$twitter_status = trim($this->params->get('twitter_status',''));

		//Buttons
		$show_fb_button = $this->params->get('show_fb_button','');
		$show_gp_button = $this->params->get('show_gp_button','');
		$show_tw_button = $this->params->get('show_tw_button','');
		$show_ln_button = $this->params->get('show_ln_button','');
		$show_id_button = $this->params->get('show_id_button','');
		$show_dl_button = $this->params->get('show_dl_button','');
		$show_tu_button = $this->params->get('show_tu_button','');
		$show_dg_button = $this->params->get('show_dg_button','');
		$show_st_button = $this->params->get('show_st_button','');
		$show_rd_button = $this->params->get('show_rd_button','');
		$show_tch_button = $this->params->get('show_tch_button','');
		$show_me_button = $this->params->get('show_me_button','');

		/*#####*/

		// IF THE CONTEXT ISN'T 'COM_CONTENT.ARTICLE', NOT SHOW THE BUTTONS (NOT SHOW IN CUSTOM MODULES, e.g.)
		if	( $context != 'com_content.article'){
			return;
		}

		// ADD STYLES
		if ($load_css == "yes") {
			$document->addStyleSheet( $baseURL.'css/style.css' );
		}

		// URI AND TITLE OF ARTICLE
		$uri =& JURI::getInstance();
		$articleUrl = urlencode($uri->toString());
		$articleTitle = urlencode($article->title);

		//GET THE HTML
		$show_share_text = $this->params->get('show_share_text','');
		$share_text = $this->params->get('share_text','');


		$html = '<div class="golem_share_buttons" id="golem_share_buttons">';

		$html .= ($show_share_text=="yes")? '<span class="golem_share_buttons_text">'.$share_text.'</span> ':'';

		/* ########################################### */
		/* FACEBOOK BUTTON */
		/* ########################################### */
		if ($show_fb_button == "yes") {
			$html.= '
			<span class="golem_button_facebook" id="golem_button_facebook">
			<a href="https://www.facebook.com/share.php?u='.$articleUrl.'&t='.$articleTitle.'" title="Share on Facebook!" target="_blank">
			<img src="'.$baseURL.'images/'.$icons_size.'/facebook.png" title="Share on Facebook!" alt="Facebook Button" width="'.$icons_size.'" height="'.$icons_size.'" />
			</a>
			</span>
			';
		}

		/* ########################################### */
		/* GOOGLE+ */
		/* ########################################### */
		if ($show_gp_button == "yes") {
			$html.= '
			<span class="golem_button_googleplus" id="golem_button_googleplus">
			<a href="https://plus.google.com/share?url='.$articleUrl.'" title="Share on Google+!" target="_blank">
			<img src="'.$baseURL.'images/'.$icons_size.'/googleplus.png" title="Share on Google+!" alt="Google Plus Button" width="'.$icons_size.'" height="'.$icons_size.'" />
			</a>
			</span>';
		}


		/* ########################################### */
		/* TWITTER BUTTON */
		/* ########################################### */
		if ($show_tw_button == "yes") {
			$html.= '
			<span class="golem_button_twitter" id="golem_button_twitter">
			<a href="https://twitter.com/intent/tweet?text='.$twitter_status.' '.$articleTitle.'&url='.$articleUrl.'" title="Share on Twitter!" target="_blank">
			<img src="'.$baseURL.'images/'.$icons_size.'/twitter.png" title="Tweet this!" alt="Twitter Button" width="'.$icons_size.'" height="'.$icons_size.'" />
			</a>
			</span>
			';
		}

		/* ########################################### */
		/* LINKEDIN BUTTON */
		/* ########################################### */
		if ($show_ln_button == "yes") {
			$html.= '
			<span class="golem_button_linkedin" id="golem_button_linkedin">
			<a href="https://www.linkedin.com/shareArticle?mini=true&url='.$articleUrl.'&title='.$articleTitle.'&ro=false&summary=&source=
			" title="Share on Linkedin!" target="_blank">
			<img src="'.$baseURL.'images/'.$icons_size.'/linkedin.png" title="Share on Linkedin!" alt="Linkedin Button" width="'.$icons_size.'" height="'.$icons_size.'" />
			</a>
			</span>
			';
		}

		/* ########################################### */
		/* IDENTI.CA BUTTON */
		/* ########################################### */
		if ($show_id_button == "yes") {
				
			$identica_status = trim($this->params->get('identica_status',''));

			$html.= '
			<span class="golem_button_identica" id="golem_button_identica">
			<a href="http://identi.ca/index.php?action=newnotice&status_textarea='.$identica_status.' '.$articleTitle.' '.$articleUrl.'" title="Share on Identi.ca" target="_blank">
			<img src="'.$baseURL.'images/'.$icons_size.'/identica.png" title="Share on Identi.ca" alt="Identi.ca" width="'.$icons_size.'" height="'.$icons_size.'" />
			</a>
			</span>
			';
		}

		/* ########################################### */
		/* DELICIOUS BUTTON */
		/* ########################################### */
		if ($show_dl_button == "yes") {
			$html.= '
			<span class="golem_button_delicious" id="golem_button_delicious">
			<a href="https://delicious.com/save?url='.$articleUrl.'&title='.$articleTitle.'" title="Add to Delicious!" target="_blank">
			<img src="'.$baseURL.'images/'.$icons_size.'/delicious.png" title="Add to Delicious!" alt="Delicious Button" width="'.$icons_size.'" height="'.$icons_size.'" />
			</a>
			</span>
			';
		}

		/* ########################################### */
		/* TUENTI BUTTON */
		/* ########################################### */
		if ($show_tu_button == "yes") {
			$html.= '<span class="golem_button_tuenti" id="golem_button_tuenti">
			<a href="https://www.tuenti.com/share?url='.$articleUrl.'" title="Share on Tuenti!" target="_blank">
			<img src="'.$baseURL.'images/'.$icons_size.'/tuenti.png" title="Share on Tuenti!" alt="Tuenti Button" width="'.$icons_size.'" height="'.$icons_size.'" />
			</a>
			</span>';
		}


		/* ########################################### */
		/* DIGG BUTTON */
		/* ########################################### */
		if ($show_dg_button == "yes") {
			$html.= '<span class="golem_button_digg" id="golem_button_digg">
			<a href="http://www.digg.com/submit?url='.$articleUrl.'&t='.$articleTitle.'" title="Digg this!" target="_blank">
			<img src="'.$baseURL.'images/'.$icons_size.'/digg.png" title="Digg this!" alt="Digg Button" width="'.$icons_size.'" height="'.$icons_size.'" />
			</a>
			</span>';
		}

		/* ########################################### */
		/* STUMBLEUPON BUTTON */
		/* ########################################### */
		if ($show_st_button == "yes") {
			$html.= '
			<span class="golem_button_stumbleupon" id="golem_button_stumbleupon">
			<a href="https://www.stumbleupon.com/submit?url='.$articleUrl.'&title='.$articleTitle.'" title="Digg this!" target="_blank">
			<img src="'.$baseURL.'images/'.$icons_size.'/stumbleupon.png" title="Share on Stumbleupon!" alt="Stumbleupon Button" width="'.$icons_size.'" height="'.$icons_size.'" />
			</a>
			</span>
			';
		}

		/* ########################################### */
		/* REDDIT BUTTON */
		/* ########################################### */
		if ($show_rd_button == "yes") {
			$html.= '
			<span class="golem_button_reddit" id="golem_button_reddit">
			<a href="http://www.reddit.com/submit?url='.$articleUrl.'&title='.$articleTitle.'" title="Share on Reddit!" target="_blank">
			<img src="'.$baseURL.'images/'.$icons_size.'/reddit.png" title="Share on Reddit!" alt="Reddit Button" width="'.$icons_size.'" height="'.$icons_size.'" />
			</a>
			</span>
			';
		}

		/* ########################################### */
		/* TECHNORATI BUTTON */
		/* ########################################### */
		if ($show_tch_button == "yes") {
			$html.= '<span class="golem_button_technorati" id="golem_button_technorati">
			<a href="http://www.technorati.com/faves?add='.$articleUrl.'" title="Share on Technorati!" target="_blank">
			<img src="'.$baseURL.'images/'.$icons_size.'/technorati.png" title="Share on Technorati!" alt="Technorati Button" width="'.$icons_size.'" height="'.$icons_size.'" />
			</a>
			</span>	';
		}

		/* ########################################### */
		/* MENEAME BUTTON */
		/* ########################################### */
		if ($show_me_button == "yes") {
			$html.= '<span class="golem_button_meneame" id="golem_button_meneame">
			<a href="http://meneame.net/submit.php?url='.$articleUrl.'" title="Share on Meneame!" target="_blank">
			<img src="'.$baseURL.'images/'.$icons_size.'/meneame.png" title="Share on Meneame!" alt="Meneame Button" width="'.$icons_size.'" height="'.$icons_size.'" />
			</a>
			</span>	';
		}


		$html.= "</div>";

		$article->text = ($buttons_position == "top")?  $html.$article->text : $article->text.$html;

		return;

	}

}
?>
