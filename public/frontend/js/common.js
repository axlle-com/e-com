imageArray = {};
sparePartArray = [];
const ERROR_MESSAGE = 'Произошла ошибка, попробуйте позднее!'
const uuid = function () {
    return Date.now().toString(36) + Math.random().toString(36).substr(2);
}
const notyError = function (message = 'Произошла ошибка!') {
    new Noty({
        type: 'error',
        text: '<h5>Внимание</h5>' + message,
        timeout: 4000
    }).show()
}
const notySuccess = function (message = 'Все прошло успешно!') {
    new Noty({
        type: 'success',
        text: '<h5>Внимание</h5>' + message,
        timeout: 4000
    }).show()
}
const notyInfo = function (message = 'Обратите внимание!') {
    new Noty({
        type: 'info',
        text: '<h5>Внимание</h5>' + message,
        timeout: 4000
    }).show()
}
const setLocation = function (curLoc) {
    try {
        history.pushState(null, null, curLoc);
        return;
    } catch (e) {
    }
    location.hash = '#' + curLoc;
}
/********** #start basket **********/

const basketSendChange = (obj, url, callback) => {
    $.ajax({
        url: url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        dataType: 'json',
        data: obj,
        beforeSend: function () {
        },
        success: function (response) {
            callback(response);
        },
        error: function (response) {
            errorResponse(response);
        },
        complete: function () {
        }
    });
}
const basketDraw = (data) => {
    let mini = '';
    let maxi = '';
    if (Object.keys(data).length) {
        mini = '0';
        console.log(data)
    }
    if (mini) {
        $('.js-block-mini-basket').html(mini);
    } else {
        $('.js-block-mini-basket').html(mini).hide();
    }
    $('.js-block-maxi-basket').html(maxi);
}
const basketAdd = () => {
    $('.a-shop').on('click', '[data-js-catalog-product-id]', function (evt) {
        let url = '/catalog/ajax/basket-add';
        let id = $(this).attr('data-js-catalog-product-id');
        basketSendChange({'product_id': id}, url, (response) => {
            if (response.status) {
                notySuccess('Корзина сохранена');
                basketDraw(response.data);
            }
        })
    });
}
/********** #end basket **********/

$(document).ready(function () {
    basketAdd();
})
