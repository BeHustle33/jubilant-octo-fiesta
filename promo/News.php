<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Dashboard.php');

class News extends Dashboard
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('NewsModel');
    }

    public function index()
    {
        if ($this->permissions['news_view']) {
            $this->loadHeader();
            $this->load->view('dashboard/news', array('news' => $this->NewsModel->getNews(), 'permissions' => $this->permissions));
            $this->loadFooter();
        } else {
            $this->viewNoPermission();
        }
    }
}