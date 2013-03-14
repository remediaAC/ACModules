<?php

//controlla che l'accesso sia effettuato dall'interno del programma
defined( '_VALID_SESSION' ) or die( 'Restricted access' );

class xml
{
    var $parser;
    var $error_code;
    var $error_string;
    var $current_line;
    var $current_column;
    var $data = array();
    var $datas = array();
   
    function parse($data)
    {
        $this->parser = xml_parser_create('UTF-8');
        xml_set_object($this->parser, $this);
        xml_parser_set_option($this->parser, XML_OPTION_SKIP_WHITE, 1);
        xml_set_element_handler($this->parser, 'tag_open', 'tag_close');
        xml_set_character_data_handler($this->parser, 'cdata');
        if (!xml_parse($this->parser, $data))
        {
            $this->data = array();
            $this->error_code = xml_get_error_code($this->parser);
            $this->error_string = xml_error_string($this->error_code);
            $this->current_line = xml_get_current_line_number($this->parser);
            $this->current_column = xml_get_current_column_number($this->parser);
        }
        else
        {
            $this->data = $this->data['child'];
        }
        xml_parser_free($this->parser);
    }

    function tag_open($parser, $tag, $attribs)
    {
        $this->data['child'][$tag][] = array('data' => '', 'attribs' => $attribs, 'child' => array());
        $this->datas[] =& $this->data;
        $this->data =& $this->data['child'][$tag][count($this->data['child'][$tag])-1];
    }

    function cdata($parser, $cdata)
    {
        $this->data['data'] .= $cdata;
    }

