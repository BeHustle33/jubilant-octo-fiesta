<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Dashboard.php');

class Services extends Dashboard
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ServicesModel');
    }

    public function index()
    {
        if ($this->permissions['services_view']) {
            $this->loadHeader();
            $this->load->view('dashboard/services', array('services' => $this->ServicesModel->getServices(), 'permissions' => $this->permissions));
            $this->loadFooter();
        } else {
            $this->viewNoPermission();
        }
    }

    public function viewService($service_slug = null)
    {
        if (($service_slug == null && $this->permissions['services_add']) || ($service_slug != null && $this->permissions['services_edit'])) {
            $this->loadHeader();
            $this->load->view('dashboard/service', array(
                'service' => $this->ServicesModel->getService($service_slug),
                'fields' => $this->FieldsModel->getFields('services'),
                'files' => $this->FieldsModel->getFiles('services'),
                'styles' => $this->ServicesModel->getStyles($service_slug)
            ));
            $this->loadFooter();
        } else {
            $this->viewNoPermission();
        }
    }
}