/*
 * Copyright (c) 2022 Marketify
 * Author: Marketify
 * This file is made for CURRENT TEMPLATE
*/

jQuery(document).ready(function () {

    "use strict";

    // here all ready functions

    tokyo_tm_modalbox();
    // tokyo_tm_page_transition();
    tokyo_tm_trigger_menu();
    tokyo_tm_service_popup();
    tokyo_tm_modalbox_news();
    tokyo_tm_modalbox_portfolio();
    tokyo_tm_my_progress();
    tokyo_tm_projects();
    tokyo_tm_portfolio();
    tokyo_tm_cursor();
    tokyo_tm_imgtosvg();
    tokyo_tm_popup();
    tokyo_tm_data_images();
    tokyo_tm_contact_form();
    tokyo_tm_my_load();
});
// -----------------------------------------------------
// ---------------   FUNCTIONS    ----------------------
// -----------------------------------------------------

// -----------------------------------------------------
// --------------------   MODALBOX    ------------------
// -----------------------------------------------------

function tokyo_tm_modalbox() {
    "use strict";

    jQuery('.tokyo_tm_all_wrap').prepend('<div class="tokyo_tm_modalbox"><div class="box_inner"><div class="close"><a href="#"><i class="icon-cancel"></i></a></div><div class="description_wrap"></div></div></div>');
}

// -----------------------------------------------------
// -------------   PAGE TRANSITION    ------------------
// -----------------------------------------------------

function tokyo_tm_page_transition() {

    "use strict";

    let section = jQuery('.tokyo_tm_section');
    let allLi = jQuery('.transition_link li');
    let button = jQuery('.transition_link a');
    let wrapper = jQuery('.tokyo_tm_all_wrap');
    let enter = wrapper.data('enter');
    let exit = wrapper.data('exit');

    button.on('click', function () {
        let element = jQuery(this);
        let href = element.attr('href');
        let sectionID = jQuery(href);
        let parent = element.closest('li');
        if (!parent.hasClass('active')) {
            allLi.removeClass('active');
            wrapper.find(section).removeClass('animated ' + enter);
            if (wrapper.hasClass('opened')) {
                wrapper.find(section).addClass('animated ' + exit);
            }
            parent.addClass('active');
            wrapper.addClass('opened');
            wrapper.find(sectionID).removeClass('animated ' + exit).addClass('animated ' + enter);
            jQuery(section).addClass('hidden');
            jQuery(sectionID).removeClass('hidden').addClass('active');
        }
        return false;
    });
}

// -----------------------------------------------------
// ---------------   TRIGGER MENU    -------------------
// -----------------------------------------------------

function tokyo_tm_trigger_menu() {

    "use strict";

    let hamburger = jQuery('.tokyo_tm_topbar .trigger .hamburger');
    let mobileMenu = jQuery('.tokyo_tm_mobile_menu');
    let mobileMenuList = jQuery('.tokyo_tm_mobile_menu ul li a');

    hamburger.on('click', function () {
        let element = jQuery(this);

        if (element.hasClass('is-active')) {
            element.removeClass('is-active');
            mobileMenu.removeClass('opened');
        } else {
            element.addClass('is-active');
            mobileMenu.addClass('opened');
        }
        return false;
    });

    mobileMenuList.on('click', function () {
        jQuery('.tokyo_tm_topbar .trigger .hamburger').removeClass('is-active');
        mobileMenu.removeClass('opened');
    });
}

// -------------------------------------------------
// -------------  SERVICE POPUP  -------------------
// -------------------------------------------------

function tokyo_tm_service_popup() {

    "use strict";

    let modalBox = jQuery('.tokyo_tm_modalbox');
    let closePopup = modalBox.find('.close');

    $('.tokyo_tm_all_wrap').on('click', '.tokyo_tm_services .tokyo_tm_full_link', function () {
        let element = jQuery(this);
        let parent = element.closest('.tokyo_tm_services .list ul li');
        let elImage = parent.find('.popup_service_image').attr('src');
        let title = parent.find('.title').text();
        let content = parent.find('.service_hidden_details').html();
        modalBox.addClass('opened');
        modalBox.find('.description_wrap').html(content);
        modalBox.find('.service_popup_informations').prepend('<div class="image"><img src="img/thumbs/4-2.jpg" alt="" /><div class="main" data-img-url="' + elImage + '"></div></div>');
        tokyo_tm_data_images();
        modalBox.find('.service_popup_informations .image').after('<div class="main_title"><h3>' + title + '</h3></div>');
        return false;
    });
    closePopup.on('click', function () {
        modalBox.removeClass('opened');
        modalBox.find('.description_wrap').html('');
        return false;
    });
}

// -------------------------------------------------
// -------------  MODALBOX NEWS  -------------------
// -------------------------------------------------

