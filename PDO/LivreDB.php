<?php
require_once "Constantes.php";
require_once "metier/Livre.php";
require_once "MediathequeDB.php";

class LivreDB extends MediathequeDB
{
	private $db; // Instance de PDO
	public $lastId;
	//TODO implementer les fonctions
	public function __construct($db)
	{
		$this->db=$db;
	}
	/**
	 *
	 * fonction d'Insertion de l'objet Livre en base de donnee
	 * @param Livre $l
	 */
	public function ajout(Livre $l):void
	{
		$q = $this->db->prepare('INSERT INTO livre(titre,edition,information,auteur) values(:titre,:edition,:information,:auteur)');
	$q->bindValue(':titre',$l->getTitre());
	$q->bindValue(':edition',$l->getEdition());
	$q->bindValue(':information',$l->getInformation());
	$q->bindValue(':auteur',$l->getAuteur());
	$q->execute();
	$q->closeCursor();
	$q = NULL;



	}
/**
	 *
	 * fonction d'update de l'objet Livre en base de donnee
	 * @param Livre $l
	 */
	public function update(Livre $l)
	{
		try {
		$q = $this->db->prepare('UPDATE livre set titre=:titre,edition=:edition,information=:information,auteur=:auteur where id=:id');
		$q->bindValue(':id', $l->getId());
		$q->bindValue(':titre',$l->getTitre());
		$q->bindValue(':edition',$l->getEdition());
		$q->bindValue(':information',$l->getInformation());
		$q->bindValue(':auteur',$l->getAuteur());
		$q->execute();
		$q->closeCursor();
		$q = NULL;

		}
		catch(Exception $e){
			var_dump($e);

		}

	}
    /**
     *
     * fonction de Suppression de l'objet Livre
     * @param Livre $l
     */
	public function suppression($id):void
	{
		$q = $this->db->prepare('delete from livre where titre=:titre and edition=:edition and auteur=:auteur');
		$q->bindValue(':titre',$l->getTitre());
		$q->bindValue(':edition',$l->getEdition());
		$q->bindValue(':auteur',$l->getAuteur());
	 	$q->execute();
	 	$q->closeCursor();
	 	$q = NULL;

	}
/**
	 *
	 * Fonction qui retourne toutes les livres
	 * @throws Exception
	 */
	public function selectAll(){
		$query = 'SELECT titre,edition,information,auteur FROM livre';
		$q = $this->db->prepare($query);
		$q->execute();

		$arrAll = $q->fetchAll(PDO::FETCH_ASSOC);

		//si pas de livres , on leve une exception
		if(empty($arrAll)){
			throw new Exception(Constantes::EXCEPTION_DB_LIVRE);
		}


		//Clore la requete préparée
		$q->closeCursor();
		$q = NULL;
		//retour du resultat
		return $arrAll;

	}
public function selectLivre($id){
	$query = 'SELECT id,titre,edition,information,auteur FROM livre  WHERE id= :id ';
	$q = $this->db->prepare($query);
	$q->bindValue(':id',$id);
	$q->execute();
	$arrAll = $q->fetch(PDO::FETCH_ASSOC);
	//si pas de livre, on leve une exception
	if(empty($arrAll)){
		throw new Exception(Constantes::EXCEPTION_DB_LIVRE);

	}
	$result=$arrAll;
	$q->closeCursor();
	$q = NULL;
	//conversion du resultat de la requete en objet livre
	$res= $this->convertPdoLiv($result);
	//retour du resultat
	return $res;
	}
        /**
	 *
	 * Fonction qui convertie un PDO Livre en objet Livre
	 * @param $pdoLivr
	 * @throws Exception
	 */
	public function convertPdoLiv($pdoLivr){
	if(empty($pdoLivr)){
		throw new Exception(Constantes::EXCEPTION_DB_CONVERT_LIVR);
	}
	try{
	//conversion du pdo en objet
	$obj=(object)$pdoLivr;
	$id= (int)$obj->id;
	//conversion de l'objet en objet livre
	$lvr=new Livre($id,$obj->titre,$obj->edition,$obj->information,$obj->auteur);
	//affectation de l'id livre
	$lvr->setId($obj->id);
		return $lvr;

	}catch(Exception $e){
		throw new Exception(Constantes::EXCEPTION_DB_CONVERT_LIVR.$e);
	}
	}
}
