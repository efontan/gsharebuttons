<?php 
/**
 * @package ElGolem
 * @subpackage plg_golem_sharebuttons
 * @version   0.3.0 - 14/08/2012
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

	function onPrepareContent( &$article, &$params, $limitstart ) {
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
		$icons_size = $this->params->get('icons_size',16);
		$load_css = $this->params->get('load_css','');		
		$show_share_text = $this->params->get('show_share_text','');
		$share_text = $this->params->get('share_text','');

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
		
		//PDF Options
		$show_pdf_button = $this->params->get('show_pdf_button','yes');
		$show_print_button = $this->params->get('show_print_button','yes');

		/*#####*/

		if ( JRequest::getCmd('view') != 'article'  || ( isset( $_GET['print'] ) && $_GET['print'] == 1 ) ) {
			return;
		}

		// ADD STYLES
		if ($load_css == "yes") {
			$document->addStyleSheet( $baseURL.'css/style'.$icons_size.'.css' );
		}		

		// URI AND TITLE OF ARTICLE
		$uri = JURI::getInstance();
		$articleUrl = urlencode($uri->toString());
		$articleTitle = urlencode($article->title);

		//GET THE HTML
		$html = '<ul class="golem_share_buttons" id="golem_share_buttons">';
		
		$html .= ($show_share_text == 1)? ('<div class="golem_share_buttons_text">'.$share_text.'</div>&nbsp;'):'';
		

		/* ########################################### */
		/* FACEBOOK BUTTON */
		/* ########################################### */
		if ($show_fb_button == "yes") {
			$html.= '<li>
			<a class="golem_button_facebook" id="golem_button_facebook" href="https://www.facebook.com/share.php?u='.$articleUrl.'&t='.$articleTitle.'" title="Facebook" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}

		/* ########################################### */
		/* GOOGLE+ */
		/* ########################################### */
		if ($show_gp_button == "yes") {
			$html.= '<li>
			<a class="golem_button_googleplus" id="golem_button_googleplus" href="https://plus.google.com/share?url='.$articleUrl.'" title="Google+" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}


		/* ########################################### */
		/* TWITTER BUTTON */
		/* ########################################### */
		if ($show_tw_button == "yes") {
			$twitter_status = trim($this->params->get('twitter_status',''));
			
			$html.= '<li>
			<a class="golem_button_twitter" id="golem_button_twitter" href="https://twitter.com/intent/tweet?text='.$twitter_status.' '.$articleTitle.'&url='.$articleUrl.'" title="Twitter" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}

		/* ########################################### */
		/* LINKEDIN BUTTON */
		/* ########################################### */
		if ($show_ln_button == "yes") {
			$html.= '<li>
			<a class="golem_button_linkedin" id="golem_button_linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url='.$articleUrl.'&title='.$articleTitle.'&ro=false&summary=&source=
			" title="Linkedin" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}
	
		//Search the '?' character on the Article URI
		$pattern = "/\?/";
		$print_view = (preg_match($pattern, $uri->toString()))? "&tmpl=component&print=1":"?tmpl=component&print=1";

		/* ########################################### */
		/* PRINT BUTTON */
		/* ########################################### */
		if ($show_print_button == "yes") {			
			$html.= '<li>
			<a class="golem_button_print" id="golem_button_print" href="'.$uri->toString().$print_view.'" title="Print" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}

		/* ########################################### */
		/* PDF BUTTON */
		/* ########################################### */
		if ($show_pdf_button == "yes") {
			$pdf_view = $this->params->get('pdf_view','article');
			$pdf_service = $this->params->get('pdf_service',1);
		
			//GENERATE PDF URL
			$pdf_url = ($pdf_view == 'article')? $uri->toString().$print_view:$uri->toString();
			
			
			$html.= '<li>
			<a class="golem_button_pdf" id="golem_button_pdf" href="';
			
			switch ($pdf_service) {
				case 1:
					$html.= 'http://pdfmyurl.com?url='.$pdf_url.'"';
					
				case 2:				
					$html.= 'http://www.printfriendly.com/print/v2?url='.$pdf_url.'"';
					
			}

			$html.= ' title="PDF" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}

		/* ########################################### */
		/* DELICIOUS BUTTON */
		/* ########################################### */
		if ($show_dl_button == "yes") {
			$html.= '<li>
			<a class="golem_button_delicious" id="golem_button_delicious" href="https://delicious.com/save?url='.$articleUrl.'&title='.$articleTitle.'" title="Delicious" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}

		/* ########################################### */
		/* TUENTI BUTTON */
		/* ########################################### */
		if ($show_tu_button == "yes") {
			$html.= '<li>
			<a class="golem_button_tuenti" id="golem_button_tuenti" href="https://www.tuenti.com/share?url='.$articleUrl.'" title="Tuenti" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}

		/* ########################################### */
		/* IDENTI.CA BUTTON */
		/* ########################################### */
		if ($show_id_button == "yes") {
				
			$identica_status = trim($this->params->get('identica_status',''));

			$html.= '<li>
			<a class="golem_button_identica" id="golem_button_identica" href="http://identi.ca/index.php?action=newnotice&status_textarea='.$identica_status.' '.$articleTitle.' '.$articleUrl.'" title="Identi.ca" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}

		/* ########################################### */
		/* DIGG BUTTON */
		/* ########################################### */
		if ($show_dg_button == "yes") {
			$html.= '<li>
			<a class="golem_button_digg" id="golem_button_digg" href="http://www.digg.com/submit?url='.$articleUrl.'&t='.$articleTitle.'" title="Digg" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}

		/* ########################################### */
		/* STUMBLEUPON BUTTON */
		/* ########################################### */
		if ($show_st_button == "yes") {
			$html.= '<li>
			<a class="golem_button_stumbleupon" id="golem_button_stumbleupon" href="https://www.stumbleupon.com/submit?url='.$articleUrl.'&title='.$articleTitle.'" title="Stumbleupon" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}

		/* ########################################### */
		/* REDDIT BUTTON */
		/* ########################################### */
		if ($show_rd_button == "yes") {
			$html.= '<li>
			<a class="golem_button_reddit" id="golem_button_reddit" href="http://www.reddit.com/submit?url='.$articleUrl.'&title='.$articleTitle.'" title="Reddit" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}

		/* ########################################### */
		/* TECHNORATI BUTTON */
		/* ########################################### */
		if ($show_tch_button == "yes") {
			$html.= '<li>
			<a class="golem_button_technorati" id="golem_button_technorati" href="http://www.technorati.com/faves?add='.$articleUrl.'" title="Technorati" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}

		/* ########################################### */
		/* MENEAME BUTTON */
		/* ########################################### */
		if ($show_me_button == "yes") {
			$html.= '<li>
			<a class="golem_button_meneame" id="golem_button_meneame" href="http://meneame.net/submit.php?url='.$articleUrl.'" title="Meneame" target="_blank">&nbsp;</a>&nbsp;
			</li>';
		}

		$html.= "</ul>";

		$article->text = ($buttons_position == "top")?  $html.$article->text : $article->text.$html;

		return;

	}

}
?>