function tokyo_tm_modalbox_news() {

    "use strict";

    let modalBox = jQuery('.tokyo_tm_modalbox');
    let list = jQuery('.tokyo_tm_news ul li');
    let closePopup = modalBox.find('.close');

    list.each(function () {
        let element = jQuery(this);
        let details = element.find('.list_inner').html();
        let buttons = element.find('.details .title a,.tokyo_tm_full_link,.tokyo_tm_read_more a');
        let mainImage = element.find('.main');
        let imgData = mainImage.data('img-url');
        let title = element.find('.title');
        let titleHref = element.find('.title a').html();
        buttons.on('click', function () {
            jQuery('body').addClass('modal');
            modalBox.addClass('opened');
            modalBox.find('.description_wrap').html(details);
            mainImage = modalBox.find('.main');
            mainImage.css({backgroundImage: 'url(' + imgData + ')'});
            title = modalBox.find('.title');
            title.html(titleHref);
            tokyo_tm_imgtosvg();
            return false;
        });
    });
    closePopup.on('click', function () {
        modalBox.removeClass('opened');
        modalBox.find('.description_wrap').html('');
        jQuery('body').removeClass('modal');
        return false;
    });
}

// -------------------------------------------------
// -------------  MODALBOX PORTFOLIO  --------------
// -------------------------------------------------

function tokyo_tm_modalbox_portfolio() {

    "use strict";

    let modalBox = jQuery('.tokyo_tm_modalbox');
    let button = jQuery('.tokyo_tm_portfolio .popup_info');

    button.on('click', function () {
        let element = jQuery(this);
        let parent = element.closest('li');
        let image = parent.find('.abs_image').data('img-url');
        let details = parent.find('.details_all_wrap').html();
        let title = parent.find('.entry').data('title');
        let category = parent.find('.entry').data('category');
        console.log(image);

        modalBox.addClass('opened');
        modalBox.find('.description_wrap').html(details);
        modalBox.find('.popup_details').prepend('<div class="top_image"><img src="img/thumbs/4-2.jpg" alt="" /><div class="main" data-img-url="' + image + '"></div></div>');
        modalBox.find('.popup_details .top_image').after('<div class="portfolio_main_title"><h3>' + title + '</h3><span>' + category + '</span><div>');
        tokyo_tm_data_images();
        return false;
    });
}

// -------------------------------------------------
// -----------------    PORTFOLIO    ---------------
// -------------------------------------------------

function tokyo_tm_projects() {

    "use strict";

    jQuery('.tokyo_tm_portfolio_animation_wrap').each(function () {
        jQuery(this).on('mouseenter', function () {
            if (jQuery(this).data('title')) {
                jQuery('.tokyo_tm_portfolio_titles').html(jQuery(this).data('title') + '<span class="work__cat">' + jQuery(this).data('category') + '</span>');
                jQuery('.tokyo_tm_portfolio_titles').addClass('visible');
            }

            jQuery(document).on('mousemove', function (e) {
                jQuery('.tokyo_tm_portfolio_titles').css({
                    left: e.clientX - 10,
                    top: e.clientY + 25
                });
            });
        }).on('mouseleave', function () {
            jQuery('.tokyo_tm_portfolio_titles').removeClass('visible');
        });
    });
}

// filterable

function tokyo_tm_portfolio() {

    "use strict";

    if (jQuery().isotope) {

        // Needed variables
        let list = jQuery('.tokyo_tm_portfolio .portfolio_list');
        let filter = jQuery('.tokyo_tm_portfolio .portfolio_filter ul');

        if (filter.length) {
            // Isotope Filter
            filter.find('a').on('click', function () {
                let selector = jQuery(this).attr('data-filter');
                list.isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    }
                });
                return false;
            });

            // Change active element class
            filter.find('a').on('click', function () {
                filter.find('a').removeClass('current');
                jQuery(this).addClass('current');
                return false;
            });
        }
    }
}

// -------------------------------------------------
// -------------  PROGRESS BAR  --------------------
// -------------------------------------------------

function tokyo_tm_my_progress() {
    "use strict";

    let list = jQuery('.tokyo_progress .progress_inner');
    list.each(function () {
        let element = jQuery(this);
        let bar = element.find('.bar_in');
        let number = element.data('value');
        bar.css({width: number + '%'});
    });

}

// -----------------------------------------------------
// ---------------   PRELOADER   -----------------------
// -----------------------------------------------------

function tokyo_tm_preloader() {

    "use strict";

    let isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ? true : false;
    let preloader = $('#preloader');

    if (!isMobile) {
        setTimeout(function () {
            preloader.addClass('preloaded');
        }, 800);
        setTimeout(function () {
            preloader.remove();
        }, 2000);

    } else {
        preloader.remove();
    }
}

// -----------------------------------------------------
// -----------------   MY LOAD    ----------------------
// -----------------------------------------------------

function tokyo_tm_my_load() {

    "use strict";

    let speed = 500;
    setTimeout(function () {
        tokyo_tm_preloader();
    }, speed);
}

// -----------------------------------------------------
// ------------------   CURSOR    ----------------------
// -----------------------------------------------------

