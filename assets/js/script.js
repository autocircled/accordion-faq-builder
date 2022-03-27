var AFBFront = AFBFront || {};

AFBFront.accordion = {
    init: function(){
        this.create();
    },

    create: function(){
        const afb_box = document.querySelector(".a-faq-builder .afb-items");
        const afb_items = afb_box.querySelectorAll('li.afb-item');
        afb_items.forEach(( el, i) => {
            const afb_item_title = el.querySelector('a.afb-item-title');
            afb_item_title.addEventListener('click', function(event){
                event.preventDefault();
                if( ! AFB_DATA.multi_open ) {
                    for( const item of afb_items ){
                        if( el !== item && item.classList.contains( 'active' ) ) {
                            item.classList.remove( 'active' );
                        }
                    }
                }
                el.classList.toggle('active');
            });

        });

    }
};

/**
 * Is the DOM ready?
 *
 * This implementation is coming from https://gomakethings.com/a-native-javascript-equivalent-of-jquerys-ready-method/
 *
 * @since 0.1
 *
 * @param {Function} fn Callback function to run.
 */
 function AFBFrontDomReady( fn ) {
	if ( typeof fn !== 'function' ) {
		return;
	}

	if ( document.readyState === 'interactive' || document.readyState === 'complete' ) {
		return fn();
	}

	document.addEventListener( 'DOMContentLoaded', fn, false );
}


AFBFrontDomReady( function() {
	AFBFront.accordion.init();
} );