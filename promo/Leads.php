<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Dashboard.php');

class Leads extends Dashboard
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('LeadsModel');
    }

    public function index()
    {
        if ($this->permissions['leads_view']) {
            $this->loadHeader();
            $this->load->view('dashboard/leads', array('leads' => $this->LeadsModel->getLeads()));
            $this->loadFooter();
        } else {
            $this->viewNoPermission();
        }
    }

    private function getEmailField($name)
    {
        switch ($name) {
            case 'about':
                return 'О проекте';
            case 'name':
                return 'Имя';
            case 'tel':
                return 'Телефон';
            case 'mail':
                return 'E-mail';
            case 'url':
                return 'URL:';
            case 'file':
                return 'Файл во вложении';
            case 'subject':
                return 'Тема';
            case 'message':
                return 'Сообщение';
            case 'salon':
                return 'Салон';
            case 'service':
                return 'Услуга';
            case 'style':
                return 'Подуслуга';
            default:
                return 'undefined';
        }
    }
}