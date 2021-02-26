<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MCyber extends CI_Model{
    public function __construct()
    {   
    }

    public function setCyberData($email, $company_name, $domain_names) {
        $this->db->reset_query();

        $this->db->where('customer_email', $email);
        $query = $this->db->get('quote_current');
        $result = $query->result_array();
        if (count($result) == 0) {
            $this->db->insert('quote_current', array('customer_email' => $email, 'company_name' => $company_name, 'domain_names' => $domain_names));
        }
        else {
            $this->db->reset_query();
            $this->db->where('customer_email', $email);
            $this->db->update('quote_current', array('company_name' => $company_name, 'domain_names' => $domain_names));
        }
    }

    public function updateCyberData($email, $updateData) {
        $this->db->reset_query();

        $this->db->where('customer_email', $email);
        $this->db->update('quote_current', $updateData);
    }

    public function deleteCyberCurrentByEmail($email) {
        $this->db->reset_query();

        $this->db->where('customer_email', $email);
        $this->db->delete('quote_current');
    }

    public function getCurrentCyberData($email) {
        $this->db->reset_query();
        $this->db->where('customer_email', $email);
        $query = $this->db->get('quote_current');
        $result = $query->result_array();
        if (count($result)) {
            return $result[0];
        }
        return null;
    }

    public function insertCompleteQuote($data) {
        $this->db->reset_query();
        $this->db->insert('quote_history', $data);
    }
}