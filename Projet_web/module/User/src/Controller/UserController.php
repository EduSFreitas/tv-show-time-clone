<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;

use User\Services\UserManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Services\UtilisateurSerieTable;

class UserController extends AbstractActionController
{
    private $authService;
    private $userManager;
    private $_utilisateurSerie;

    public function __construct($authService,UserManager $userManager,UtilisateurSerieTable $utilisateurSerie)
    {
        $this->authService = $authService;
        $this->userManager = $userManager;
        $this->_utilisateurSerie = $utilisateurSerie;
    }

    public function userAction()
    {
        //Récupère id de l'utilisateur connecté
        $id=$this->userManager->findByMail($this->authService->getIdentity())->_id;

        //Récupère mail de l'utilisateur connecté
        $mail=$this->authService->getIdentity();

        //Récupère pseudo de l'utilisateur connecté
        $username=$this->userManager->findByMail($this->authService->getIdentity())->_username;

        $user=$this->userManager->findByMail($this->authService->getIdentity());



        $series=$this->_utilisateurSerie->fetchByUserConnected();


        //Récupère séries en cours
        return new ViewModel([
            'user'=>$user,
            'username'=>$username,
            'id'=>$id,
            'series'=>$series,
        ]);
    }

}

