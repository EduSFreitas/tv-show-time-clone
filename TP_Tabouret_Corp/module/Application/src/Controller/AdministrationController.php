<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Services\PanierTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Services\ProductTable;

class AdministrationController extends AbstractActionController
{
    private $_table;
    private $_panierTable;

    public function __construct(ProductTable $table,PanierTable $panierTable)
    {
        $this->_table = $table;
        $this->_panierTable = $panierTable;
    }

    //Affiche tous les produits sur la page administration
    public function administrationAction()
    {
        return new ViewModel([
            'products' => $this->_table->fetchAll(),
        ]);
    }

    //Supprime un produit
    public function suppressionAction(){

        //Supprime le produit de tous les paniers
        $this->_panierTable->deleteAll($this->params()->fromRoute('id'));

        //Supprime l'objet
        $this->_table->delete($this->params()->fromRoute('id'));

        return $this->redirect()->toRoute('administration');
    }

    //Ajoute un produit
    public function ajoutAction(){

        //Récupère données du formulaire
        $request = $this->getRequest()->getPost();

        //Insere les données
        $this->_table->insert($request['name'],$request['description'],$request['price']);

        return $this->redirect()->toRoute('administration');
    }

    //Edite un produit
    public function editionAction(){

    //Récupère données du formulaire
    $request = $this->getRequest()->getPost();

    //Insere les données
    $this->_table->update($request['id'],$request['name'],$request['description'],$request['price']);

    return $this->redirect()->toRoute('administration');
}


}
