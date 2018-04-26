<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Model\Product;
use Application\Services\ProductTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProduitsController extends AbstractActionController
{
    private $_id;
    private $_table;

    public function __construct(ProductTable $table)
    {
        $this->_table = $table;
    }


    public function produitsAction()
    {
        //Récupère l'objet ayant pour id celui de la route
        $this->_id=$this->params()->fromRoute('id');
        return new ViewModel([
            'product' => $this->_table->find($this->params()->fromRoute('id')),
            'id'=>$this->_id,
        ]);
    }
}
