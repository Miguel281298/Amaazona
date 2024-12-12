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
document.getElementById("add-product-bttn-2").addEventListener("click", function() {
    const originalSelectContainer = document.getElementById("select-product");
    // Clone the select container (but not the whole row)
    const clonedSelectContainer = originalSelectContainer.cloneNode(true);

    // Clear the ID to avoid duplication
    clonedSelectContainer.id = '';

    // Get the parent container
    const containerContainer = document.getElementById('container-container-2');

    // Get the button to insert the new element before
    const addButton = document.getElementById('add-product-bttn-2');

    // Insert the cloned select container before the button
    containerContainer.insertBefore(clonedSelectContainer, addButton.parentElement);
});

/* 
    Query to consult the info of the selected Proveedor (Editar Datos de Proveedor)
*/
document.getElementById("select-proveedor-input").addEventListener("change", function() {
    // Get the selected user ID
    const userId = document.getElementById("select-proveedor-input").value;
    // Get the form inputs
    const form= document.getElementById("proveedores-form");
    // Change the user id in the hidden input
    document.getElementById("hidden-proveedores-input").value= userId;

    // If the user didn't select an option
    if (isNaN(userId))
    {
        const elementsArray = Array.from(form.elements); // Form inputs
        elementsArray.forEach(element => {
            element.value= "";
        });
        return;
    }

    if (userId) {
        // Consult Proveedor Information with a AJAX request
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
                
                const elementsArray = Array.from(form.elements); // Form inputs
                elementsArray.forEach(element => {
                    if (element.id in userInfo)
                    {
                        element.value= userInfo[element.id];    // Insert the data in the input
                    }
                });

                /* 
                    Insert the products of the Proveedor (select input)
                */
               userInfo["products"].forEach(element => {
                    // Clone the selector element
                    const originalSelectContainer = document.getElementById("select-product");
                    const clonedSelectContainer = originalSelectContainer.cloneNode(true);
                
                    // Clear the ID to avoid duplication
                    clonedSelectContainer.id = '';
                    // Pre-select an option
                    clonedSelectContainer.querySelector("select").value= element["ID_Producto"];
                
                    // Get the parent container
                    const containerContainer = document.getElementById('container-container-2');
                
                    // Get the button to insert the new element before
                    const addButton = document.getElementById('add-product-bttn-2');
                
                    // Insert the cloned select container before the button
                    containerContainer.insertBefore(clonedSelectContainer, addButton.parentElement);
               });
            }
        };
        xhr.send("user_id=" + userId + "&action=0"); // Send variables to the server
    }
});


/*
    Warning message to remove a proveedor from the DB
*/
document.getElementById("dar-baja-form").addEventListener("submit", (e)=>{
    // Get the proveedor name
    const name= document.getElementById("dar-baja-form").element.querySelector("select").value;
    // Confirm the action
    const userConfirmed = confirm(`¿Estás seguro de que deseas eliminar al proveedor ${name}?`);

    if(!userConfirmed)
        e.preventDefault();
});


/*
    Validate input (amount) type number
*/
function validateInput(input) {
    if (input.value < 0) input.value = 0;
    if (input.value > 9999) input.value = 9999;
}
/*
    Validate input (unit price) type number
*/
function validateInput2(input) {
    if (input.value < 0) input.value = 0;
    if (input.value > 99999) input.value = 99999;
}



/*
    Query to consult the products based on the selected proveedor
*/
document.getElementById("select-proveedor-comprar").addEventListener("change", (e)=>{
    // Get the selected user ID
    const userId = document.getElementById("select-proveedor-comprar").value;
    // Change the user id in the hidden input
    document.getElementById("comprar-user-id").value= userId;
    // Set visible the following elements
    document.getElementById("comprar-select-section").classList.remove("invisible");
    document.getElementById("comprar-button-section").classList.remove("invisible");

    // Consult Proveedor Information with a AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "comprar_inventario.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status === 200) {
            const userInfo = JSON.parse(xhr.responseText);

            const originalSelectInput= document.getElementById("select-product").querySelector("select");
            const clonedSelectInput= document.getElementById("comprar-select-section").querySelector("select");
            // Clean all options in the cloned select input
            while (clonedSelectInput.options.length > 0) {
                clonedSelectInput.remove(0); // Remove all options
            }
            const userInfoIDs = userInfo.map(product => product.ID_Producto); // Extract ID_Producto values
            Array.from(originalSelectInput.options).forEach(option => {
                if (userInfoIDs.includes(option.value)) {
                    // Add matching option to cloned select input
                    const clonedOption = document.createElement("option");
                    clonedOption.value = option.value;
                    clonedOption.textContent = option.textContent;
                    clonedSelectInput.appendChild(clonedOption);
                }
            });
        }
    };
    xhr.send("user_id=" + userId + "&action=0"); // Send variables to the server
});

// Add product (comprar section)
document.getElementById("comprar-add-product-bttn").addEventListener("click", function() {
    const originalSelectContainer = document.getElementById("comprar-select-section");

    // Clone the select container (but not the whole row)
    const clonedSelectContainer = originalSelectContainer.cloneNode(true);

    // Clear the ID to avoid duplication
    clonedSelectContainer.id = '';

    // Get the parent container
    const containerContainer = document.getElementById('container-container-3');

    // Get the button section to insert the new element before
    const addButtonSection = document.getElementById('comprar-button-section');

    // Insert the cloned select container before the button section
    containerContainer.insertBefore(clonedSelectContainer, addButtonSection);
});