

/* 
    Event Listener to add more Select elements (Dar de Alta Proveedor)
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

/* 
    Query to consult the info of the selected Proveedor (Editar Datos de Proveedor)
*/
document.getElementById("select-proveedor-input").addEventListener("change", function() {
    // Get the selected user ID
    const userId = document.getElementById("select-proveedor-input").value;
    const form= document.getElementById("proveedores-form");

    // If the user didn't select an option
    if (isNaN(userId))
    {
        const elementsArray = Array.from(form.elements);
        elementsArray.forEach(element => {
            element.value= "";
        });
        return;
    }

    if (userId) {
        // Create the AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "editar_proveedor.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                const userInfo = JSON.parse(xhr.responseText);

                /* 
                    Fill the form with the user information.
                */
                if (form.classList.contains("invisible")) // Set the form visible
                    form.classList.remove("invisible");
                
                const elementsArray = Array.from(form.elements);
                elementsArray.forEach(element => {
                    if (element.id in userInfo)
                    {
                        element.value= userInfo[element.id];
                    }
                });
            }
        };
        xhr.send("user_id=" + userId + "&action=0"); // Send variables to the server
    }
});


