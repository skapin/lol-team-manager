<?php
/*
Fonctions de mise en forme des textes en fonction de leur provenance et de
leur destination.
post : texte qui vient d'un formulaire.
bdd : texte a entrer ou qui vient d'une bdd.
html : texte a afficher comme code html de la page.
text : texte brut, genre celui affiche dans les textarea.
js : texte a afficher dans les codes javascript.
*/

function convertirCaracteres($file)
{
  $file = preg_replace('#(Ã¢)#', '&acirc;', $file );
  $file = preg_replace('#(Ã©)#', '&eacute;', $file );
  $file = preg_replace('#(Ã )#', '&agrave;', $file );
  $file = preg_replace('#(Ãª)#', '&ecirc;', $file );
  $file = preg_replace('#(Ã¹)#', '&ugrave;', $file );
  return $file;
}

function truncate($string,$length=100,$append="&hellip;") 
{
  $string = trim($string);

  if(strlen($string) > $length) {
    $string = wordwrap($string, $length);
    $string = explode("\n",$string);
    $string = array_shift($string) . $append;
  }

  return $string;
}


function changekeyname($array, $newkey, $oldkey)
{
   foreach ($array as $key => $value) 
   {
	  if (is_array($value))
		 $array[$key] = changekeyname($value,$newkey,$oldkey);
	  else
		{
			 $array[$newkey] =  $array[$oldkey];    
		}

   }
   unset($array[$oldkey]);          
   return $array;   
}

function array_to_xml($student_info, &$xml_student_info, $replacement_key='') 
{
	foreach($student_info as $key => $value)
	{
		if(is_array($value)) {
			if(!is_numeric($key)){
				$subnode = $xml_student_info->addChild("$key");
				array_to_xml($value, $subnode);
			}
			else{
				if ( !empty($replacement_key) )
				{
					$subnode = $xml_student_info->addChild($replacement_key);
				}
				else
				{
					$subnode = $xml_student_info->addChild("item$key");
				}
				array_to_xml($value, $subnode);
			}
		}
		else {
			$xml_student_info->addChild("$key",htmlspecialchars("$value"));
		}
	}
}



function processFolder( $path, $func )
{
  $imgdir=$path;
  if (false !== ($dir = opendir($imgdir)))
    {
      while (false !== ($file = readdir($dir)))
        {
	  $tmp=$imgdir;
	  $tmp.=$file;
	  if( true == is_dir($tmp) && $file != '.' && $file != '..')
            {
	      echo "<p>Dossier</p>";
            }
	  else if ($file != '.' && $file != '..' && $file != '/' )
            {
	      $file_without_convert = $file;
	      $file= convertirCaracteres($file);
	      $func( $file, $imgdir );
            }
        }
    }
}

function file_exists_remote($path){
  return (@fopen($path,"r")==true);
}
function bdd2value($text){
	$text=stripslashes($text);
	return str_replace(array('"'),array('&#34;'),$text);
}

function bdd2html($text)
{
	$text=stripslashes($text);
	return str_replace("&amp;","&",htmlentities($text));//striplines(htmlentities($text)));
}
function bdd2js($text)
{
	$text=stripslashes($text);
	$text=str_replace('\\','\\\\',$text);
	// On fout des slashes avant les ", pas les '
	$text=str_replace('"','\"',$text);
	// Et on vire les retours a la ligne.
	$text=str_replace("\r","\\r",$text);
	return str_replace("\n","\\n",$text);
}

function bdd2text($text)
{
	return stripslashes($text);
}

function bdd2bdd($text)
{
	return $text;
}

function post2html($text)
{
	$text=stripslashes($text);
	return striplines(htmlentities($text));
}

function post2js($text)
{
	$text=stripslashes($text);
	// On fout des slashes avant les ", pas les '
	$text=str_replace('"','\"',$text);
	// Et on vire les retours a la ligne.
	$text=str_replace("\r","\\r",$text);
	return str_replace("\n","\\n",$text);
}

function post2text($text)
{
	return stripslashes($text);
}

function post2bdd($text)
{
	return addslashes($text);
}


function getPost( $field, $die=0 )
{
    if (!empty( $_POST[$field] ))
        return $_POST[$field];
    else
    {
        if ( $die )
				{
						echo 'Le champs <strong>'.$field.'</strong> doit etre renseign&eacute; Merci';
            die();
				}
        return "";
    }
}

function getField( $filters, $value )
{
	$key = array_search( $value, $filters );
	$filter = $filters[$key];
	return $filter;
	
}

?>
