/********** #start comment **********/
const _comment = {
    _block: {},
    add: function () {
        const self = this;
        const request = new _glob.request();
        $('body').on('click', '.js-comment-button', function (evt) {
            evt.preventDefault();
            const button = $(this);
            const form = button.closest('form');
            const id = form.find('[name="comment_id"]').val();
            request.setObject(form).send((response) => {
                if (response.status && response.message) {
                    if (id && request.view) {
                        const selector = '#comment-' + id;
                        $(selector).append(request.view);
                    } else if (request.view) {
                        $('.comment-block-widget').append(request.view);
                    }
                    _glob.noty.success(response.message);
                    form.find('[name="comment_id"]').val('');
                    form.find('.js-answer-name').slideUp();
                }
            });
        });
    },
    answer: function () {
        const self = this;
        $('.a-shop').on('click', '[data-review-id]', function (evt) {
            evt.preventDefault();
            const id = $(this).attr('data-review-id');
            const selector = '#review-name-' + id;
            const nameTemp = $(this).closest('.comment').find(selector).text();
            const name = nameTemp ? nameTemp : 'Undefined';
            const form = $('#contact-form-leave-comments');
            form.find('[name="comment_id"]').val(id);
            form.find('[name="comment_name"]').val(name);
            form.find('.js-answer-name').slideDown();
            $('html, body').animate({
                scrollTop: form.offset().top
            });
        });
    },
    deleteAnswer: function () {
        const self = this;
        $('.a-shop').on('click', '.js-answer-delete', function (evt) {
            evt.preventDefault();
            const form = $('#contact-form-leave-comments');
            form.find('[name="comment_id"]').val('');
            form.find('[name="comment_name"]').val('');
            form.find('.js-answer-name').slideUp();
        });
    },
    open: function () {
        const self = this;
        const request = new _glob.request();
        $('.a-shop').on('click', '[data-open-id]', function (evt) {
            evt.preventDefault();
            const button = $(this);
            const id = button.attr('data-open-id');
            const data = {
                'id': id,
                'action': '/ajax/open-comment',
            };
            request.setObject(data).send((response) => {
                if (response.status) {
                    if (request.view) {
                        const selector = '#comment-' + id;
                        $(selector).append(request.view);
                        button.remove();
                    }
                    _glob.noty.success(response.message);
                }
            });
        });
    },
    run: function () {
        this.add();
        this.answer();
        this.deleteAnswer();
        this.open();
    }
}
const _index = {
    _block: {},
    click: function () {
        const _this = this;
        const request = new _glob.request();
        $('.a-shop').on('click', '[data-js-filter]', function (evt) {
            evt.preventDefault();
            const id = $(this).attr('data-js-filter');
            request.setObject({id, action: '/ajax/category'}).send((response) => {
                if (response.status) {
                    _cl_(response)
                    $('.js-filter').html(request.view);
                    $(this).find('sup').text('[' + request.data.count + ']');
                    _glob.noty.success(response.message);
                }
            })
        });
    },

    run: function () {
        this.click();

    }
}
/********** #start load **********/
$(document).ready(function () {
    _glob.run();
    _comment.run();
    _index.run();
})
