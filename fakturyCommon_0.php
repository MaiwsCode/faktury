<?php
defined("_VALID_ACCESS") || die('Direct access forbidden');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class fakturyCommon extends ModuleCommon {

    public static function menu() {
		return array(__('Module') => array('__submenu__' => 1, __('Finanse') => array(
	    	'__icon__'=>'faktura.png','__icon_small__'=>'faktura.png'
			)));
    }
    
    public static function labelPosition(){
        return array('label' => 'Pozycje faktury', 'show' => true);
    }

    public static function view_faktury($record,$mode){
        if($mode == "adding"){
            Epesi::js('jq(".name").html("");
            jq(".name").html("<div> Tworzenie nowej faktury </div>");');
            $record['status'] = "editable";
            return $record;
        }
        if($mode == 'editing'){
            Epesi::js('jq(".name").html("");
            jq(".name").html("<div> Edytowanie faktury - '.$record['fv_numer'].' </div>");');
        }
        if($mode == 'display'){
            $_SESSION['fv_mode'] = $record['id'];
            $_SESSION['display_current_name_view'] = "Pozycja do Faktury ".$record['fv_numer'];
        }
    }


}
