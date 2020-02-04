<?php
  class SetupTools {

    private $pathSrc = __DIR__."/src/";

    /**
     * createFolderAndArqs
     *
     * @param  string $pastaSettings
     * @param  array $arquivosSettings
     *
     * @return void
     */
    public function createFolderAndArqs(string $pastaSettings, array $arquivosSettings):void {
      $this->createFolderIfNotExist($pastaSettings);
    
      foreach ($arquivosSettings as $arquivo) {
  
        if (!$this->checkIfExistArq($arquivo['arqName'], $pastaSettings)) {
          $this->createArq($arquivo['arqName'], $pastaSettings);
          $this->setContentArq($arquivo['arqName'], $pastaSettings, $arquivo['vars']);
        }
  
      }
    }
  


    /**
     * createFolderIfNotExist
     *
     * @param  string $folderRoot
     *
     * @return void
     */
    private function createFolderIfNotExist(string $folderRoot):void {
      if (!is_dir($folderRoot)) mkdir($folderRoot, 0777, true);
    }
  


    /**
     * createArq
     *
     * @param  string $arqName
     * @param  string $folderRoot
     *
     * @return void
     */
    private function createArq(string $arqName, string $folderRoot):void {
      touch($folderRoot . $arqName);
    }
  


    /**
     * setContentArq
     *
     * @param  string $arqName
     * @param  string $folderRoot
     * @param  array $vars
     *
     * @return void
     */
    private function setContentArq(string $arqName, string $folderRoot, array $vars):void {
      $arquivo = fopen($folderRoot . $arqName,'w');

      $content = $this->getContentArq($arqName, $vars);

      fwrite($arquivo, $content);
      fclose($arquivo);
    }
  


    /**
     * checkIfExistArq
     *
     * @param  string $arqName
     * @param  string $folderRoot
     *
     * @return bool
     */
    private function checkIfExistArq(string $arqName, string $folderRoot):bool {
      return file_exists($arqName . $folderRoot);
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