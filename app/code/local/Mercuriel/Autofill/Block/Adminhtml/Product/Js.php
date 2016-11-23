<?php
class Mercuriel_Autofill_Block_Adminhtml_Product_Js extends Mage_Core_Block_Template{

    public function getAutofillData()
    {
        //This fucntion will return the array which have type of $key -> $values
        //key is the id of autofill set that have the attribute set id is the sended attribute set id
        //And value take form the table autofill_value
        $returnData = array();
        $param = $this->getRequest()->getParam('set');
        $keys = Mage::getModel('mercuriel_autofill/autofillSet')->getCollection()
            ->addFieldToFilter('attribute_set_id', $param);
        foreach($keys as $key){
            $values = Mage::getModel('mercuriel_autofill/autofillValue')->getCollection()
                ->addFieldToFilter('autofill_set_id', $key->getId());
            $autofillValues = array();
            foreach($values as $value){
                $autofillValues[Mage::getModel('eav/entity_attribute')
                    ->load((int)($value->getAttributeId()))->getAttributeCode()] = $value->getValue();

            }
            $returnData[$key->getId()] = $autofillValues;
        }
        return $returnData;

    }

    public function getAutofillJsArray(){
        $autofillValueDatas = $this->getAutofillData();
        $string = "{";
        $flag1 = false;
        foreach($autofillValueDatas as $key => $autofillValueData){
            if($flag1)
            {
                $string .= ',';
            }
            $string .= $key.":{";
            $flag2 = false;
            foreach($autofillValueData as $key => $value){
                if($flag2){$string .= ',';}
                $value = str_replace(PHP_EOL, '\r\n', $value);
                $value = str_replace('\\r','\ \r', $value ); //
//                $value = str_replace('\n', '\\r\\n', $value); //Deal with the problem of line seperator in javascript
                $string .= '"'.$key.'"'.":".'"'.$value.'"';
                $flag2 = true;
            }
            $string .= "}";
            $flag1 = true;
        };
        $string .= "}";
        return $string;
    }

}