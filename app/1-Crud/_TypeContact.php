<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of _TypeContact
 *
 * @author user
 */

require_once 'DataBaseConnection.php';
require_once './2-Model/TypeContact.php';

class _TypeContact extends DataBaseConnection {

    function __construct() {
        parent::__construct();
    }

    //Recuperer la liste des TypeContact
    function getAllTypeContact() {
// Initialiser la connexion BDD
        try {
            // LIST: CONTIENDRA UN TABLEAU D'OBJETS
            $list = array();
            if (is_null(parent::getBdd())) {
                parent::__construct();
            }
            if (!parent::getBdd()->inTransaction()) {
                parent::getBdd()->beginTransaction();
            }
// Query SQL
            $query = "SELECT * FROM TypeContact";


            $response = parent::getBdd()->query($query);
// Boucler sur les resultats            
            while ($data = $response->fetch()) {
                // SI ID exite => Creer l'objet
                if (isset($data['id'])) {
                    $object = new TypeContact($data['id']);
                } else {
                    // ERROR
                    return null;
                }

                // REMPLIR LOBJET AVEC LES ATTRIBUTS


                if (isset($data['libelle'])) {
                    $object->setLibelle($data['libelle']);
                }


                // REMPLIR LA LISTE AVEC
                array_push($list, $object);
            }
            $response->closeCursor();
            if (empty($list)) {
                return null;
            }
            return $list;
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        return null;
    }

    function getTypeContactByID($id) {
        try {
            // INITIALISER LA CONNEXION BDD
            if (is_null(parent::getBdd())) {
                parent::__construct();
            }
            if (!parent::getBdd()->inTransaction()) {
                parent::getBdd()->beginTransaction();
            }

            // PREPARER LA SQL QUERY
            $query = "SELECT * FROM TypeContact WHERE ID = :id";
            $request = parent::getBdd()->prepare($query);
            // MAPPER L'ID
            $request->bindParam(':id', $id);
            $request->execute();
            $data = $request->fetch();
            //INSTENTIER L'OBJET
            $object = new TypeContact($data['ID']);
            if (isset($data['libelle'])) {
                $object->setLibelle($data['libelle']);
            }

            $request->closeCursor();
            return $object;
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        return null;
    }

}


?>
