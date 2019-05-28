<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public $permissions;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('directory');
        $this->load->helper('file');
        $this->load->model('BaseModel');
        $this->load->model('FieldsModel');
        $this->load->library('Authentication');
        if ($this->authentication->is_logged_in()) {
            $this->permissions = $this->authentication->get_permissions();
        } else {
            redirect('auth');
        }
    }

    public function loadHeader()
    {
        $this->load->view('dashboard/_head');
        $this->load->view('dashboard/_header', array('permissions' => $this->permissions));
    }

    public function loadFooter()
    {
        $this->load->view('dashboard/_footer');
        $this->load->view('dashboard/_foot');
    }

    public function index()
    {
        $this->loadHeader();
        $this->load->view('dashboard/index');
        $this->loadFooter();
    }

    public function view404()
    {
        $this->loadHeader();
        $this->load->view('dashboard/no_page');
        $this->loadFooter();
    }

    public function viewNoPermission()
    {
        $this->loadHeader();
        $this->load->view('dashboard/no_permission');
        $this->loadFooter();
    }

    public function addData()
    {
        $model = $this->input->post('model');
        $data = $this->input->post();
        unset($data['model']);

        if ($this->permissions[$model . '_add']) {
            $this->BaseModel->insertData($model, $data);
            //TODO Create dir
            if ($model != 'styles') {
                redirect('dashboard/' . $model, 'refresh');
            } else {
                redirect('dashboard/services/' . $this->input->post('slug_service'), 'refresh');
            }
        } else {
            $this->viewNoPermission();
        }
    }

    public function updateData()
    {
        if (isset($_POST) && array_key_exists('model', $_POST)) {
            $model = $_POST['model'];
            $data = $_POST;
            unset($data['model']);
            try {
                if ($this->permissions[$model . '_edit']) {
                    if ($this->BaseModel->updateData($model, $data)) {
                        echo json_encode(array('status' => 'ok', 'message' => 'Данные обновлены.', 'code' => '000', 'data' => $data));
                    } else {
                        echo json_encode(array('status' => 'fail', 'message' => 'Данные не обновлены.', 'code' => '002', 'data' => $data));
                    }
                } else {
                    echo json_encode(array('status' => 'fail', 'message' => 'У вас нет досутпа!', 'code' => '004'));
                }
            } catch (Exception $e) {
                echo json_encode(array('status' => 'fail', 'message' => 'Внутренняя ошибка сервера. Попробуйте еще раз.', 'code' => '001'));
            }
        } else {
            echo json_encode(array('status' => 'fail', 'message' => 'Нет данных.', 'code' => '001'));
        }
    }

    public function deleteData()
    {
        $model = $this->input->post('model');
        $data = $this->input->post();
        unset($data['model']);
        if ($this->permissions[$model . '_delete'] && $data['slug'] != 'default') {
            $this->BaseModel->deleteData($model, $data['slug']);
            //TODO Remove dir
            //TODO Create dir
            if ($model != 'styles') {
                redirect('dashboard/' . $model, 'refresh');
            } else {
                redirect('dashboard/services', 'refresh');
            }
        } else {
            $this->viewNoPermission();
        }
    }

    public function updateOrder()
    {
        if (isset($_POST)) {
            if ($this->permissions['order_by']) {
                if ($this->BaseModel->updateOrder($_POST)) {
                    echo json_encode(array('status' => 'ok', 'message' => 'Порядок обновлен.', 'code' => '000'));
                } else {
                    echo json_encode(array('status' => 'fail', 'message' => 'Порядок не обновлен.', 'code' => '002'));
                }
            } else {
                echo json_encode(array('status' => 'fail', 'message' => 'У вас нет досутпа!', 'code' => '004'));
            }
        } else {
            echo json_encode(array('status' => 'fail', 'message' => 'Нет данных.', 'code' => '001'));
        }
    }
}