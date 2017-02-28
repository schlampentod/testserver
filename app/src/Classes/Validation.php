<?php
namespace App\Classes;
use App\Model\M_BundlesDAO;
use App\Pojo\ResponsePojo;
use App\Classes\SettingClass;
class Validation {
    
    public $response;
public function __construct() {
    
   }
    //put your code here
    public function validation_security($req , $resp) {
        //var_dump(empty($req->getHeader('X-Oc-Merchant-Id'))); die();
        if(!empty($req->getHeader('X-Oc-Merchant-Id'))){
        $setting = new SettingClass();
        $key = $setting->get("webservice", "security_api");  
        $merchant = $req->getHeader('X-Oc-Merchant-Id');
        $session = $req->getHeader('X-Oc-Session');
        if($merchant[0] == $key){    
        
            return TRUE;
        }else {
           
            return FALSE;
           
        }
        
        
        }else{
            
            return FALSE;
        }
        
    }
    public function validorder($data) {
        $result = array("result" => true, "response" => "");

        if (!$this->validate_order_fields($data)['result']) {
            $response = $this->validate_order_fields($data)['response'];
            $result = array("result" => False, "response" => $response);
            
            return $result;
        } elseif (!$this->validate_order_bundles($data)['result']) {
            
            $result = array("result" => False, "response" => $this->validate_order_bundles($data)['response']);
            return $result;
        }
        return $result;
    }

    public function validate_completedeal($data) {
        $result = array("result" => TRUE, "response" => "");
        if (!$this->validate_customer_id($data)['result']) {

            return $this->validate_customer_id($data);
        } elseif (!$this->validate_invoice_id($data)['result']) {

            return $this->validate_invoice_id($data);
        } elseif (!$this->validate_ccname($data)['result']) {

            return $this->validate_ccname($data);
        } elseif (!$this->validate_ccexpiry($data)['result']) {
            return $this->validate_ccexpiry($data);
        } elseif (!$this->validate_ccemail($data)['result']) {
            return $this->validate_ccemail($data);
        } elseif (!$this->validate_ccvv($data)['result']) {
            return $this->validate_ccvv($data);
        } elseif (!$this->validate_delivery_address($data)['result']) {
            return $this->validate_delivery_address($data);
        } elseif (!$this->validate_card($data)['result']) {
            return $this->validate_card($data);
        } else {
            return $result;
        }
    }

    public function validate_registration($data) {
        $result = array("result" => TRUE, "response" => "");
        if (!$this->validate_customer_id($data)['result']) {
            return $this->validate_customer_id($data);
        } elseif (!$this->validate_ID_number($data)['result']) {
            return $this->validate_ID_number($data);
        } elseif (!$this->validate_password($data)['result']) {
            return $this->validate_password($data);
        } elseif (!$this->validate_residential($data)['result']) {
            return $this->validate_residential($data);
        } elseif (!$this->validate_ports($data)['result']) {

            return $this->validate_ports($data);
        } else {
            return $result;
        }
    }

    public function validate_getorder($data) {
        if($this->validation_security($data->request, $data->response)){
        $this->validate_get_orderhash($data);
        $response = $this->getValidationResponse();
        }else{
            $datares = new ResponsePojo("false", "Invalid Api Key", "00000");
            $this->setValidationResponse(false, $datares);
            $response = $this->getValidationResponse();
        }
        return $response; 
        
    }
    public function validate_imei($data) {
        if($this->validation_security($data->request, $data->response)){
        $this->validation_imei($data);
        $response = $this->getValidationResponse();
        }else{
            $datares = new ResponsePojo("false", "Invalid Api Key", "00000");
            $this->setValidationResponse(false, $datares);
            $response = $this->getValidationResponse();
        }
        return $response;
    }

    private function setValidationResponse($result = true, $response = '') {
        $this->response = array('result'=>$result, 'response'=>$response);
    }
    
    private function getValidationResponse() {
        return $this->response;
    }

    public function validate_iccid($data) {
       if($this->validation_security($data->request, $data->response)){
        $result = array("result" => TRUE, "response" => "");
        if (!$this->validation_iccid($data)['result']) {

            return $this->validation_iccid($data);
        } else {
            return $result;
        }
        
       }else{
            $datares = new ResponsePojo("false", "Invalid Api Key", "00000");
            $this->setValidationResponse(false, $datares);
            return  $this->getValidationResponse();
        }
    }

