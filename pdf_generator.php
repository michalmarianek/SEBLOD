<?php
/**
* @version 			SEBLOD 3.x More
* @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
* @url				https://www.seblod.com
* @editor			Octopoos - www.octopoos.com
* @copyright		Copyright (C) 2009 - 2018 SEBLOD. All Rights Reserved.
* @license 			GNU General Public License version 2 or later; see _LICENSE.php
**/

defined( '_JEXEC' ) or die;

// Plugin
class plgCCK_Field_LinkPdf_Generator extends JCckPluginLink
{
	protected static $type	=	'pdf_generator';
	
	// -------- -------- -------- -------- -------- -------- -------- -------- // Prepare
		
	// onCCK_Field_LinkPrepareContent
	public static function onCCK_Field_LinkPrepareContent( &$field, &$config = array() )
	{		
		if ( self::$type != $field->link ) {
			return;
		}
		
		// Prepare
		$link	=	parent::g_getLink( $field->link_options );
		
		// Set
		$field->link	=	'';
		self::_link( $link, $field, $config );
	}
	
	// _link
	protected static function _link( $link, &$field, &$config )
	{
		$field->link	=	'#'; /* TODO */
		//echo '<pre>';
//https://stackoverflow.com/questions/38524320/download-pdf-file-from-ajax-response
		//https://gist.github.com/wemersonjanuario/45d302337b45d6aad866051f0473c646
		$field->link_class = 'xhr_'.$field->name;
		$js		=	'(function ($){
						$(document).ready(function() {
							$("a.xhr_ao_pdf").click(function(evt) {
							 evt.preventDefault();
							 var sendto = "index.php?option=com_cck&format=raw&task=ajax&"+Joomla.getOptions("csrf.token")+"=1&referrer=plugin.cck_field_link.pdf_generator&file=plugins/cck_field_link/pdf_generator/tmpl/form.php&id='.$config['pk'].'";
							 var req = new XMLHttpRequest();
							 req.open("POST", sendto, true);
							 req.responseType = "blob";
							 req.onreadystatechange = function () {
								if (req.readyState === 4 && req.status === 200) {
                                    var filename = "PdfName-" + new Date().getTime() + ".pdf";
									if (typeof window.chrome !== "undefined") {
									// Chrome version
									var link = document.createElement("a");
									link.href = window.URL.createObjectURL(req.response);
									link.download = "PdfName-" + new Date().getTime() + ".pdf";
									link.click();
									} else if (typeof window.navigator.msSaveBlob !== "undefined") {
									// IE version
									var blob = new Blob([req.response], { type: "application/pdf" });
									window.navigator.msSaveBlob(blob, filename);
								} else {
							// Firefox version
									var blob = new Blob([req.response], { type: "application/pdf" });
									var blobUrl = window.URL.createObjectURL(blob);
                                   var a = document.createElement("a");
                                    document.body.appendChild(a);
                                    a.style = "display: none";
                                    a.href = blobUrl;
                                    a.download = filename ;
									 a.click();
								}
							}
							};
							req.send();
							})
									});
								})(jQuery);';
		JFactory::getDocument()->addScriptDeclaration( $js );






	}
	
	// -------- -------- -------- -------- -------- -------- -------- -------- // Special Events
	
	// onCCK_Field_LinkBeforeRenderContent
	public static function onCCK_Field_LinkBeforeRenderContent( $process, &$fields, &$storages, &$config = array() )
	{


	}
}
?>