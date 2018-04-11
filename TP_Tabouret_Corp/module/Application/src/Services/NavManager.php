<?php
namespace Application\Services;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager
{

    private $authService;
    private $userManager;
    private $urlHelper;
    private $userPrivilege;
    private $privilege;

    public function __construct($authService, $urlHelper, $userManager, $userPrivilege,$privilege)
    {
        $this->authService = $authService;
        $this->userManager = $userManager;

        $this->urlHelper = $urlHelper;
        $this->userPrivilege = $userPrivilege;
        $this->privilege = $privilege;
    }

    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems()
    {
        $url = $this->urlHelper;
        $items = [];

        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => 'Sign in',
                'link'  => $url('login')
            ];
        } else {

            //Récupère id de l'utilisateur connecté
            $id=$this->userManager->findByMail($this->authService->getIdentity())->_id;

            //Récupère le pseudo de l'utilisateur connecté
            $username=$this->userManager->findByMail($this->authService->getIdentity())->_username;

            //Récupère l'id du privilege de l'utilisateur connecté
            $idPrivilege=$this->userPrivilege->findById($id)->_idPrivilege;

            //Récupère la valeur du privilege de l'utilisateur connecté
            $privilege=$this->privilege->findById($idPrivilege)->_value;

            //Si utilisateur admin, affiche lien d'admin
            if($idPrivilege==1){
                $items[] = [
                    'id' => 'administration',
                    'label' => 'Administration',
                    'link'=>$url('administration')
                ];
            }

            $items[] = [
                'id' => 'logout',
                'label' => $username."[".$privilege."]",
                'dropdown' => [
                    [
                        'id' => 'profil',
                        'label' => 'Profil',
                        'link'=>$url('profil')
                    ],
                    [
                        'id' => 'logout',
                        'label' => 'Déconnexion',
                        'link' => $url('logout')
                    ],

                ]
            ];
            $items[] = [
                'id' => 'panier',
                'label' => 'Panier',
                'link'=>$url('panier')
            ];


        }

        return $items;
    }
}