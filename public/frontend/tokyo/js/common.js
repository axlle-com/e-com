/********** #start menu **********/
const _menu = {
    _block: {},
    click: function () {
        const self = this;
        const request = new _glob.request();
        $('body').on('click', '.js-spa-link', function (event) {
            event.preventDefault();
            const li = $(this);
            let page = '';
            try {
                page = $(this).find('a').attr('href').replace(/\//, '');
            } catch (e) {
                _glob.console.error(e.message);
            }
            request.setObject({'action': '/ajax/tokyo/route', page}).send((response) => {
                if (response.status && request.view) {
                    const wrapper = jQuery('.tokyo_tm_all_wrap');
                    const enter = wrapper.data('enter');
                    const exit = wrapper.data('exit');
                    const block = $(request.view);
                    block.removeClass('active');
                    block.removeClass('animated ' + exit);
                    self._block.html(block);
                    block.addClass('active');
                    block.addClass('animated ' + exit);
                    $('.active.js-spa-link').removeClass('active');
                    li.addClass('active');
                    tokyo_tm_owl_carousel();
                }
            });
        });
    },
    run: function (block) {
        const self = this;
        self._block = $(block);
        if (self._block.length) {
            this.click();
        }
    }
}
/********** #start contact **********/
const _contact = {
    _block: {},
    form: function () {
        const self = this;
        const request = new _glob.request();
        $('body').on('click', '.form-send', function (event) {
            event.preventDefault();
            const button = $(this);
            const form = button.closest('form');
            request.setObject(form).send((response) => {
                if (response.status) {
                    _glob.noty.success('Ваше письмо отправлено');
                }
            });
        });
    },
    run: function () {
        this.form();
    }
}
/********** #start text **********/
const _text = {
    run: function () {
        $('.js-text').each(function (index, element) {
            if (element.clientHeight > 120) {
            }
        });
    }
}
/********** #start agree **********/
const _agree = {
    openAgreementModal: function () {
        $('body').on('click', '.js-custom-modal-open', function (e) {
            e.preventDefault();
            let selector = $(this).data('modalName');
            let modal = $(selector);
            modal.addClass('modal-agreement');
        });
    },
    closeAgreementModal: function () {
        $('body').on('click', '.js-custom-modal-close', function (e) {
            e.preventDefault();
            let modal = $(this).closest('.js-custom-modal');
            modal.removeClass('modal-agreement');
        });
    },
    run: function () {
        this.openAgreementModal();
        this.closeAgreementModal();
    }
}
/********** #start load **********/
$(document).ready(function () {
    _glob.run();
    _menu.run('.rightpart_in');
    _contact.run();
    _text.run();
    _agree.run();

    const carousel = jQuery('.tokyo_tm_testimonials .owl-carousel');
    carousel.owlCarousel({
        loop: true,
        items: 2,
        lazyLoad: false,
        margin: 30,
        autoplay: true,
        autoplayTimeout: 14000,
        dots: false,
        nav: false,
        navSpeed: false,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            }
        }
    });
})