function tokyo_tm_cursor() {
    "use strict";

    let myCursor = jQuery('.mouse-cursor');

    if (myCursor.length) {
        if ($("body")) {
            const e = document.querySelector(".cursor-inner"),
                t = document.querySelector(".cursor-outer");
            let n, i = 0,
                o = !1;
            window.onmousemove = function (s) {
                o || (t.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)"), e.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)", n = s.clientY, i = s.clientX
            }, $("body").on("mouseenter", "a, .cursor-pointer", function () {
                e.classList.add("cursor-hover"), t.classList.add("cursor-hover")
            }), $("body").on("mouseleave", "a, .cursor-pointer", function () {
                $(this).is("a") && $(this).closest(".cursor-pointer").length || (e.classList.remove("cursor-hover"), t.classList.remove("cursor-hover"))
            }), e.style.visibility = "visible", t.style.visibility = "visible"
        }
    }
};

// -----------------------------------------------------
// ---------------    IMAGE TO SVG    ------------------
// -----------------------------------------------------

function tokyo_tm_imgtosvg() {

    "use strict";

    jQuery('img.svg').each(function () {

        let jQueryimg = jQuery(this);
        let imgClass = jQueryimg.attr('class');
        let imgURL = jQueryimg.attr('src');

        jQuery.get(imgURL, function (data) {
            // Get the SVG tag, ignore the rest
            let jQuerysvg = jQuery(data).find('svg');

            // Add replaced image's classes to the new SVG
            if (typeof imgClass !== 'undefined') {
                jQuerysvg = jQuerysvg.attr('class', imgClass + ' replaced-svg');
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            jQuerysvg = jQuerysvg.removeAttr('xmlns:a');

            // Replace image with new SVG
            jQueryimg.replaceWith(jQuerysvg);

        }, 'xml');

    });
}

// -----------------------------------------------------
// --------------------   POPUP    ---------------------
// -----------------------------------------------------

function tokyo_tm_popup() {

    "use strict";

    jQuery('.gallery_zoom').each(function () { // the containers for all your galleries
        jQuery(this).magnificPopup({
            delegate: 'a.zoom', // the selector for gallery item
            type: 'image',
            gallery: {
                enabled: true
            },
            removalDelay: 300,
            mainClass: 'mfp-fade'
        });

    });
    jQuery('.popup-youtube, .popup-vimeo').each(function () { // the containers for all your galleries
        jQuery(this).magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
    });

    jQuery('.soundcloude_link').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true,
        },
    });
}

// -----------------------------------------------------
// ---------------   DATA IMAGES    --------------------
// -----------------------------------------------------

function tokyo_tm_data_images() {

    "use strict";

    let data = jQuery('*[data-img-url]');

    data.each(function () {
        let element = jQuery(this);
        let url = element.data('img-url');
        element.css({backgroundImage: 'url(' + url + ')'});
    });
}

// -----------------------------------------------------
// ----------------    CONTACT FORM    -----------------
// -----------------------------------------------------

function tokyo_tm_contact_form() {

    "use strict";

    jQuery(".contact_form #send_message").on('click', function () {

        let name = jQuery(".contact_form #name").val();
        let email = jQuery(".contact_form #email").val();
        let message = jQuery(".contact_form #message").val();
        let subject = jQuery(".contact_form #subject").val();
        let success = jQuery(".contact_form .returnmessage").data('success');

        jQuery(".contact_form .returnmessage").empty(); //To empty previous error/success message.
        //checking for blank fields
        if (name === '' || email === '' || message === '') {

            jQuery('div.empty_notice').slideDown(500).delay(2000).slideUp(500);
        } else {
            // Returns successful data submission message when the entered information is stored in database.
            jQuery.post("modal/contact.php", {
                ajax_name: name,
                ajax_email: email,
                ajax_message: message,
                ajax_subject: subject
            }, function (data) {

                jQuery(".contact_form .returnmessage").append(data);//Append returned message to message paragraph


                if (jQuery(".contact_form .returnmessage span.contact_error").length) {
                    jQuery(".contact_form .returnmessage").slideDown(500).delay(2000).slideUp(500);
                } else {
                    jQuery(".contact_form .returnmessage").append("<span class='contact_success'>" + success + "</span>");
                    jQuery(".contact_form .returnmessage").slideDown(500).delay(4000).slideUp(500);
                }

                if (data === "") {
                    jQuery("#contact_form")[0].reset();//To reset form fields on success
                }

            });
        }
        return false;
    });
}

// -----------------------------------------------------
// ----------------    OWL CAROUSEL    -----------------
// -----------------------------------------------------

function tokyo_tm_owl_carousel() {

    "use strict";

    let carousel = jQuery('.tokyo_tm_testimonials .owl-carousel');

    carousel.owlCarousel({
        loop: true,
        items: 2,
        lazyLoad: false,
        margin: 30,
        autoplay: true,
        autoplayTimeout: 7000,
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
}
