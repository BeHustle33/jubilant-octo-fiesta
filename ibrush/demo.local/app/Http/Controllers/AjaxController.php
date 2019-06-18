<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Image;
use Mockery\Exception;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function query(Request $request)
    {
        $img = $request->file('img');
        $text = $request->input('text');
        $font = $request->input('font');
        $size = $request->input('size');
        $color = $request->input('color');
        $max_file_size = 500000;
        try {
            if (!$img) {
                throw new \Exception('Необходимо загрузить изображение');
            }
            if (!in_array($img->getClientMimeType(), ['image/jpeg', 'image/png'])) {
                throw new \Exception('Файл: ' . $_FILES['img']['name'] . ' не является изображением, либо имеет неверный формат
        Допускаются только jpeg и png файлы');
            }
            if ($img->getSize() > $max_file_size) {
                throw new \Exception('Файл больше 500 кб и не может быть загружен.'); //
            }
            list($width, $height, $type, $attr) = getimagesize($img);
            if ($width > 800 || $height > 800) {
                throw new \Exception('Допускаются только файлы размером 800х800 px');
            }
            if (empty($text)) {
                throw new \Exception('Вы не ввели свой текст');
            }
            if (!in_array($font, ['Arial', 'Times New Roman', 'Verdana', 'Tahoma'])) {
                throw new \Exception('Указан неподдерживаемый шрифт');
            }
            if ($size < 12 || $size > 72) {
                throw new \Exception('Недопустимый размер шрифта');
            }
            if (!in_array($color, ['Red', 'Green', 'Blue', 'Black', 'White'])) {
                throw new \Exception('Неверно указан цвет шрифта');
            }

            switch ($img->getClientMimeType()) {
                case ('image/jpeg') :
                    $image = imagecreatefromjpeg($_FILES['img']['tmp_name']);
                    break;
                case ('image/png') :
                    $image = imagecreatefrompng($_FILES['img']['tmp_name']);
                    break;
            }

            switch ($color) {
                case ('Red') :
                    $color = imagecolorallocate($image, 255, 0, 0);
                    break;
                case ('Green') :
                    $color = imagecolorallocate($image, 0, 255, 0);
                    break;
                case ('Blue') :
                    $color = imagecolorallocate($image, 0, 0, 255);
                    break;
                case ('White') :
                    $color = imagecolorallocate($image, 255, 255, 255);
                    break;
                case ('Black') :
                    $color = imagecolorallocate($image, 0, 0, 0);
                    break;
            }
            $font_file = $_SERVER['DOCUMENT_ROOT'] . '/fonts/' . $font . '.ttf';
            imagefttext($image, $size, 0, 100, $height / 2, $color, $font_file, $text);
            DB::beginTransaction();
            $id = Image::insertGetId([]);
            if (!imagejpeg($image, $_SERVER['DOCUMENT_ROOT'] . "/img/img$id.jpg")) {
                throw new Exception('Не удалось сохранить изображение');
            }
            DB::commit();
            $result = ['result' => 'success', 'content' => "/img/$id"];
        } catch (\Exception $e) {
            DB::rollBack();
            $result = ['result' => 'error', 'content' => $e->getMessage()];
        }
        echo json_encode($result);
    }
}
