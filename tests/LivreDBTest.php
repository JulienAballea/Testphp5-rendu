<?php
use PHPUnit\Framework\TestCase;
require_once "Constantes.php";
require_once "metier/Livre.php";
require_once "PDO/LivreDB.php";


class LivreDBTest extends TestCase {

    /**
     * @var LivreDB
     */
    protected $livre;
    protected $pdodb;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp():void {
        //parametre de connexion à la bae de donnée
        $strConnection = Constantes::TYPE . ':host=' . Constantes::HOST . ';dbname=' . Constantes::BASE;
        $arrExtraParam = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $this->pdodb = new PDO($strConnection, Constantes::USER, Constantes::PASSWORD, $arrExtraParam); //Ligne 3; Instancie la connexion
        $this->pdodb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown():void {

    }

    /**
     * @covers LivreDB::ajout
     * @todo   Implement testAjout().
     */
    public function testAjout() {
      try {
          $this->livre = new LivreDB($this->pdodb);
          $l = new Livre("PHP et MySQL pour les Nuls","Broché","info test","Daniel Rougé");
          $this->livre->ajout($l);
          $l->setId($this->pdodb->lastInsertId());
          $lvr = $this->livre->selectLivre($l->getId());
          $this->assertEquals($l->getTitre(), $lvr->getTitre());
          $this->assertEquals($l->getEdition(), $lvr->getEdition());
          $this->assertEquals($l->getInformation(), $lvr->getInformation());
          $this->assertEquals($l->getAuteur(), $lvr->getAuteur());

          $this->livre->suppression($this->pdodb->lastInsertId());
      } catch (Exception $e) {
            echo 'Exception recue : ', $e->getMessage(), "\n";
        }
    }

    /**
     * @covers LivreDB::update
     * @todo   Implement testUpdate().
     */
     public function testUpdate() {
          $this->livre = new LivreDB($this->pdodb);
          $l = new Livre("Flaubert", "livre de Flaubert", "Galimard", "titre update");
          $this->livre->ajout($l);
          $l->setId($this->pdodb->lastInsertId());
         //TODO  à finaliser
         //instanciation de l'objet pour mise ajour

          $lupdate=new Livre("PHP et MySQL pour les Nuls","Broché","info test update","Daniel Rougé");
         //update lvr
         $lastid=$this->pdodb->lastInsertId();
         $lupdate->setId($lastid);
         $this->livre->update($lupdate);
         $lvr = $this->livre->selectLivre($lastid);
         $this->assertEquals($l->getTitre(), $lvr->getTitre());
         $this->assertEquals($l->getEdition(), $lvr->getEdition());
         $this->assertEquals($l->getInformation(), $lvr->getInformation());
         $this->assertEquals($l->getAuteur(), $lvr->getAuteur());

         $this->livre->suppression($this->pdodb->lastInsertId());
      }

    /**
     * @covers LivreDB::suppression
     * @todo   Implement testSuppression().
     */
    public function testSuppression()    {
        try {
            $this->livre = new LivreDB($this->pdodb);
            $lvr = new Livre("PHP et MySQL pour les Nuls","Broché","info test supp","Daniel Rougé");
            $this->livre->ajout($lvr);
            $lastId =$this->pdodb->lastInsertId();
            $this->livre->suppression($lastId);
            $lvr2 = $this->livre->selectLivre($lastId);
            if ($lvr2 != null) {
                $this->markTestIncomplete(
                    "La suppression de l'enreg livre a echoué"
                );
            }
        } catch (Exception $e) {
            //verification exception
            $exception = "RECORD LIVRE not present in DATABASE";
            $this->assertEquals($exception, $e->getMessage());
        }
    }

    /**
     * @covers LivreDB::selectAll
     * @todo   Implement testSelectAll().
     */
    public function testSelectAll() {
      $this->livre = new LivreDB($this->pdodb);
      $res=$this->livre->selectAll();
      $i=0; $ok=true;
      foreach ($res as $key=>$value) {
        $i++;
      }


      if($i==0){
        $this->markTestIncomplete(
          'Pas de résultats'
        );
        $ok=false;

      }
      $this->assertTrue($ok);
      print_r($res);
    }

    /**
     * @covers LivreDB::selectLivre
     * @todo   Implement testSelectLivre().
     */
    public function testSelectLivre() {
      $this->livre = new LivreDB($this->pdodb);
      $l=$this->livre->selectLivre(5);
      $lvr=$this->livre->selectLivre($l->getId());
      $this->assertEquals($l->getTitre(), $lvr->getTitre());
      $this->assertEquals($l->getEdition(), $lvr->getEdition());
      $this->assertEquals($l->getInformation(), $lvr->getInformation());
      $this->assertEquals($l->getAuteur(), $lvr->getAuteur());
      print_r($lvr);
    }

}
