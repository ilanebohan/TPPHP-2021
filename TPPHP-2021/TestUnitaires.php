<?php
use PHPUnit\Framework\TestCase;
include_once('class/mypdo.class.php');

class TestUnitaires extends TestCase
{
    private $vpdo;
     /**
     * @before
     */
    public function initTestEnvironment()
    {
        $this->vpdo = new mypdo ();

        $this->vpdo->insererPage(3,'TEST','Page classe de test');
    }


    public function test_liste_article()
    {
        $this->assertEquals($this->vpdo->liste_article('TEST')->rowCount(),0,'Erreur nombre Articles');

        $this->vpdo->insererArticle(15,'Article test 1','Article test 1','2022-04-07 00:00:00','2025-04-07 00:00:00',1,4);
        $this->vpdo->insererPublication(15,3,1);

        $this->assertEquals($this->vpdo->liste_article('TEST')->rowCount(),1,'Erreur nombre Articles');

        $this->vpdo->insererArticle(16,'Article test 2','Article test 2','2022-04-07 00:00:00','2025-04-07 00:00:00',1,4);
        $this->vpdo->insererPublication(16,3,2);

        $this->assertEquals($this->vpdo->liste_article('TEST')->rowCount(),2,'Erreur nombre Articles');

        $this->vpdo->insererArticle(17,'Article test 3','Article test 3','2022-04-07 00:00:00','2025-04-07 00:00:00',1,4);
        $this->vpdo->insererPublication(17,3,3);

        $this->assertEquals($this->vpdo->liste_article('TEST')->rowCount(),3,'Erreur nombre Articles');

        $this->vpdo->insererArticle(18,'Article test 4','Article test 4','2022-04-07 00:00:00','2025-04-07 00:00:00',1,4);
        $this->vpdo->insererPublication(18,3,4);

        $this->assertEquals($this->vpdo->liste_article('TEST')->rowCount(),4,'Erreur nombre Articles');

    }


     /**
     * @after
     */
    public function deinitTestEnvironment()
    {
        $this->vpdo->supprimerPublication(15,3);
        $this->vpdo->supprimerPublication(16,3);
        $this->vpdo->supprimerPublication(17,3);
        $this->vpdo->supprimerPublication(18,3);

        $this->vpdo->supprimerArticle(15);
        $this->vpdo->supprimerArticle(16);
        $this->vpdo->supprimerArticle(17);
        $this->vpdo->supprimerArticle(18);

        $this->vpdo->supprimerPage(3);
    }


}


?>