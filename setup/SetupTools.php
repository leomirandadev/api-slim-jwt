<?php
  class SetupTools {

    private $pathSrc = __DIR__."/src/";
    private $pathSettings = __DIR__.'/../settings/';

    /**
     * createFolderAndArqs
     *
     * @param  array $arquivosSettings
     *
     * @return void
     */
    public function createFolderAndArqs(array $arquivosSettings):void {
      $this->createFolderIfNotExist($this->pathSettings);
    
      foreach ($arquivosSettings as $arquivo) {
  
        if (!$this->checkIfExistArq($arquivo['arqName'])) {
          $this->createArq($arquivo['arqName']);
          $this->setContentArq($arquivo['arqName'], $arquivo['vars']);
        }
  
      }
    }
  


    /**
     * createFolderIfNotExist
     *
     * @return void
     */
    private function createFolderIfNotExist():void {
      if (!is_dir($this->pathSettings)) mkdir($this->pathSettings, 0777, true);
    }
  


    /**
     * createArq
     *
     * @param  string $arqName
     *
     * @return void
     */
    private function createArq(string $arqName):void {
      touch($this->pathSettings . $arqName);
    }
  


    /**
     * setContentArq
     *
     * @param  string $arqName
     * @param  array $vars
     *
     * @return void
     */
    private function setContentArq(string $arqName, array $vars):void {
      $arquivo = fopen($this->pathSettings . $arqName,'w');

      $content = $this->getContentArq($arqName, $vars);

      fwrite($arquivo, $content);
      fclose($arquivo);
    }
  


    /**
     * checkIfExistArq
     *
     * @param  string $arqName
     *
     * @return bool
     */
    private function checkIfExistArq(string $arqName):bool {
      return file_exists($this->pathSettings . $arqName);
    }



    /**
     * getContentArq
     *
     * @param  string $arqName
     * @param  array $vars
     *
     * @return string
     */
    private function getContentArq(string $arqName, array $vars):string {
      $path = $this->pathSrc . $arqName;
      
      $tmp = fopen($path, 'r');
      $content = file_get_contents($path);
      
      foreach ($vars as $key => $var) {
        $content = str_replace($key, $var, $content);
      }

      fclose($tmp);
      return $content;
    }
  


  }