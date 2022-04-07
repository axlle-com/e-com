/*-----------------------------------------------------------------------------------*/
/*	ISOTOPE
/*-----------------------------------------------------------------------------------*/
$( function() {
    // init Isotope
    var $container = $('.fix-portfolio .isotope');

    $container.isotope({
        itemSelector: '.item',
        transitionDuration: '0.6s',
        masonry: { columnWidth: $container.width() / 12 },
        layoutMode: 'masonry'
    });

    $(window).resize(function(){
        $container.isotope({
            masonry: { columnWidth: $container.width() / 12 }
        });
    });
    // bind filter button click
    $('.fix-portfolio #filters').on( 'click', 'button', function() {
        var filterValue = $( this ).attr('data-filter');
        $container.isotope({ filter: filterValue });
    });
    // change is-checked class on buttons
    $('.fix-portfolio .button-group').each( function( i, buttonGroup ) {
        var $buttonGroup = $( buttonGroup );
        $buttonGroup.on( 'click', 'button', function() {
            $buttonGroup.find('.is-checked').removeClass('is-checked');
            $( this ).addClass('is-checked');
        });
    });
    // layout Isotope again after all images have loaded
    $container.imagesLoaded( function() {
        $container.isotope('layout');
    });
});


$( function() {
    // init Isotope
    var $container = $('.full-portfolio .isotope').isotope({
        itemSelector: '.item',
        transitionDuration: '0.6s',
        masonry: {
            columnWidth: '.grid-sizer'
        }
    });
    // bind filter button click
    $('.full-portfolio #filters').on( 'click', 'button', function() {
        var filterValue = $( this ).attr('data-filter');
        $container.isotope({ filter: filterValue });
    });
    // change is-checked class on buttons
    $('.full-portfolio .button-group').each( function( i, buttonGroup ) {
        var $buttonGroup = $( buttonGroup );
        $buttonGroup.on( 'click', 'button', function() {
            $buttonGroup.find('.is-checked').removeClass('is-checked');
            $( this ).addClass('is-checked');
        });
    });
    // layout Isotope again after all images have loaded
    $container.imagesLoaded( function() {
        $container.isotope('layout');
    });
});

$( function() {
    // init Isotope
    var $container = $('.classic-masonry .isotope');

    $container.isotope({
        itemSelector: '.item',
        transitionDuration: '0.6s',
        masonry: { columnWidth: $container.width() / 12 },
        layoutMode: 'masonry'
    });

    $(window).resize(function(){
        $container.isotope({
            masonry: { columnWidth: $container.width() / 12 }
        });
    });
    // bind filter button click
    $('.classic-masonry #filters').on( 'click', 'button', function() {
        var filterValue = $( this ).attr('data-filter');
        $container.isotope({ filter: filterValue });
    });
    // change is-checked class on buttons
    $('.classic-masonry .button-group').each( function( i, buttonGroup ) {
        var $buttonGroup = $( buttonGroup );
        $buttonGroup.on( 'click', 'button', function() {
            $buttonGroup.find('.is-checked').removeClass('is-checked');
            $( this ).addClass('is-checked');
        });
    });
    // layout Isotope again after all images have loaded
    $container.imagesLoaded( function() {
        $container.isotope('layout');
    });
});