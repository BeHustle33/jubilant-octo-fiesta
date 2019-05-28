<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Dashboard.php');

class Blocks extends Dashboard
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('BlocksModel');
    }

    public function index()
    {
        if ($this->permissions['blocks_view']) {
            $this->loadHeader();
            $this->load->view('dashboard/blocks', array('blocks' => $this->BlocksModel->getBlocks(), 'permissions' => $this->permissions));
            $this->loadFooter();
        } else {
            $this->viewNoPermission();
        }
    }

    public function viewBlock($slug)
    {
        if ($this->permissions['blocks_edit']) {
            $block = $this->BlocksModel->getBlock($slug);
            if ($block) {
                $this->loadHeader();
                $this->load->view('dashboard/block', array('block' => $block));
                $this->loadFooter();
            } else {
                $this->view404();
            }
        } else {
            $this->viewNoPermission();
        }
    }

    public function updateData()
    {
        if (isset($_POST)) {
            try {
                if ($this->permissions['blocks_edit']) {
                    $slug = $_POST['slug'];
                    unset($_POST['slug']);
                    $content = json_encode($_POST);
                    if ($this->BlocksModel->updateBlock($slug, $content)) {
                        echo json_encode(array('status' => 'ok', 'message' => 'Данные обновлены.', 'code' => '000', 'data' => $_POST));
                    } else {
                        echo json_encode(array('status' => 'fail', 'message' => 'Данные не обновлены.', 'code' => '002', 'data' => $_POST));
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
}