<?php  
    namespace Settings;

    class ConfigDB{
        protected function getDBName():string { return "api_php"; }
        protected function getHost():string { return "%LOCALHOST%"; }
        protected function getUser():string { return "root"; }    
        protected function getPassword():string { return "root"; }
    }
    