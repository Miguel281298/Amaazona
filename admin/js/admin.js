

/* 
    Event Listener to add more Select elements
*/

document.getElementById("add-product-bttn").addEventListener("click", function() {
    const originalSelectContainer = document.getElementById("select-product");
    // Clone the select container (but not the whole row)
    const clonedSelectContainer = originalSelectContainer.cloneNode(true);

    // Clear the ID to avoid duplication
    clonedSelectContainer.id = '';

    // Get the parent container
    const containerContainer = document.getElementById('container-container');

    // Get the button to insert the new element before
    const addButton = document.getElementById('add-product-bttn');

    // Insert the cloned select container before the button
    containerContainer.insertBefore(clonedSelectContainer, addButton.parentElement);
});