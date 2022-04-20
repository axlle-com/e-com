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
                                <span class="entry-meta">1 x ${items[key]['price']} ₽</span>
                            </div>
                            <div class="entry-delete" data-js-catalog-product-id="${key}"><i class="icon-x"></i></div>
                        </div>`;
            }
            mini += `<div class="text-right">
                        <p class="text-gray-dark py-2 mb-0"><span class="text-muted">Итого:</span> &nbsp;${sum} ₽</p>
                    </div>`;
            mini += `<div class="d-flex">
                        <div class="pr-2 w-50"><a class="btn btn-outline-secondary btn-sm btn-block mb-0 js-basket-clear" href="javascript:void(0)">Очистить</a></div>
                        <div class="pl-2 w-50"><a class="btn btn-outline-primary btn-sm btn-block mb-0" href="/catalog/basket">Оформить</a></div>
                    </div>`;
            mini += `</div>`;
            $('.js-basket-max-sum').text(sum)
        }
    }
    if (mini) {
        let block = $('.js-block-mini-basket');
        block.find('.js-widget-cart').remove();
        block.append(mini);
        block.find('.header__cart-link').attr('href', '/catalog/basket');
        $('[data-cart-count-bubble]').html(`<span data-cart-count="">${quantity}</span>`).show();
    } else {
        basketClearBlock();
    }
}
const basketAdd = () => {
    $('.a-shop').on('click', '[data-js-catalog-product-id]', function (evt) {
        let button = $(this);
        let max = button.attr('data-js-basket-max');
        let id = button.attr('data-js-catalog-product-id');
        let url = '/catalog/ajax/basket-add';
        basketSendChange({'product_id': id}, url, (response) => {
            if (response.status) {
                notySuccess('Корзина сохранена');
                basketDraw(response.data);
                if (max) {
                    button.closest('tr').remove();
                }
            }
        })
    });
}

const basketClearBlock = () => {
    let block = $('.js-block-mini-basket');
    block.find('.js-widget-cart').remove();
    block.find('.header__cart-link').attr('href', 'javascript:void(0)');
    $('[data-cart-count-bubble]').html('').hide();
    let maxBlock = $('.js-basket-max-block');
    maxBlock.find('tbody').html('');
    maxBlock.find('.js-basket-max-sum').text('');
}

const basketClear = () => {
    $('.a-shop').on('click', '.js-basket-clear', function (evt) {
        let url = '/catalog/ajax/basket-clear';
        basketSendChange({}, url, (response) => {
            if (response.status) {
                notySuccess('Корзина очищена');
                basketClearBlock();
            }
        })
    });
}
/********** #end basket **********/

$(document).ready(function () {
    basketAdd();
    basketClear();
})
