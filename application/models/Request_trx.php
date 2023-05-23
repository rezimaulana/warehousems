<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Request_trx extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }

    function insert($trxCode, $items) {
        $this->db->trans_start();
        $uuid = $this->db->query('SELECT UUID() AS uuid')->row()->uuid;
        $now = date('Y-m-d H:i:s');
        $data = array(
            'id' => $uuid,
            'trx_code' => $trxCode,
            'request_type_id' => $this->input->post('request'),
            'requested_by' => $this->session->userdata('userdata')['id'],
            'created_by' => $this->session->userdata('userdata')['id'],
            'created_at' => $now,
        );
        $this->db->insert('request_hdr', $data);
    
        if ($this->db->affected_rows() === 1) {
            $requestHdrId = $uuid;
            $requestDtlData = array();
            foreach ($items as $item) {
                $requestDtlUUID = $this->db->query('SELECT UUID() AS uuid')->row()->uuid;
                $requestDtlData[] = array(
                    'id' => $requestDtlUUID,
                    'goods_id' => $item['id'],
                    'request_hdr_id' => $requestHdrId,
                    'qty' => $item['qty'],
                    'created_by' => $this->session->userdata('userdata')['id'],
                    'created_at' => $now,
                );
            }
            $this->db->insert_batch('request_dtl', $requestDtlData);
            if ($this->db->affected_rows() === count($items)) {
                $this->db->trans_complete();
                $this->session->set_flashdata('success', RES_TRX_COMPLETE);
                return TRUE;
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', RES_TRX_ROLLBACK);
                return FALSE;
            }
        } else {
            $this->session->set_flashdata('error', RES_TRX_ROLLBACK);
            $this->db->trans_rollback();
            return FALSE;
        }

    }
    
    
}