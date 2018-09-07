<?php
defined("_VALID_ACCESS") || die('Direct access forbidden');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class fakturyInstall extends ModuleInstall {

    public function install() {
        // Here you can place installation process for the module

        Base_ThemeCommon::install_default_theme($this->get_type());
        Utils_RecordBrowserCommon::new_addon('kontrakty_faktury', $this->get_type(), 'postion_list',
            array($this->get_type() . 'Common', 'labelPosition'));

            Utils_RecordBrowserCommon::register_processing_callback('kontrakty_faktury', 
            array($this->get_type () . 'Common', 'view_faktury'));

            
        $ret = true;
        return $ret; // Return false on success and false on failure
    }

    public function uninstall() {
        // Here you can place uninstallation process for the module
        $ret = true;
        return $ret; // Return false on success and false on failure
    }

    public function requires($v) {
        // Returns list of modules and their versions, that are required to run this module
        return array(); 
    }
    public function info() { // Returns basic information about the module which will be available in the epesi Main Setup
		return array (
				'Author' => 'Mateusz Kostrzewski',
				'License' => 'MIT 1.0',
				'Description' => '' 
		);
	}
    public function version() {

        return array('1.0'); 
    }
    public function simple_setup() { // Indicates if this module should be visible on the module list in Main Setup's simple view
		return array (
				'package' => __ ( 'Faktury' ),
				'version' => '1.0' 
		); // - now the module will be visible as "HelloWorld" in simple_view
	}

}

?>