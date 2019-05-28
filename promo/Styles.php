<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Dashboard.php');

class Styles extends Dashboard
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ServicesModel');
    }

    public function viewStyle($slug_style = null)
    {
        //TODO $_GET Check
        if (($slug_style == null && $this->permissions['styles_add']) || ($slug_style != null && $this->permissions['styles_edit'])) {
            if ($slug_style == null) {
                $style['slug_service'] = $_GET['service'];
            } else {
                $style = $this->ServicesModel->getStyle($_GET['service'], $slug_style);
            }

            $this->loadHeader();
            $this->load->view('dashboard/style', array(
                'style' => $style,
                'fields' => $this->FieldsModel->getFields('styles'),
                'files' => $this->FieldsModel->getFiles('styles'),
                'permissions' => $this->permissions
            ));
            $this->loadFooter();
        }
    }
}