    //********************** Private function ****************
    private function validate_ports($data) {
        $result = array("result" => TRUE, "response" => "");
        if (isset($data->ports)) {
            if (!$this->validate_order_id($data)['result']) {
                return $this->validate_order_id($data);
            } elseif (!$this->validate_port($data)['result']) {
                return $this->validate_port($data);
            } elseif (!$this->validate_MSISDN($data)['result']) {
                return $this->validate_MSISDN($data);
            } elseif (!$this->validate_network($data)['result']) {

                return $this->validate_network($data);
            } elseif (!$this->validate_contract_type($data)['result']) {
                return $this->validate_contract_type($data);
            }
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_Type_Business($data, $i) {
        $result = array("result" => TRUE, "response" => "");
        if (!$this->validate_registration_number($data, $i)['result']) {
            return $this->validate_registration_number($data, $i);
        } elseif (!$this->validate_business_contact_person($data, $i)['result']) {
            return $this->validate_business_contact_person($data, $i);
        } elseif (!$this->validate_business_contact_number($data, $i)['result']) {
            return $this->validate_business_contact_number($data, $i);
        } elseif (!$this->validate_business_network_account($data, $i)['result']) {
            return $this->validate_business_network_account($data, $i);
        }

        return $result;
    }

    private function dealcheck($dealid) {
        $result = array("result" => TRUE, "response" => "");
        $deal = new M_BundlesDAO();
        if (!$deal->deal_exist($dealid)) {
            $response = new ResponsePojo("false", "deal doesn't exist", "12400");
            $result = array("result" => FALSE, "response" => $response);
        }
        return $result;
    }

    private function bundlecheck($productIDs) {
        $result = array("result" => TRUE, "response" => "");
        $bundle = new M_BundlesDAO();
        for ($j = 0, $l = count($productIDs); $j < $l; ++$j) {
            $Pid = $productIDs[$j];
            if (!$bundle->bundle_exist($Pid)) {
                $response = new ResponsePojo("false", "One of the product doesn't exist", "12400");
                $result = array("result" => FALSE, "response" => $response);

                break;
            }
        }

        return $result;
    }

    private function validate_order_fields($data) {
        $result = array("result" => TRUE, "response" => "");
        if (!$this->validate_email($data)['result']) {
            return $this->validate_email($data);
        } elseif (!$this->validate_name($data)['result']) {
            return $this->validate_name($data);
        } elseif (!$this->validate_contact_number($data)['result']) {
            return $this->validate_contact_number($data);
        } elseif (!$this->validate_cart($data)['result']) {

            return $this->validate_cart($data);
        } else {

            return $result;
        }
    }

    public function validate_checkinfos($data) {

        $result = array("result" => TRUE, "response" => "");
        if (!$this->validates_email($data)['result']) {

            return $this->validates_email($data);
        } else {
            return $result;
        }
    }

    private function validate_order_bundles($data) {

        $result = FALSE;
        for ($i = 0, $l = count($data->cart); $i < $l; ++$i) {
            if ($data->cart[$i]->deal_id == 0) {

                $result = $this->bundlecheck($data->cart[$i]->productIDs);
                
                if (!$result['result']) {
                    return $result;
                }
            } else {
                $result = $this->dealcheck($data->cart[$i]->deal_id);
                if (!$result['result']) {
                    return $result;
                }
            }
        }

        return $result;
    }

    private function validate_email($data) {

        if (!isset($data->email_address) || $data->email_address == "") {
            $response = new ResponsePojo("false", "no email address provided", "10200");
            $result = array("result" => FALSE, "response" => $response);
        } elseif (!filter_var($data->email_address, FILTER_VALIDATE_EMAIL)) {

            $response = new ResponsePojo("false", "not a valid email address", "10300");
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validates_email($data) {
        if (!isset($data->email) || $data->email == "") {
            $response = new ResponsePojo("false", "no email address provided", "10200");
            $result = array("result" => FALSE, "response" => $response);
        } elseif (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {

            $response = new ResponsePojo("false", "not a valid email address", "10300");
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_name($data) {

        if (!isset($data->full_name) || $data->full_name == "") {
            $response = new ResponsePojo("false", "no name provided", "11000");
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_contact_number($data) {

        if (!isset($data->contact_number) || $data->contact_number == "") {
            $response = new ResponsePojo("false", "no contact number provided", "11100");
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_cart($data) {
        $result = array("result" => TRUE, "response" => "");
        if (!isset($data->cart) || empty($data->cart)) {
            $response = new ResponsePojo("false", "cart cannot be empty", "11200");
            $result = array("result" => FALSE, "response" => $response);
            return $result;
        } elseif (!$this->validate_portnumber($data)['result']) {

            $result = $this->validate_portnumber($data);
            return $result;
        } elseif (!$this->validate_IB($data)['result']) {
            $result = $this->validate_IB($data);

            return $result;
        } elseif (!$this->validate_roaming($data)['result']) {
            $result = $this->validate_roaming($data);

            return $result;
        } elseif (!$this->validate_create_imei($data)['result']) {
            $result = $this->validate_create_imei($data);
            return $result;
        }else {

            return $result;
        }
    }

    private function validate_portnumber($data) {
        $result = array("result" => TRUE, "response" => "");
        for ($i = 0, $l = count($data->cart); $i < $l; ++$i) {

            if (!is_bool($data->cart[$i]->port_number) === true) {

                $response = new ResponsePojo("false", "porting can not be empty", "11220");
                $result = array("result" => FALSE, "response" => $response);
                
            }
            
            
            if (!$result['result']) {
                    break;
                }
        }
        return $result;
    }

    private function validate_IB($data) {
        $result = array("result" => TRUE, "response" => "");
        for ($i = 0, $l = count($data->cart); $i < $l; ++$i) {
            if (!is_bool($data->cart[$i]->IB) === true) {
                $response = new ResponsePojo("false", "ib can not be empty", "11230");
                $result = array("result" => FALSE, "response" => $response);
                
            }
            
            if (!$result['result']) {
                    break;
                }
        }
        return $result;
    }

    private function validate_roaming($data) {
        $result = array("result" => TRUE, "response" => "");
        for ($i = 0, $l = count($data->cart); $i < $l; ++$i) {
            if (!is_bool($data->cart[$i]->roaming) === true) {
                $response = new ResponsePojo("false", "roaming can not be empty", "11240");
                $result = array("result" => FALSE, "response" => $response);
                
            }
            if (!$result['result']) {
                    break;
                }
        }
        return $result;
    }
    private function validate_create_imei($data) {
        
        $checkimei = new M_BundlesDAO();
        $result = array("result" => TRUE, "response" => "");
        for ($i = 0, $l = count($data->cart); $i < $l; ++$i) {
            
            if(isset($data->cart[$i]->imei)){
            
                     if (!empty($data->cart[$i]->imei) && ($data->cart[$i]->deal_id ==0)) {
                    //if (!empty($data->cart[$i]->imei) && (!is_numeric($data->cart[$i]->imei) === true || $data->cart[$i]->deal_id ==0)) {
                        $response = new ResponsePojo("false", "This Imei doesn't correspond  for this Deal", "3100");
                        $result = array("result" => FALSE, "response" => $response);   
            }else if(!empty($data->cart[$i]->imei) && !$this->validate_iphone($data->cart[$i]->imei)){
                
                $response = new ResponsePojo("false", "Your IMEI is not Valid", "31000");
                $result = array("result" => FALSE, "response" => $response);
                
            }else if(!$checkimei->check_imei_exist($data->cart[$i]->imei)){
                $response = new ResponsePojo("false", $data->cart[$i]->imei." This IMEI have already been used", "32000");
                $result = array("result" => FALSE, "response" => $response);
            }
            if (!$result['result']) {
                    break;
                }
        
              }  
                
                
    }
    return $result;
    }


    
    private function validation_iccid($data) {

        if (!isset($data->iccid) || $data->iccid == "") {
            $response = new ResponsePojo("false", "no iccid was supplied", "10700");
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    function validatecard($cardnumber) {
        $cardnumber = preg_replace("/\D|\s/", "", $cardnumber);  # strip any non-digits
        $cardlength = strlen($cardnumber);
        $parity = $cardlength % 2;
        $sum = 0;
        for ($i = 0; $i < $cardlength; $i++) {
            $digit = $cardnumber[$i];
            if ($i % 2 == $parity)
                $digit = $digit * 2;
            if ($digit > 9)
                $digit = $digit - 9;
            $sum = $sum + $digit;
        }
        $valid = ($sum % 10 == 0);
        return $valid;
    }

    function check_card($cc, $extra_check = false) {
        $cards = array(
            "visa" => "(4\d{12}(?:\d{3})?)",
            "mastercard" => "(5[1-5]\d{14})"
        );
        $names = array("Visa", "Mastercard");
        $matches = array();
        $pattern = "#^(?:" . implode("|", $cards) . ")$#";
        $result = preg_match($pattern, str_replace(" ", "", $cc), $matches);
        return $result;
    }

    public function validate_card($data) {

        $check = $this->check_card($data->cc_number, true);
        if ($check > 0) {

            $result = array("result" => TRUE, "response" => "");
        } else {
            $response = new ResponsePojo("false", "not a valid Visa/Master card number", "11960");
            $response->paygate_error = "";
            $result = array("result" => FALSE, "response" => $response);
        }
        return $result;
    }

    private function validate_customer_id($data) {

        if (!isset($data->customerID) || $data->customerID == "") {
            $response = new ResponsePojo("false", "no customer id provided", "11300");
            $response->paygate_error = "";
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_invoice_id($data) {

        if (!isset($data->invoice_id) || $data->invoice_id == "") {
            $response = new ResponsePojo("false", "no invoice id provided", "11800");
            $response->paygate_error = "";
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_ccname($data) {

        if (!isset($data->cc_name) || $data->cc_name == "") {
            $response = new ResponsePojo("false", "no cc name provided", "11910");
            $response->paygate_error = "";
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_ccexpiry($data) {

        if (!isset($data->cc_expiry) || $data->cc_expiry == "") {
            $response = new ResponsePojo("false", "no cc expiry provided", "11930");
            $response->paygate_error = "";
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_ccemail($data) {

        if (!isset($data->cc_email) || $data->cc_email == "") {
            $response = new ResponsePojo("false", "no cc email provided", "11940");
            $response->paygate_error = "";
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_ccvv($data) {

        if (!isset($data->cc_cvv) || $data->cc_cvv == "") {
            $response = new ResponsePojo("false", "no cc cvv provided", "11950");
            $response->paygate_error = "";
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_delivery_address($data) {

        if (!isset($data->delivery_address) || $data->delivery_address == "") {
            $response = new ResponsePojo("false", "no delivery address provided", "12000");
            $response->paygate_error = "";
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_get_orderhash($data) {

        if (!isset($data->order_hash) || $data->order_hash == "") {
            $response = new ResponsePojo("false", "no hash provided", "12100");

            $this->setValidationResponse(FALSE, $response);
        } else {
            $this->setValidationResponse();
        }
    }
    private function validation_imei($data) {
            $checkimei = new M_BundlesDAO();
        if (!isset($data->imei) || $data->imei == "") {
            $response = new ResponsePojo("false", "no imei Provided", "3000");
            $this->setValidationResponse(FALSE, $response);
        } else if(!$this->validate_iphone($data->imei)){
            $response = new ResponsePojo("false", "Your IMEI is not Valid", "31000");
            $this->setValidationResponse(FALSE, $response);           
        }else if(!$checkimei->check_imei_exist($data->imei)){
            $response = new ResponsePojo("false", $data->imei."  have already been used", "32000");
            $this->setValidationResponse(FALSE, $response);
        }else {
            $this->setValidationResponse();
        }
    }
    
    private function validate_iphone($imei){
        
     if($this->valid_imei($imei)){
         return true;
         
     }else{
         return false;
     } 
         
        
    }
    private function valid_imei($imei){
        
	if (!preg_match('/^[0-9]{15}$/', $imei)) return false;
	$sum = 0;
	for ($i = 0; $i < 14; $i++)
	{
		$num = $imei[$i];
		if (($i % 2) != 0)
		{
			$num = $imei[$i] * 2;
			if ($num > 9)
			{
				$num = (string) $num;
				$num = $num[0] + $num[1];
			}
		}
		$sum += $num;
	}
	if ((($sum + $imei[14]) % 10) != 0) return false;
	return true;

    }
    
    
    private function validate_ID_number($data) {

        if (!isset($data->ID_number) || $data->ID_number == "") {
            $response = new ResponsePojo("false", "no id number provided", "11400");
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_password($data) {

        if (!isset($data->acccount_password) || $data->acccount_password == "") {
            $response = new ResponsePojo("false", "no password provided", "11500");
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_residential($data) {

        if (!isset($data->residential_address) || $data->residential_address == "") {
            $response = new ResponsePojo("false", "no residential address provided", "11600");
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_order_id($data) {
        $result = array("result" => TRUE, "response" => "");
        for ($i = 0, $l = count($data->ports); $i < $l; ++$i) {

            if (!isset($data->ports[$i]->order_id) || !is_numeric($data->ports[$i]->order_id)) {

                $response = new ResponsePojo("false", "no order id provided", "11700");
                $result = array("result" => FALSE, "response" => $response);

                if (!$result['result']) {
                    break;
                }
            }
        }


        return $result;
    }

    private function validate_port($data) {

        $result = array("result" => TRUE, "response" => "");
        for ($i = 0, $l = count($data->ports); $i < $l; ++$i) {

            if (!isset($data->ports[$i]->port_type) || $data->ports[$i]->port_type == "") {

                $response = new ResponsePojo("false", "no port type provided", "11710");
                $result = array("result" => FALSE, "response" => $response);
            } elseif ($data->ports[$i]->port_type === "business") {
                $result = $this->validate_Type_Business($data, $i);
            }
            if (!$result['result']) {
                break;
            }
        }
        return $result;
    }

    private function validate_MSISDN($data) {

        $result = array("result" => TRUE, "response" => "");
        for ($i = 0, $l = count($data->ports); $i < $l; ++$i) {

            if (!isset($data->ports[$i]->MSISDN) || $data->ports[$i]->MSISDN == "") {

                $response = new ResponsePojo("false", "no MSISDN provided", "11720");
                $result = array("result" => FALSE, "response" => $response);

                if (!$result['result']) {
                    break;
                }
            }
        }
        return $result;
    }

    private function validate_network($data) {
        $result = array("result" => TRUE, "response" => "");
        for ($i = 0, $l = count($data->ports); $i < $l; ++$i) {

            if (!isset($data->ports[$i]->network) || $data->ports[$i]->network == "") {

                $response = new ResponsePojo("false", "no network provided", "11730");
                $result = array("result" => FALSE, "response" => $response);

                if (!$result['result']) {
                    break;
                }
            }
        }

        return $result;
    }

    private function validate_contract_type($data) {

        $result = array("result" => TRUE, "response" => "");
        for ($i = 0, $l = count($data->ports); $i < $l; ++$i) {

            if (!isset($data->ports[$i]->contract_type) || $data->ports[$i]->contract_type == "") {

                $response = new ResponsePojo("false", "no contract type provided", "11750");
                $result = array("result" => FALSE, "response" => $response);

                if (!$result['result']) {
                    break;
                }
            }
        }

        return $result;
    }

    private function validate_registration_number($data, $i) {

        if (!isset($data->ports[$i]->business_registration_no) || $data->ports[$i]->business_registration_no == "") {
            $response = new ResponsePojo("false", "no business registration number provided", "11760");
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_business_contact_person($data, $i) {

        if (!isset($data->ports[$i]->business_contact_person) || $data->ports[$i]->business_contact_person == "") {
            $response = new ResponsePojo("false", "no business contact person provided", "11770");
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_business_contact_number($data, $i) {

        if (!isset($data->ports[$i]->business_contact_number) || $data->ports[$i]->business_contact_number == "") {
            $response = new ResponsePojo("false", "no business contact number provided", "11770");
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    private function validate_business_network_account($data, $i) {

        if (!isset($data->ports[$i]->business_network_account_number) || $data->ports[$i]->business_network_account_number == "") {
            $response = new ResponsePojo("false", "no business network account number provided", "11790");
            $result = array("result" => FALSE, "response" => $response);
        } else {
            $result = array("result" => TRUE, "response" => "");
        }
        return $result;
    }

    //********************************************************
}
