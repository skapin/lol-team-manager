<?php
/*************************************************
**
**StAx : Saite-Axe (v0.3)
**
**Date : 24-March-2010
**
**Author : Florian Boudinet [florian[DOT]boudinet[AT]etu[DOT]u-bordeaux1[DOT]fr)
**
**************************************************/

//StAx--------------------------------

class StAxStyle
{

    const Sober1 = 'sober1 ';
    const LittleScrollArea = 'littleScrollArea ' ;
    const None = '';
    const Usual = StAxStyle::Sobre1;
}

function StAx($code,$type, $style=StAxStyle::Sober1 ){

/*$code = preg_replace('`\&`','&amp;',$code);
$code = preg_replace('`\<`','&lt;',$code);
$code = preg_replace('`\>`','&gt;',$code);
*/
$code = htmlentities( $code ) ;

	if($type == 'java')
		$code = traitementJava($code);
	else if($type == 'php')
		$code = traitementPHP($code);
    else if($type == 'cpp')
		$code = traitementPHP($code);

    return printRender ( $code, $style );
}

function StAx_loadSourceFile( $file )
{
    return file_get_contents( $file );
}

function traitementPHP($code){

$code = preg_replace('`(\&lt;\?php)`U','$1  
/* Coloration Syntaxtique generer avec StAx : Saite-Axe (v0.3) */',$code,1);

$code = preg_replace('`(\".*\")`U','<span class="StAx_php_string">$1</span> ',$code);
$code = preg_replace('`(\'.*\')`U','<span class="StAx_php_stringQuote">$1</span>',$code);
$code = preg_replace('`(\&lt;\?php)`U','<span class="StAx_php_PHP">$1</span> ',$code);
$code = preg_replace('`(\?\&gt;)`U','<span class="StAx_php_PHP">$1</span> ',$code);
$code = preg_replace('`(\$[0-9a-zA-Z_]*)(\W)`U','<span class="StAx_php_variable">$1</span>$2',$code);
$code = preg_replace('`\b(for|return|requiere|requiere_once|foreach|declare|unset|break|elseif|default|case|switch|static|class[^=]|if|else|while|do|public|catch|this|protected|endif|exit|function|clone|try|throw|interface|die|var|global|extends|private)\b`','<span class="StAx_php_motClef">$1</span>',$code);
$code = preg_replace('`(//.*)(\n|\r)`','<span class="StAx_php_ligneCommentaire">$1</span><br />',$code);
$code = preg_replace('`(/\*[^\*].*\*/)`sU','<span class="StAx_php_zoneCommentaire">$1</span>',$code);
$code = preg_replace('`(\(|\)|{|\[|\}|\])`U','<span class="StAx_php_accoladeCrochet">$1</span>',$code);

return $code;
}

function traitementJava( $code ){

$code = preg_replace('`(\".*\")`U','<span class="StAx_java_string">$1</span> ',$code);
$code = preg_replace('`\b(for|return|catch|class[^=]|if|else|while|do|public|static|final|this|protected|extends|implements)\b`','<span class="StAx_java_motClef">$1</span>',$code);
$code = preg_replace('`\b(new)\b(.*)\(`U','<span class="StAx_java_motClef-new">new</span> <span class="StAx_java_class">$2</span>(',$code);
$code = preg_replace('`\b(int|double|true|false|null|void|float|String|char)\b`i','<span class="StAx_java_type">$1</span>',$code);
$code = preg_replace('`(//.*)(\n|\r)`','<span class="StAx_java_ligneCommentaire">$1</span><br />',$code);
$code = preg_replace('`\b(using|import)\b`','<span class="StAx_java_using">$1</span> ',$code);
$code = preg_replace('`(/\*[^\*].*\*/)`sU','<span class="StAx_java_zoneCommentaire">$1</span>',$code);
$code = preg_replace('`(/\*\*.*\*\*/)`sU',' <span class="StAx_java_javadoc">$1</span> ',$code);
$code = preg_replace('`(\W)([0-9]*\.?[0-9]?)(\W)`sU','$1<span class="StAx_java_type-entier">$2</span>$3',$code);

 
return $code;
}

function printRender( $code, $style )
{
    $data =  '<pre class="StAx-pre-php';
    
    $cssTag = explode ( " ", $style );
    foreach ( $cssTag as $value )
    {
    	$data .= ' StAx-renderLayout_'.$value;
    }
    
    $data .= '">'.$code.'</pre>';
    return $data;
}



?>
