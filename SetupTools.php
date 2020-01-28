<?php
  class SetupTools {
    /**
     * createFolderAndArqs
     *
     * @param  string $pastaSettings
     * @param  array $arquivosSettings
     *
     * @return void
     */
    public function createFolderAndArqs(string $pastaSettings, array $arquivosSettings) {
      $this->createFolderIfNotExist($pastaSettings);
    
      foreach ($arquivosSettings as $arquivo) {
  
        if (!$this->checkIfExistArq($arquivo['arqName'], $pastaSettings)) {
          $this->createArq($arquivo['arqName'], $pastaSettings);
          $this->setContentArq($arquivo['arqName'], $pastaSettings, $arquivo['conteudo']);
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
    public function createFolderIfNotExist(string $folderRoot) {
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
    public function createArq(string $arqName, string $folderRoot) {
      touch($folderRoot . $arqName);
    }
  
    /**
     * setContentArq
     *
     * @param  string $arqName
     * @param  string $folderRoot
     * @param  string $content
     *
     * @return void
     */
    public function setContentArq(string $arqName, string $folderRoot, string $content) {
      $arquivo = fopen($folderRoot . $arqName,'w');
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
    public function checkIfExistArq(string $arqName, string $folderRoot):bool {
      return file_exists($arqName . $folderRoot);
    }
  
  }