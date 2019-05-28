<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Dashboard.php');

class Settings extends Dashboard
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->permissions['settings_view']) {
            $this->loadHeader();
            $this->load->view('dashboard/settings', array('files' => $this->FieldsModel->getFiles('general')));
            $this->loadFooter();
        } else {
            $this->viewNoPermission();
        }
    }
}