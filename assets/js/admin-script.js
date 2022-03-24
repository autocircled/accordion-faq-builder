(function(){

    const addNew = document.getElementById( 'add-new-item' );
    var counter = 0;
    counter = parseInt(document.getElementById("add-new-item").getAttribute('data-next'));

    addNew.addEventListener( 'click', function(e){
        e.preventDefault();
        
        const node = document.getElementById("clonable-item");
        const clone = node.cloneNode(true);
        clone.setAttribute('data-id', counter );
        clone.setAttribute('id', "item-" + counter );
        clone.setAttribute('class', "afb--item afb--item-" + counter );
        clone.getElementsByTagName('h3')[0].innerHTML = (counter + 1) + ". Item:";

        const new_id_for_title = 'afb_data[contents]['+ counter +'][title]';
        const title_label_selector = clone.querySelectorAll( '[data-target="title-label"]' );
        const title_input_selector = clone.querySelectorAll( '[data-target="title-input"]' );
        title_label_selector[0].setAttribute('for', new_id_for_title );
        title_input_selector[0].setAttribute('id', new_id_for_title );
        title_input_selector[0].setAttribute('name', new_id_for_title );

        const new_id_for_content = 'afb_data[contents]['+ counter +'][content]';
        const content_label_selector = clone.querySelectorAll( '[data-target="content-label"]' );
        const content_input_selector = clone.querySelectorAll( '[data-target="content-input"]' );
        content_label_selector[0].setAttribute('for', new_id_for_content );
        content_input_selector[0].setAttribute('id', new_id_for_content );
        content_input_selector[0].setAttribute('name', new_id_for_content );

        document.getElementById("afbItems").appendChild(clone);
        counter++;
    });


    // Shortable.js
    new Sortable(afbItems, {
        animation: 150,
        handle: '.handle',
        ghostClass: 'blue-background-class'
    });
})();