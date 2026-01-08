<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	function __construct() {
		parent::__construct();
	    $this->load->helper('url');
	    $this->load->model('float_model');
	}
// 	public function viewOrder($doubleEncodedParams)
// 	{ 
// 	        $decodedParams = urldecode(urldecode(urldecode($doubleEncodedParams)));
//           $decryptedParams = $this->encryption->decrypt($decodedParams);
//           list($tenantIdentifier, $orderNo) = explode('|', $decryptedParams);
//           $this->session->set_userdata('tenantIdentifier',$tenantIdentifier);
//      	  initializeTenantDbConfig($tenantIdentifier);
	  
// 	  // update the status to viewed the moment they open the link
//       $Builddata = array( 
// 						'orderStatus'=> 'Viewed',
// 						'updated_date' => date('Y-m-d'),
// 					);
//       $this->float_model->officeBuildUpdate($Builddata,$orderNo); 
      	
//       	$data['frontOfficeBuildData'] = $this->float_model->getOfficeBuildByID($orderNo); 
      	
//     //   	echo "<pre>"; print_r(unserialize($data['frontOfficeBuildData']['otherDetails'])); exit;
// 		$data['disabled'] = 'disabled';
// 		$data['orderNumber'] = $orderNo;
// 		$this->load->view('general/header');
// 		$this->load->view('Cash/bankOrder',$data);
// 		 $this->load->view('general/footer');
	  
// 	}
	
	public function paymentLink($doubleEncodedParams){
	   
	      $decodedParams = urldecode(urldecode(urldecode($doubleEncodedParams)));
           $decryptedParams = $this->encryption->decrypt($decodedParams);
           list($tenantIdentifier, $orderNo) = explode('|', $decryptedParams);
           $this->session->set_userdata('tenantIdentifier',$tenantIdentifier);
     	  initializeTenantDbConfig($tenantIdentifier); 
     	  
     	  
     	$this->load->view('general/header');
        $this->load->view('Order/paymentLink',$data);   
        $this->load->view('general/footer');
	}
	
	public function process_payment() {
        // Get POST data
        $input = json_decode(file_get_contents('php://input'), true);
        $token = $input['token'];
        $amount = $input['amount'];
        $orderId = $input['orderId'];

        // SecurePay sandbox credentials
        $merchantId = 'TEST';
        $password = 'abc123';
        $endpoint = 'https://test.securepay.com.au/xmlapi/payment';

        // XML request body
    $xml = <<<XML
<SecurePayMessage>
  <MessageInfo>
    <messageID>{$orderId}</messageID>
    <messageTimestamp>{$messageTimestamp}</messageTimestamp>
    <apiVersion>xml-4.2</apiVersion>
  </MessageInfo>
  <MerchantInfo>
    <merchantID>{$merchantId}</merchantID>
    <password>{$password}</password>
  </MerchantInfo>
  <RequestType>Payment</RequestType>
  <Payment>
    <TxnList count="1">
      <Txn>
        <txnType>0</txnType>
        <txnSource>23</txnSource>
        <amount>" . ($amount * 100) . "</amount>
        <purchaseOrderNo>{$orderId}</purchaseOrderNo>
        <tokenValue>{$token}</tokenValue>
      </Txn>
    </TxnList>
  </Payment>
</SecurePayMessage>
XML;


        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        // Parse response
        if (strpos($response, '<statusCode>0</statusCode>') !== false) {
            echo json_encode(['success' => true, 'message' => 'Payment successful']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Payment failed']);
        }
    }
	

}