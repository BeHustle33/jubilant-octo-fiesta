<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploader extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Authentication');
        if ($this->authentication->is_logged_in()) {
            $this->load->helper('url');
            $this->load->model('FieldsModel');
        } else {
            //echo json_encode(array('status' => 'fail', 'message' => 'Auth error.', 'code' => '999'));
            die('Auth error');
        }
    }

    /* Upload single image */
    public function uploadImage()
    {
        /*
         * Response codes
         * 000 - Нет ошибок
         * 001 - Нет данных
         * 002 - Ошибка получения параметров файла
         * 003 - Ошибка получения пути файла
         * 004 - Ошибка перемещения файла
         * 005 - Требования не соблюдены
         * 006 - Нет папки салона
         */
        if (isset($_POST) &&
            isset($_FILES) &&
            array_key_exists('upload', $_FILES) &&
            count($_FILES['upload']) > 0 &&
            array_key_exists('slug', $_POST) &&
            array_key_exists('img_name', $_POST) &&
            array_key_exists('type', $_POST)
        ) {
            $type = $_POST['type'];
            if ($this->authentication->has_permission($type . '_upload')) {
                $img_name = $_POST['img_name'];
                $tmpFilePath = $_FILES['upload']['tmp_name'][0];
                $tmpFileType = $_FILES['upload']['type'][0];
                $tmpFileExtension = pathinfo($_FILES['upload']['name'][0], PATHINFO_EXTENSION);
                $tmpFileSize = $_FILES['upload']['size'][0];
                $tmpImageInfo = getimagesize($_FILES['upload']['tmp_name'][0]);
                if (array_key_exists('img_slug', $_POST)) {
                    $fileParams = $this->FieldsModel->getFile($_POST['img_slug'], $_POST['img_slug']);
                } else {
                    $fileParams = $this->FieldsModel->getFile($type, $img_name);
                }
                if ($fileParams) {
                    if (
                        $tmpFileType != $fileParams['mime'] ||
                        $tmpImageInfo['mime'] != $fileParams['mime'] ||
                        $tmpFileExtension != $fileParams['ext'] ||
                        $tmpFileSize > $fileParams['max_size'] ||
                        $tmpImageInfo[0] > $fileParams['max_width'] ||
                        $tmpImageInfo[0] < $fileParams['min_width'] ||
                        $tmpImageInfo[1] > $fileParams['max_height'] ||
                        $tmpImageInfo[1] < $fileParams['min_height']
                    ) {
                        if ($tmpFileExtension === 'svg') {
                            //Do nothing
                        } else {
                            echo json_encode(array('status' => 'fail', 'message' => 'Изображение не удовлетворяет требованиям.', 'code' => '005', 'fileparams' => $fileParams));
                            return;
                        }
                    }
                    // Make sure we have a file path
                    if ($tmpFilePath != '') {
                        // Setup new file path
                        if (!file_exists('./media/' . $_POST['type'] . '/' . $_POST['slug'] . '/')) {
                            mkdir('./media/' . $_POST['type'] . '/' . $_POST['slug']);
                            //echo json_encode(array('status' => 'fail', 'message' => 'Салон не сконфигурирован. Обратитесь к поставщику услуг.', 'code' => '006'));
                            //return;
                        }
                        $newFilePath = './media/' . $_POST['type'] . '/' . $_POST['slug'] . '/' . $_POST['img_name'] . '.' . $tmpFileExtension;
                        // Upload the file into the temp dir
                        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                            // Create path to update image in frontend
                            $path = base_url() . 'media/' . $_POST['type'] . '/' . $_POST['slug'] . '/' . $_POST['img_name'] . '.' . $tmpFileExtension;
                            echo json_encode(array('status' => 'ok', 'message' => 'Изображение загружено.', 'code' => '000', 'path' => $path));
                        } else {
                            echo json_encode(array('status' => 'fail', 'message' => 'Изображение не загружено, попробуйте еще раз!', 'code' => '004'));
                        }
                    } else {
                        echo json_encode(array('status' => 'fail', 'message' => 'Изображение не загружено, попробуйте еще раз!', 'code' => '003'));
                    }
                } else {
                    echo json_encode(array('status' => 'fail', 'message' => 'Изображение не загружено, попробуйте еще раз!', 'code' => '002'));
                }
            } else {
                echo json_encode(array('status' => 'fail', 'message' => 'Изображение не загружено, у вас нет прав!', 'code' => '999'));
            }
        } else {
            echo json_encode(array('status' => 'fail', 'message' => 'Изображение не загружено, попробуйте еще раз!', 'code' => '001'));
        }
    }
}