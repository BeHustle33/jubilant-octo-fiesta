<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="csrf">
    <title>Загрузка картинки</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>

</head>
<body>
<div class="wrapper">
<h1>Загрузка картинки</h1>
<p class="error"></p>
<p class="success"></p>
<a class="img-link" target="_blank"></a><br>
<br>
<form enctype="multipart/form-data" name="submit_img" method="post" action="#" class="custom-form" id="ajax_form">
<input type="file" name="img" required>
    <p><label for="text">Введите свой текст</label></p>
    <p><input type="text" name="text" id="text"></p>
    <p><label for="font">Выберите шрифт</label> </p>
    <p><select type="select" name="font" id="font">
            <option name="Arial">Arial</option>
            <option name="Times New Roman">Times New Roman</option>
            <option name="Verdana">Verdana</option>
            <option name="Tahoma">Tahoma</option>
    </select></p>
    <p><label for="size">Выберите размер шрифта</label> </p>
    <p><select type="select" name="size" id="size">
            @for ($i = 12; $i <= 72; $i += 2)
                <option name="{{ $i }} ?>">{{ $i }}</option>
            @endfor
        </select></p>
    <p><label for="color">Выберите цвет шрифта</label> </p>
    <p><select type="select" name="color" id="color">
            <option name="Red" value="Red">Красный</option>
            <option name="Green" value="Green">Зеленый</option>
            <option name="Blue" value="Blue">Синий</option>
            <option name="Black" value="Black">Черный</option>
            <option name="White" value="White">Белый</option>
        </select></p>
<button class="button" type="submit">Отправить картинку</button>
</form>
    <article>
        <div id="share" hidden>
            <div class="like">Понравилось? Поделитесь с друзьями!</div>
            <div class="social" data-url="http://google.com" data-title="Картинка со своим текстом">
                <a class="push facebook" data-id="fb"><i class="fa fa-facebook"></i> Facebook</a>
                <a class="push twitter" data-id="tw"><i class="fa fa-twitter"></i> Twitter</a>
                <a class="push vkontakte" data-id="vk"><i class="fa fa-vk"></i> Вконтакте</a>
                <a class="push odnoklassniki" data-id="ok"><i class="fa fa-odnoklassniki"></i> Одноклассники</a>
            </div>
        </div>
    </article>
</div>
</body>
</html>