<?php
defined("_VALID_ACCESS") || die('Direct access forbidden');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class faktury extends Module { 

    public function settings(){

    }    
    public function postion_list($record){
        Epesi::js('jq(".name").html("");
        jq(".name").html("<div> Faktura '.$record["fv_numer"].' </div>");');
        Base_ActionBarCommon::add(
            'add',
            'Dodaj nową pozycję', 
            Utils_RecordBrowserCommon::create_new_record_href('kontrakty_faktury_pozycje',$def=array(),$id='none'),
                null,
                5
            );
        $rbo = new RBO_RecordsetAccessor("kontrakty_faktury_pozycje");
        $pos = $rbo->get_records(array('faktura' => $record['id']),array(),array('id' => "ASC"));
        $gb = &$this->init_module('Utils/GenericBrowser', null, 'Pozycje');
        $gb->set_table_columns(
            array(
                array('name'=>'Pozycje', 'width'=>10),
                array('name'=>'Szczegóły', 'width'=>70),
            )
        );
        foreach($pos as $p){
            $extra = "";
            $tables = array("kontrakty_faktury_dostawa_paszy", "kontrakty_faktury_dostawa_warchlaka" ,
             "kontrakty_faktury_inne_faktury_tucz", "kontrakty_faktury_odbior_tucznika");
            for($i = 0 ;$i<count($tables);$i++){
                $tab = new RBO_RecordsetAccessor($tables[$i]);
                $records = $tab->get_records(array("fakt_poz" => $p['id']),array(),array());
                if($records){
                    foreach($records as $rec){
                        if($tables[$i] == "kontrakty_faktury_inne_faktury_tucz"){
                            $extra = "Inne";
                        }
                        else if($tables[$i] == "kontrakty_faktury_odbior_tucznika"){
                            $extra = "Odbiór";
                        }else{
                        $extra = $rec->create_default_linked_label(false,false);
                        }
                    }
                }
            }
            
            $gb->add_row(   
                "<span style='margin-left:10px;' >".$p->create_default_linked_label(false,false)."</span>", 
                $extra
            );
        
        }
        $this->display_module( $gb );
    }  


    public function body(){
        unset($_SESSION['display_current_name_view']);
        Epesi::js('jq(".name").html("");
        jq(".name").html("<div> Faktury </div>");');
       /* Base_ActionBarCommon::add(
            'add',
            'Dodaj nową pozycję', 
            Utils_RecordBrowserCommon::create_new_record_href('kontrakty_faktury_pozycje',$def=array(),$id='none'),
                null,
                5
            );*/
        Base_ThemeCommon::install_default_theme($this->get_type());
        $rs = new RBO_RecordsetAccessor('kontrakty_faktury');
        $rb = $rs->create_rb_module ( $this );
        $this->display_module ( $rb);

        Base_ActionBarCommon::add(
            'add',
            'Dodaj nową fakture', 
            Utils_RecordBrowserCommon::create_new_record_href('kontrakty_faktury',$def=array(),$id='none'),
                null,
                0
        );  
        Epesi::js('jq(".name").html("");
        jq(".name").html("<div>Faktury</div>");');  
    } 
}
