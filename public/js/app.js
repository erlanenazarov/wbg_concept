/**
 * Created by Erlan on 21.04.2017.
 */


var trigger = $('.pop-up-trigger');
var registerModal = $('#registration-modal');
var thanksModal = $('#thanks-modal');
$(document).ready(function () {
    $(trigger).each(function (i, obj) {
        $(obj).on('click', function (event) {
            event.preventDefault();
            openModal(registerModal, $(obj).attr('data-target'));
        })
    });

    $('.md-close').each(function (i, obj) {
        $(obj).on('click', function (event) {
            event.preventDefault();
            closeModal($(obj).parent().parent().parent());
        });
    });

    $('.overlay').each(function (i, obj) {
        $(obj).on('click', function (event) {
            event.preventDefault();
            closeModal(obj);
        });
    });

    $('#submit').on('click', function (event) {
        event.preventDefault();
        if (isValid()) {
            sendForm($(registerModal).find('.modal-carcass'));
        }
    });
});

function closeModal(modal) {
    var carcass = $(modal).find('.modal-carcass');
    $(carcass).animate({
        top: '-1000px'
    }, 500);
    $(modal).fadeOut('slow', function () {
        $(carcass).removeAttr('style');
    });
    $('body').removeClass('no-scroll');
}

function setRussianModal() {
    $('.md-close').each(function (i, obj) {
        $(obj).html('Закрыть');
    });

    $('#register-header').html('Регистрация');
    $('label[for="name"]').html('Имя:');
    $('label[for="email"]').html('Эл. почта');
    $('label[for="org"]').html('Организация');
    $('label[for="title"]').html('Название');
    $('label[for="phone-number"]').html('Номер телефона');
    $('label[for="country"]').html('Страна');
    $('label[for="preference"]').html('Диетические предпочтения');
    $('label[for="request"]').html('Специальные запросы');
    $('#submit').html('Отправить');
    $('#thanks-header').html('Спасибо!');
    $('#thanks-text').html('Форма отправлена<br>наши менеджеры свяжутся с вами!<br>проверьте свою почту для наличии копии ваших данных!');
    $('#fail-header').html('Просим прощения :(');
    $('#fail-text').html('На сервере произошла ошибка, попробуйте позже..');

    $('input[id="name"]').attr('placeholder', 'Имя...');
    $('input[id="email"]').attr('placeholder', 'Эл. Почта...');
    $('input[id="org"]').attr('placeholder', 'Организация...');
    $('input[id="title"]').attr('placeholder', 'Название...');
    $('input[id="phone-number"]').attr('placeholder', 'Номер телефона...');
    $('input[id="country"]').attr('placeholder', 'Страна...');
    $('input[id="preference"]').attr('placeholder', 'Диетические предпочтения...');
    $('textarea[id="request"]').attr('placeholder', 'Специальные запросы...');
}

function setEnglishModal() {
    $('.md-close').each(function (i, obj) {
        $(obj).html('Close');
    });

    $('#register-header').html('Registration form');
    $('label[for="name"]').html('Name:');
    $('label[for="email"]').html('Email Address:');
    $('label[for="org"]').html('Organization:');
    $('label[for="title"]').html('Title:');
    $('label[for="phone-number"]').html('Phone number:');
    $('label[for="country"]').html('Country:');
    $('label[for="preference"]').html('Dietary preference:');
    $('label[for="request"]').html('Special requests:');
    $('#submit').html('submit');
    $('#thanks-header').html('Thank you!');
    $('#thanks-text').html('FORM IS SENDED<br>OUR MANAGERS WILL CONTACT WITH YOU!<br>CHECK YOUR EMAIL FOR COPY OF SENT FORM!');
    $('#fail-header').html('Sorry :(');
    $('#fail-text').html('SERVER CATCH AN ERROR, TRY LATER..');

    $('input[id="name"]').attr('placeholder', 'Name...');
    $('input[id="email"]').attr('placeholder', 'E-Mail...');
    $('input[id="org"]').attr('placeholder', 'Organization...');
    $('input[id="title"]').attr('placeholder', 'Title...');
    $('input[id="phone-number"]').attr('placeholder', 'Phone Number...');
    $('input[id="country"]').attr('placeholder', 'Country...');
    $('input[id="preference"]').attr('placeholder', 'Dietary preference...');
    $('textarea[id="request"]').attr('placeholder', 'Special requests...');
}

function openModal(modal, lg) {
    if (lg != null) {
        switch (lg) {
            case 'ru':
                setRussianModal();
                break;
            case 'en':
                setEnglishModal();
                break;
        }
    }
    $(modal).fadeIn('fast');
    $(modal).find('.modal-carcass, .child, .modal-header, .modal-content').on('click', function (event) {
        event.stopPropagation();
    });
    $('body').addClass('no-scroll');
}

function sendForm(modal) {
    var form = $('#registration-form');
    $(modal).animate({
        top: '-1000px'
    }, 500, function () {
        $(modal).parent().append('<img src="public/images/ajax-loader.gif" id="loading" />');
    });
    setTimeout(function () {
        $.ajax({
            url: $(form).attr('action'),
            method: 'POST',
            dataType: 'JSON',
            data: $(form).serialize(),
            success: function (response) {
                if(response.success) {
                    $('#loading').remove();
                    closeModal(registerModal);
                    $(modal).removeAttr('style');
                    openModal(thanksModal);
                } else {
                    $('#loading').remove();
                    closeModal(registerModal);
                    $(modal).removeAttr('style');
                    openModal($('#fail-modal'));
                }
            },
            error: function () {
                $('#loading').remove();
                closeModal(registerModal);
                $(modal).removeAttr('style');
                openModal($('#fail-modal'));
            }
        });
    }, 1000);
}

function isValid() {
    var name = $('#name');
    var email = $('#email');
    var org = $('#org');
    var title = $('#title');
    var phoneNumber = $('#phone-number');
    var country = $('#country');
    var preference = $('#preference');
    var nullCount = 0;
    if ($(name).val() == '') {
        $(name).css('border-color', '#E11366');
        ++nullCount;
    }
    if ($(email).val() == '' || !$(email).val().includes('@')) {
        $(email).css('border-color', '#E11366');
        ++nullCount;
    }
    if ($(org).val() == '') {
        $(org).css('border-color', '#E11366');
        ++nullCount;
    }
    if ($(title).val() == '') {
        $(title).css('border-color', '#E11366');
        ++nullCount;
    }
    if ($(phoneNumber).val() == '') {
        $(phoneNumber).css('border-color', '#E11366');
        ++nullCount;
    }
    if ($(country).val() == '') {
        $(country).css('border-color', '#E11366');
        ++nullCount;
    }
    if ($(preference).val() == '') {
        $(preference).css('border-color', '#E11366');
        ++nullCount;
    }
    return nullCount == 0;
}