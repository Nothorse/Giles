#!/usr/bin/php
<?php
define('SHELL', true);
/**
 * Needs to manually require the parent class, as it is called outside the weblication framework
 */
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/commandline.cls.php");
require_once(__DIR__ . "/ebook.cls.php");
require_once(__DIR__ . "/library.cls.php");
$path = '/usr/lib/php/pear';

set_include_path(get_include_path() . PATH_SEPARATOR . $path);

class AddBook extends CommandLine {

  /**
   * initParams -- Defining all parameters
   */
  protected function initParams() {
    $this->setCommand('addbook');
    $this->addParam('-f:,--file:', 'FILE', 'Epub File');
    $this->addParam('-d:,--directory:', 'DIRECTORY', 'If a different basedirectory is desired');
  }

  /**
   * main -- main logic flow.
   * script checks for defined tables and then exports data and schema as demanded
   *
   * @return void
   */
  public function main() {
    global $argv;
    $file = $this->getArgument('FILE');
    $paramdir = $this->getArgument('DIRECTORY');
    $dir = ($paramdir) ? $paramdir : BASEDIR;
    if($file) {
      $book = new ebook($file);
      $book->file = $book->cleanupFile($file, $dir);
      $lib = new library();
      $lib->insertBook($book);
    } else {
      echo "No ebook given.\n";
    }
  }

}
$s = new AddBook();
$s->main();
