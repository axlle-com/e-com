imageArray = {};
sparePartArray = [];
const ERROR_MESSAGE = 'Произошла ошибка, попробуйте позднее!'
const uuid = function () {
    return Date.now().toString(36) + Math.random().toString(36).substr(2);
}
const notyError = function (message = 'Произошла ошибка!') {
    new Noty({
        type: 'error', text: '<h5>Внимание</h5>' + message, timeout: 4000
    }).show()
}
const notySuccess = function (message = 'Все прошло успешно!') {
    new Noty({
        type: 'success', text: '<h5>Внимание</h5>' + message, timeout: 4000
    }).show()
}
const notyInfo = function (message = 'Обратите внимание!') {
    new Noty({
        type: 'info', text: '<h5>Внимание</h5>' + message, timeout: 4000
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
    let quantity = 0;
    if (Object.keys(data).length) {
        quantity = data.quantity;
        let sum = data.sum ? data.sum : 0.0;
        let items = data.items;
        if (Object.keys(items).length) {
            mini += `<div class="toolbar-dropdown cart-dropdown js-widget-cart">`;
            for (let key in items) {
                mini += `<div class="entry">
                            <div class="entry-thumb">
                                <a href="/catalog/${items[key]['alias']}">
                                    <img src="${items[key]['image']}" alt="${items[key]['title']}">
                                </a>
                            </div>
                            <div class="entry-content">
                                <h4 class="entry-title">
                                    <a href="/catalog/${items[key]['alias']}">${items[key]['title']}</a>
                                </h4>
                                <span class="entry-meta">1 x ${items[key]['price']}</span>
                            </div>
                            <div class="entry-delete" data-js-catalog-product-id-in-basket="${key}"><i class="icon-x"></i></div>
                        </div>`;
            }
            mini += `<div class="text-right">
                        <p class="text-gray-dark py-2 mb-0"><span class="text-muted">Итого:</span> &nbsp;${sum}</p>
                    </div>`;
            mini += `<div class="d-flex">
                        <div class="pr-2 w-50"><a class="btn btn-outline-secondary btn-sm btn-block mb-0" href="">Очистить</a></div>
                        <div class="pl-2 w-50"><a class="btn btn-outline-primary btn-sm btn-block mb-0" href="/catalog/basket">Оформить</a></div>
                    </div>`;
            mini += `</div>`;
        }
    }
    if (mini) {
        $('.js-block-mini-basket').find('.js-widget-cart').remove();
        $('.js-block-mini-basket').append(mini);
        $('[data-cart-count-bubble]').html(`<span data-cart-count="">${quantity}</span>`).show();
    } else {
        $('.js-block-mini-basket').find('.js-widget-cart').remove();
        $('[data-cart-count-bubble]').html('').hide();
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
