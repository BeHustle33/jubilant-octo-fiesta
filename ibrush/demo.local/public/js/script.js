$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: '/ajax_form',
    type: 'POST',
    dataType: 'json',
    beforeSend: function(){
        console.debug('Запрос отправлен. Ждите ответа.');
    },
    error: function(req, text, error){
        console.error('Упс! Ошибочка: ' + text + ' | ' + error);
    },
    complete: function(){
        console.debug('Запрос полностью завершен!');
    }
});

$(function(){
    $('#ajax_form').on('submit', function(e){
        e.preventDefault();
        var $that = $(this),
            formData = new FormData($that.get(0));
        $.ajax({
            contentType: false,
            processData: false,
            data: formData,
            success: function(message){
                console.log(message)
                if (message.result === 'error') {
                    document.querySelector('.error').innerHTML = message.content
                    document.querySelector('.success').innerHTML = ''
                    document.querySelector('.img-link').href = ''
                    document.querySelector('.img-link').innerHTML = ''
                    document.getElementById('share').setAttribute('hidden', 'hidden')
                } else if (message.result === 'success') {
                    document.querySelector('.error').innerHTML = ''
                    document.querySelector('.success').innerHTML = 'Изображение успешно загружено'
                    document.querySelector('.img-link').href = message.content
                    document.querySelector('.img-link').innerHTML = 'Открыть изображение'
                    document.getElementById('share').removeAttribute('hidden')
                    document.querySelector('.social').setAttribute('data-url', document.querySelector('.img-link').href)
                }
            }
        });
    });
});

var Shares = {
    title: 'Поделиться',
    width: 800,
    height: 800,

    init: function() {
        var share = document.querySelectorAll('.social');
        for(var i = 0, l = share.length; i < l; i++) {
            var url = share[i].getAttribute('data-url') || location.href, title = share[i].getAttribute('data-title') || '',
                desc = share[i].getAttribute('data-desc') || '', el = share[i].querySelectorAll('a');
            for(var a = 0, al = el.length; a < al; a++) {
                var id = el[a].getAttribute('data-id');
                if(id)
                    this.addEventListener(el[a], 'click', {id: id, url: url, title: title, desc: desc});
            }
        }
    },

    addEventListener: function(el, eventName, opt) {
        var _this = this, handler = function() {
            _this.share(opt.id, opt.url, opt.title, opt.desc);
        };
        if(el.addEventListener) {
            el.addEventListener(eventName, handler);
        } else {
            el.attachEvent('on' + eventName, function() {
                handler.call(el);
            });
        }
    },

    share: function(id, url, title, desc) {
        url = encodeURIComponent(url);
        desc = encodeURIComponent(desc);
        title = encodeURIComponent(title);
        switch(id) {
            case 'fb':
                this.popupCenter('https://www.facebook.com/sharer/sharer.php?u=' + url, this.title, this.width, this.height);
                break;
            case 'vk':
                this.popupCenter('https://vk.com/share.php?url=' + url + '&description=' + title + '. ' + desc, this.title, this.width, this.height);
                break;
            case 'tw':
                var text = title || desc || '';
                if(title.length > 0 && desc.length > 0)
                    text = title + ' - ' + desc;
                if(text.length > 0)
                    text = '&text=' + text;
                this.popupCenter('https://twitter.com/intent/tweet?url=' + url + text, this.title, this.width, this.height);
                break;
            case 'ok':
                this.popupCenter('https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl=' + url, this.title, this.width, this.height);
                break;
        }
    },

    newTab: function(url) {
        var win = window.open(url, '_blank');
        win.focus();
    },

    popupCenter: function(url, title, w, h) {
        var dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top;
        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 3) - (h / 3)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
        if (window.focus) {
            newWindow.focus();
        }
    }
};

jQuery(document).ready(function($) {
    $('.social a').on('click', function() {
        var id = $(this).data('id');
        if(id) {
            var data = $(this).parent('.social');
            var url = data.data('url') || location.href, title = data.data('title') || '', desc = data.data('desc') || '';
            Shares.share(id, url, title, desc);
        }
    });
});