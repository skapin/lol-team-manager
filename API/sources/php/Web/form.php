<?php

require_once('basics.php');
/**
* @file : form.php
* @brief : fonctions utiles pour la creation de formulaires
* @since : 2009
*
**/


/**
* @brief Crée un input html de type texte	
* @param	label	label de l'inpute
* @param	size taille de l'input
* @param	name	nom donnée a la requete POST ou GET envoyé
* @param	onchange	code de l'attribut onchange
* @param	value valeur par defaut
* 
**/
function form_text($label,$name,$size,$onchange,$value='')
{
	set_post($name);
	return '<label for="'.$name.'">'.$label.'</label><input type="text" id="'.$name.'" name="'.$name.'" value="'.($value!==''?$value:post2text($_POST[$name])).'" '.($size?'size="'.$size.'" 
maxlength="'.$size.'" ':'').''.($onchange?'onchange="'.$onchange.'" ':'').'/>';
}
/**
* @brief Crée un input html de type email	
* @param	label	label de l'inpute
* @param	name	nom donnée a la requete POST ou GET envoyé
* @param	size taille de l'input
* @param	onchange	code de l'attribut onchange
* @param	value valeur par defaut
* 
**/
function form_email($label,$name,$size,$onchange,$value='')
{
	set_post($name);
	return '<label for="'.$name.'">'.$label.'</label><input type="text" id="'.$name.'" name="'.$name.'" value="'.($value!==''?$value:post2text($_POST[$name])).'" '.($size?'size="'.$size.'" 
maxlength="'.$size.'" ':'').''.($onchange?'onchange="'.$onchange.'" ':'').'/>';
}
/**
 * @brief Crée un input html de type password
 * @param	label	label de l'inpute
 * @param	name	nom donné a la requete POST ou GET envoyé
 * @param	size taille de l'input
 * 
 * */
function form_password($label,$name,$size)
{
	set_post($name);
	return '<label for="'.$name.'">'.$label.'</label><input type="password" id="'.$name.'" name="'.$name.'" value="'.post2text($_POST[$name]).'" />';
}
/**
 * @brief Crée un input html de type check-box
 * @param	label	label de l'inpute
 * @param	name	nom donné a la requete POST ou GET envoyé
 * 
 * */
function form_check($label,$name)
{
	return ($label?'<label for="'.$name.'">'.$label.'</label>':'').'<input type="checkbox" id="'.$name.'" name="'.$name.'" '.(isset($_POST[$name])?'checked="checked" ':'').'/>';
}
/**
 * @brief Crée un input html de type radio
 * @param	label	label de l'inpute
 * @param	groupe	nom du groupe auquel appartient le radio-box
 * @param	name	nom donné a la requete POST ou GET envoyé
 * 
 * */
function form_radio($label,$groupe,$name)
{
  return ($label?'<label for="'.$name.'">'.$label.'</label>':'').'<input type="radio" value="'.$name.'" name="'.$groupe.'" />';
}

/**
 * @brief Crée un input html de type select
 * @param	label	label de l'inpute
 * @param	name	nom donné a la requete POST ou GET envoyé
 * @param	options	array() correspond aux valeurs selectionnable par le select. La premiere case de l'array contient le nombre d'element a afficher. Toute les autres cases doivent
 * contenir un array avec en premiere position la valeur du select, en deuxieme position ce qui doit etre affiché dans le select. On peut aussi definir un style particulier en affectant
 *  la case 'style' ou changer la selection par defaut par la case 'disabled'
 * 
 * */
function form_select($label,$name,$options,$onchange='',$value='')
{
	set_post($name);
	$select=($label?'<label for="'.$name.'">'.$label.'</label>':'').'<select id="'.$name.'" name="'.$name.'"'.($onchange?' onchange="'.$onchange.'"':'').'>
		';
	for($i=1;$i<=$options[0];$i++){
		$test=$value?$value:$_POST[$name];
		$select.='<option value="'.$options[$i][0].'"'.($options[$i][0]==$test?' selected="selected"':'').''.(isset($options[$i]['style'])?' 
style="'.$options[$i]['style'].'"':'').''.(isset($options[$i]['disabled'])?' disabled="disabled"':'').'>'.$options[$i][1].'</option>
			';
	}
	return $select.'</select>';
}
/**
 * @brief Crée un bouton de validation du formulaire courant
 * @param	name	nom donné a la requete POST ou GET envoyé
 * @param	value	valeur attribué au champ.
 * 
 * */
function form_submit($name,$value)
{
	return '<input type="submit" name="'.$name.'" id="'.$name.'" value="'.$value.'" />';
}
/**
 * @brief Crée un inpute invisible a l'affichage
 * @param	name	nom donné a la requete POST ou GET envoyé
 * @param	value	valeur attribué au champ.
 * 
 * */
function form_hidden($name,$value)
{
	return '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$value.'" />';
}

/**
 * @brief Crée un inpute de chargemetn d'image
 * @param	name	nom donné a la requete POST ou GET envoyé
 * @param	display_image afficher l'image ou non. Valeur a true si non renseignée.
 * @deprecated PAS ENCORE IMPLEMENTE
 * */
function form_image($label,$name,$display_image=true)
{
	return '<label for="'.$name.'">'.$label.'</label><input type="file" name="'.$name.'" id ="'.$name.'" onchange="loadImage(this,\''.$name.'_image\');" />' . ($display_image?'<img src="" alt="" 
id="'.$name.'_image" />':'');
}
/**
 * @brief Crée un inpute pour saisir de long texte
 * @param	name	nom donné a la requete POST ou GET envoyé
 * @param	row	nombre de ligne
 * @param	cols	nombre de colones
 * */
function form_textarea($label,$name,$rows,$cols)
{
	set_post($name);
	return ($label?'<label for="'.$name.'">'.$label.'</label>':'').'<textarea '.($cols?'cols="'.$cols.'" ':'').($rows?'rows="'.$rows.'" ':'').'name="'.$name.'" 
id="'.$name.'">'.post2text($_POST[$name]).'</textarea>';
}

function set_post($truc)
{
	$_POST[$truc]=isset($_POST[$truc])?$_POST[$truc]:'';
}







?>
