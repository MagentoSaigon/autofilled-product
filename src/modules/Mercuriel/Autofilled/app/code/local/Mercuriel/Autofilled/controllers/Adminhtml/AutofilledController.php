<?php
class Mercuriel_Autofilled_Adminhtml_AutofilledController extends Mage_Adminhtml_Controller_Action{
    public function indexAction(){
        $this->loadLayout();
        $this->renderLayout();
        return $this;
    }
}
?>