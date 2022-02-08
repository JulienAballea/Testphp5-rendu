<?php
class validLivreController  {

  public function __construct()
  {
    session_start();
    error_reporting(0);
    require_once "controller/Controller.php";
    require_once "metier/Livre.php";
    require_once "PDO/LivreDB.php";
    require_once "PDO/connectionPDO.php";
    require_once "Constantes.php";
    //recuperation des valeurs du compte venant du formulaire MonCompte
    //personne
    $titre = $_POST['titre'] ?? null;
    $edition = $_POST['edition']?? null;
    $information = $_POST['info']?? null;
    $auteur = $_POST['auteur']?? null;
    //action pour update ou insert, delete, select selectall
    $operation = $_GET['operation']?? null;



    //TODO
    if(Controller::auth()){

      if($operation=="insert"){

        try{
          //connexion a la bdd
          $accesLivreBDD=new LivreDB($pdo);
          //TODO insertion du livre en bdd
          $lvr=new Livre($titre,$edition,$information,$auteur);
          $ajout = $accesLivreBDD->ajout($lvr);
    
        }
        //levée d'exception si probleme insertion en base de données
        catch(Exception $e) {
          //appel de la constantes définit dans Contantes.php pour afficher un message compréhensible
          //pour l'utilisateur
          throw new Exception(Constantes::EXCEPTION_DB_LIVRE);
        }
      }
    }
    else {
      //erreur on renvoit à la page d'accueil
      header('Location: accueil.php?id='.$_SESSION["token"]);

    }
  }
}
