<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Semysms {
    protected $device;
    protected $token;

    public function __construct () {

        $ci 		= & get_instance();
        if (is_superadmin_loggedin()) {
            $branchID = $ci->input->post('branch_id');
        } else {
            $branchID = get_loggedin_branch_id();
        }
        $bulksms = $ci->db->get_where('semysms_config', array('branch_id' => $branchID))->row_array();

        $this->device = $bulksms['device'];
        $this->token = $bulksms['token'];

    }


    public function send_message($to, $message) {
        $url = "https://semysms.net/api/3/sms.php"; //Url address for sending SMS
        $phone = $to; // Phone number
        $phone = '+963'. (string)(int)$phone;
        $msg = $message;  // Message
        $device = $this->device;  //  Device code
        $token = $this->token;  //  Your token (secret)

        $data = array(
            "phone" => $phone,
            "msg" => $msg,
            "device" => $device,
            "token" => $token
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($curl);
        curl_close($curl);

        if(property_exists($output, 'error')){
            return false;
        }
        return true;
    }

}





























?>