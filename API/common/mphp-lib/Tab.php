<?php
/**
* @file  Tab.php
* @brief  Gestion et creation des tableau html
* @since  novembre 2010
* @author SkapiN
**/


class Tab
{
/**
* @brief ligne d'en-tete xhtml.
**/
   private $tab_thead;
/**
* @brief corps du tableau xhtml. Contient toutes les cellule <td> du tableau.
**/
   private $tab_tbody;
/**
* @brief ligne de footer du tableau.
**/
   private $tab_tfooter;
/**
* @brief titre du tableau
**/
   private $caption;
/**
* @brief nombre de ligne du tableau.
**/
   private $row;
/**
* @brief nombre de colonne du tableau.
**/
   private $col;
   
   private $id;
   
   private $tr_class='';
   
   private $classs;

/**
* @brief Constructeur de la class represenant un tableau xhtml
* @param $cap titre du tableau
* @param $cols nombre de colonne maxiaml du tableau
* @param $rows nombre de ligne maximal du tableau
**/
   function __construct( $cap, $cols = 0, $rows = 0 )
   {
       $this->caption = $cap;
       $this->tab_thead='' ;
       $this->tab_tbody='' ;
       $this->tab_tfooter='';
       $this->setRow( $rows );
       $this->setCol( $cols );
    }
/**
* @brief Retourne le tableau formater en xhtml.
**/
   public function getTab($class='')
   {
       return '<table class="'.$class.'"><caption>'. $this->caption .' </caption>'.$this->tab_thead. '<tbody>'. $this->tab_tbody .'</tbody><tfoot>'. $this->tab_tfooter .'</tfoot></table>';
    }
   public function setCol( $cols )
   {   
        $this->col = $cols;
   }
   public function getCol( )
   {    
       return $this->col;
   }
   public function getBody( )
   {   
        return $this->tab_tbody;
   }
   public function getHead( )
   {   
        return $this->tab_thead;
   }
   
   public function setCaption( $cap )
   {   
        $this->caption = $cap;
   }
   public function getCaption( )
   {    
       return $this->caption;
   }

   public function setRow( $rows )
   {
        $this->row = $rows;
   }
   public function getRows( )
   {         return $this->row;
   }
   
   public function setTrId( $id )
   {   
        $this->id = $id;
   }
   public function setTrClass( $classs )
   {   
        $this->tr_class = $classs;
   }
       
/**
* @brief Debute un tableau html
* @param $var prend en entré autant de parametre que souhaité. Chaque parametre represente les en-tete des colonnes du tableau.
**/
    public function setHeader( )
    {
        $arg_c = func_num_args();
        $this->col = $arg_c;
        $tab_thead = '
        <thead>
            <tr>';
        for ( $i = 0; $i < $arg_c; $i++ )
        {
            $tab_thead .= '<th>'.func_get_arg( $i ).'</th>';
        }
        $tab_thead .= '
            </tr>
        </thead>';    
        $this->tab_thead = $tab_thead;
    }

/**
* @brief Ajoute une ligne au tableau
* @param $var prend en entré autant de parametre que souhaité. Chaque parametre correspond a l'affichage d'une cellule du tableau
**/
   public function add_row()
   {
       $nbr_arg = func_num_args();
       if ( $nbr_arg > $this->col )
       {
           $this->tab_tbody .= 'Tab::add_row() erreur, vous essayez de creer une ligne avec plus de cellule que ne peut le contenir le tableau...';
       }
       else
       {
           $this->row++;
           $this->tab_tbody .= '
<tr '.(!empty($this->id)? 'id="'.$this->id.'"':'').' '.(!empty($this->tr_class)? 'id="'.$this->tr_class.'"':'').' >';
            for ( $i = 0; $i < $nbr_arg; $i++ )
            {
                $this->tab_tbody .= '<td>'.func_get_arg( $i ).'</td>';
            }
            $this->tab_tbody .= '</tr>
';              
    
        }
   }
   
   public function add_row_css()
   {
       $nbr_arg = func_num_args()-1;
       if ( $nbr_arg > $this->col )
       {
           $this->tab_tbody .= 'Tab::add_row() erreur, vous essayez de creer une ligne avec plus de cellule que ne peut le contenir le tableau...';
       }
       else
       {
           $this->row++;
           $this->tab_tbody .= '
<tr '.(!empty($this->id)? 'id="'.$this->id.'"':'').' class="'.func_get_arg( $nbr_arg ).'">';
            for ( $i = 0; $i < $nbr_arg; $i++ )
            {
                $this->tab_tbody .= '<td>'.func_get_arg( $i ).'</td>';
            }
            $this->tab_tbody .= '</tr>
';              
    
        }
   }
/**
* @brief Ajoute une ligne au tableau
* @param $vals prend en entrée un array contenant les cellules a ajouter
**/
   public function add_row_array( $vals )
   {

       $nbr_arg = count( $vals );
       if ( $nbr_arg > $this->col )
       {
           $this->tab_tbody .= 'Tab::add_row_array() erreur, vous essayez de creer une ligne avec plus de cellule que ne peut le contenir le tableau...';
       }
       else
       {
           $this->row++;
           $this->tab_tbody .= '
<tr>';
            for ( $i = 0; $i < $nbr_arg; $i++ )
            {
                $this->tab_tbody .= '<td>'.$vals[$i].'</td>';
            }
            $this->tab_tbody .= '</tr>
';              
           
       }
   }
   
   public function add_row_raw( $row_raw )
   {
       $this->row++;
       $this->tab_tbody .= $row_raw;              
        
   }

}





?>
