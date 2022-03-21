(function(){

    const addNew = document.getElementById( 'add-new-item' );
    addNew.addEventListener( 'click', function(e){
        e.preventDefault();
        
        const node = document.getElementById("clonable-item");
        const clone = node.cloneNode(true);
        document.getElementById("accordion-items").appendChild(clone);
    });
})();