<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Dashboard.php');

class Salons extends Dashboard
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SalonsModel');
    }

    public function index()
    {
        if ($this->permissions['salons_view']) {
            $this->loadHeader();
            $this->load->view('dashboard/salons', array('salons' => $this->SalonsModel->getSalons(), 'permissions' => $this->permissions));
            $this->loadFooter();
        } else {
            $this->viewNoPermission();
        }
    }

    public function viewSalon($salon_slug = null)
    {
        if (($salon_slug == null && $this->permissions['salons_add']) || ($salon_slug != null && $this->permissions['salons_edit'])) {
            $this->loadHeader();
            $this->load->view('dashboard/salon', array(
                'salon' => $this->SalonsModel->getSalon($salon_slug, null, false),
                'fields' => $this->FieldsModel->getFields('salons'),
                'files' => $this->FieldsModel->getFiles('salons'),
                'permissions' => $this->permissions
            ));
            $this->loadFooter();
        } else {
            $this->viewNoPermission();
        }
    }
}