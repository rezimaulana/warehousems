<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Request_trx extends CI_Model{
    
    function __construct(){
        parent::__construct();
        $this->load->model("Request_dtl");
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
    
    function accept($id, $ver, $type) {
        $this->db->trans_start();
        $currentVer = $this->db->select('ver')->where('id', $id)->where('ver', $ver)->get('request_hdr')->row()->ver;
        if ($currentVer == $ver) {
            $now = date('Y-m-d H:i:s');
            $data = array(
                'approved_by' => $this->session->userdata('userdata')['id'],
                'approval' => 1,
                'updated_by' => $this->session->userdata('userdata')['id'],
                'updated_at' => $now,
                'ver' => $currentVer + 1,
            );
            $this->db->where('id', $id)->update('request_hdr', $data);
            if ($this->db->affected_rows() === 1) {
                $items = $this->Request_dtl->getByHeaderId($id);
                $requestDtlData = array();
                foreach ($items as $item) {
                    $requestDtlData[] = array(
                        'id' => $item['id'],
                        'updated_by' => $this->session->userdata('userdata')['id'],
                        'updated_at' => $now,
                        'ver' => $item['ver'] + 1,
                    );
                }    
                $this->db->update_batch('request_dtl', $requestDtlData, 'id');
                if ($this->db->affected_rows() === count($items)) {
                    $goodsData = array();
                    if($type == CODE_REQUEST_TYPE_CHECK_IN){
                        foreach ($items as $item) {
                            $goodsData[] = array(
                                'id' => $item['goods_id'],
                                'qty' => $item['qty']+$item['req_qty'],
                                'updated_by' => $this->session->userdata('userdata')['id'],
                                'updated_at' => $now,
                                'ver' => $item['ver'] + 1,
                            );
                        }
                    } else {
                        foreach ($items as $item) {
                            $goodsData[] = array(
                                'id' => $item['goods_id'],
                                'qty' => $item['qty']-$item['req_qty'],
                                'updated_by' => $this->session->userdata('userdata')['id'],
                                'updated_at' => $now,
                                'ver' => $item['ver'] + 1,
                            );
                        }
                    }
                    $this->db->update_batch('goods', $goodsData, 'id');
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
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('error', RES_TRX_ROLLBACK);
                    return FALSE;
                }
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', RES_TRX_ROLLBACK);
                return FALSE;
            }
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', RES_VERSION_MISMATCH);
            return FALSE;
        }
    }

    function reject($id, $ver) {
        $this->db->trans_start();
        $currentVer = $this->db->select('ver')->where('id', $id)->where('ver', $ver)->get('request_hdr')->row()->ver;
        if ($currentVer == $ver) {
            $now = date('Y-m-d H:i:s');
            $data = array(
                'approved_by' => $this->session->userdata('userdata')['id'],
                'approval' => 0,
                'updated_by' => $this->session->userdata('userdata')['id'],
                'updated_at' => $now,
                'ver' => $currentVer + 1,
            );
            $this->db->where('id', $id)->update('request_hdr', $data);
            if ($this->db->affected_rows() === 1) {
                $this->db->trans_complete();
                $this->session->set_flashdata('success', RES_TRX_COMPLETE);
                return TRUE;
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', RES_TRX_ROLLBACK);
                return FALSE;
            }
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('error', RES_VERSION_MISMATCH);
            return FALSE;
        }
    }
    
}