    function tag_close($parser, $tag)
    {
        $this->data =& $this->datas[count($this->datas)-1];
        array_pop($this->datas);
    }
}
/*
$xml_parser = new xml;
$xml_parser->parse(file_get_contents("http://localhost/joomla/modules/mod_poll.xml"));
echo "<pre>";
print_r($xml_parser->data);
echo "</pre>";
*/
/*
<?xml version="1.0" encoding="iso-8859-1"?>
<mosinstall type="module" version="1.0.0">
	<name>Poll</name>
	<author>Joomla! Project</author>
	<creationDate>July 2004</creationDate>
	<copyright>(C) 2005 Open Source Matters. All rights reserved.</copyright>
	<license>http://www.gnu.org/copyleft/gpl.html GNU/GPL</license>
	<authorEmail>admin@joomla.org</authorEmail>
	<authorUrl>www.joomla.org</authorUrl>
	<version>1.0.0</version>
	<description>Questo modulo mostra i sondaggi che vengono creati con il suo componente.</description>
	<files>
	<filename module="mod_poll">mod_poll.php</filename>
	</files>
	<params>
		<param name="cache" type="radio" default="0" label="Abilita Cache" description="Abilita Cache">
			<option value="0">No</option>
			<option value="1">Si</option>
		</param>
		<param name="moduleclass_sfx" type="text" default="" label="Suffisso class CSS modulo" description="Un suffisso alla class CSS può essere applicato al modulo (table.moduletable), questo garantisce uno stile individuale al modulo pagina" />
	</params>
</mosinstall>
*/
/*
Array
(
    [MOSINSTALL] => Array
        (
            [0] => Array
                (
                    [data] => 
                    [attribs] => Array
                        (
                            [TYPE] => module
                            [VERSION] => 1.0.0
                        )

                    [child] => Array
                        (
                            [NAME] => Array
                                (
                                    [0] => Array
                                        (
                                            [data] => Poll
                                            [attribs] => Array
                                                (
                                                )

                                            [child] => Array
                                                (
                                                )

                                        )

                                )

                            [AUTHOR] => Array
                                (
                                    [0] => Array
                                        (
                                            [data] => Joomla! Project
                                            [attribs] => Array
                                                (
                                                )

                                            [child] => Array
                                                (
                                                )

                                        )

                                )

                            [CREATIONDATE] => Array
                                (
                                    [0] => Array
                                        (
                                            [data] => July 2004
                                            [attribs] => Array
                                                (
                                                )

                                            [child] => Array
                                                (
                                                )

                                        )

                                )

                            [COPYRIGHT] => Array
                                (
                                    [0] => Array
                                        (
                                            [data] => (C) 2005 Open Source Matters. All rights reserved.
                                            [attribs] => Array
                                                (
                                                )

                                            [child] => Array
                                                (
                                                )

                                        )

                                )

                            [LICENSE] => Array
                                (
                                    [0] => Array
                                        (
                                            [data] => http://www.gnu.org/copyleft/gpl.html GNU/GPL
                                            [attribs] => Array
                                                (
                                                )

                                            [child] => Array
                                                (
                                                )

                                        )

                                )

                            [AUTHOREMAIL] => Array
                                (
                                    [0] => Array
                                        (
                                            [data] => admin@joomla.org
                                            [attribs] => Array
                                                (
                                                )

                                            [child] => Array
                                                (
                                                )

                                        )

                                )

                            [AUTHORURL] => Array
                                (
                                    [0] => Array
                                        (
                                            [data] => www.joomla.org
                                            [attribs] => Array
                                                (
                                                )

                                            [child] => Array
                                                (
                                                )

                                        )

                                )

                            [VERSION] => Array
                                (
                                    [0] => Array
                                        (
                                            [data] => 1.0.0
                                            [attribs] => Array
                                                (
                                                )

                                            [child] => Array
                                                (
                                                )

                                        )

                                )

                            [DESCRIPTION] => Array
                                (
                                    [0] => Array
                                        (
                                            [data] => Questo modulo mostra i sondaggi che vengono creati con il suo componente.
                                            [attribs] => Array
                                                (
                                                )

                                            [child] => Array
                                                (
                                                )

                                        )

                                )

                            [FILES] => Array
                                (
                                    [0] => Array
                                        (
                                            [data] => 
	
	
                                            [attribs] => Array
                                                (
                                                )

                                            [child] => Array
                                                (
                                                    [FILENAME] => Array
                                                        (
                                                            [0] => Array
                                                                (
                                                                    [data] => mod_poll.php
                                                                    [attribs] => Array
                                                                        (
                                                                            [MODULE] => mod_poll
                                                                        )

                                                                    [child] => Array
                                                                        (
                                                                        )

                                                                )

                                                        )

                                                )

                                        )

                                )

                            [PARAMS] => Array
                                (
                                    [0] => Array
                                        (
                                            [data] => 
		
		
	
                                            [attribs] => Array
                                                (
                                                )

                                            [child] => Array
                                                (
                                                    [PARAM] => Array
                                                        (
                                                            [0] => Array
                                                                (
                                                                    [data] => 
			
			
		
                                                                    [attribs] => Array
                                                                        (
                                                                            [NAME] => cache
                                                                            [TYPE] => radio
                                                                            [DEFAULT] => 0
                                                                            [LABEL] => Abilita Cache
                                                                            [DESCRIPTION] => Abilita Cache
                                                                        )

                                                                    [child] => Array
                                                                        (
                                                                            [OPTION] => Array
                                                                                (
                                                                                    [0] => Array
                                                                                        (
                                                                                            [data] => No
                                                                                            [attribs] => Array
                                                                                                (
                                                                                                    [VALUE] => 0
                                                                                                )

                                                                                            [child] => Array
                                                                                                (
                                                                                                )

                                                                                        )

                                                                                    [1] => Array
                                                                                        (
                                                                                            [data] => Si
                                                                                            [attribs] => Array
                                                                                                (
                                                                                                    [VALUE] => 1
                                                                                                )

                                                                                            [child] => Array
                                                                                                (
                                                                                                )

                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                            [1] => Array
                                                                (
                                                                    [data] => 
                                                                    [attribs] => Array
                                                                        (
                                                                            [NAME] => moduleclass_sfx
                                                                            [TYPE] => text
                                                                            [DEFAULT] => 
                                                                            [LABEL] => Suffisso class CSS modulo
                                                                            [DESCRIPTION] => Un suffisso alla class CSS puÃ² essere applicato al modulo (table.moduletable), questo garantisce uno stile individuale al modulo pagina
                                                                        )

                                                                    [child] => Array
                                                                        (
                                                                        )

                                                                )

                                                        )

                                                )

                                        )

                                )

                        )

                )

        )

)
*/
?>
