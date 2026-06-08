document.addEventListener("DOMContentLoaded", init);
document.getElementById("add-pantry").addEventListener("click", new_pantry);
document.getElementById("new-item").addEventListener("click", () => new_item(null,null));

async function init(){
    await get_all_pantries();
    get_shopping_list();
}

async function get_all_items(pantry_id) {
    let response = await fetch("/src/commons/get_pantry_items.php", { method: "POST", body: new URLSearchParams({ pantry_id: pantry_id }) });
    let data = await response.json();
    for(item of data) {
        writeItemRow(item.id, item.pantry_id, "pantry", item.name, item.quantity);
    };
}

async function get_shopping_list() {
    let response = await fetch("/src/commons/get_shopping_list.php", { method: "POST" });
    let data = await response.json();
    data.forEach(item => {
        writeItemRow(item.id, item.item_id, "", item.name, item.quantity);
    });
}

async function get_all_pantries() {
    let response = await fetch("/src/commons/get_pantries.php", { method: "GET" });
    let data = await response.json();
    data.forEach(pantry => {
        writePantryRow(pantry.id, pantry.name);
        get_all_items(pantry.id);
    });
}

function writePantryRow(id, name) {
    let listContainer = document.getElementById("pantry-list");
    let listItem = document.createElement("li");
    listItem.setAttribute("pantry-id", id);
    listItem.innerHTML = `
            <details>
                <summary><span class="pantry-name">${name}</span>
                    <div class="pantry-actions">
                        <button class="small-button add-item">➕</button>
                        <button class="small-button edit-pantry">✏️</button>
                        <button class="small-button delete-pantry">🗑️</button>
                    </div>
                </summary>
                <ul class="items-list">
                </ul>
            </details>`;
    listContainer.appendChild(listItem);
}

function writeItemRow(id, parent_id, parent, name, quantity) {
    let cart_button = "";
    let pantryContainer = document.getElementById("pantry-list");
    let itemList;
    if(parent=="pantry"){ 
        itemList = pantryContainer.querySelector(`[pantry-id="${parent_id}"] .items-list`)
        cart_button="<button class='small-button add-cart'>🛒</button>"
    }
    else{ itemList = document.getElementById('shopping-list');}
    let listItem = document.createElement("li");
    listItem.setAttribute("item-id", id);
    listItem.innerHTML = `
            <span class="item-name">${name}</span>
            <div class="item-actions">
                <input type="number" min=0 value=${quantity}>
                ${cart_button}
                <button class="small-button item-options">⚙️</button>
                <div class="meatball hidden">
                    <button class="edit-item">✏️ Edit</button>
                    <button class="delete-item">🗑️ Delete</button>
                </div>
            </div>
            `;
    itemList.appendChild(listItem);
}

async function new_item(parent_id, parent) {
    let column, table, type;
    if(parent == null || parent == "item"){
        table = "shopping_list"
        column = "item_id";
    }
    if(parent == "pantry"){
        table = "pantry_item";
        column = "pantry_id";
    }
    let response = await fetch("/src/commons/new_item.php", { method: "POST", body: new URLSearchParams({ table: table, column: column, parent_id: parent_id}) });
    let data = await response.json();
    if (data.status == 'success') {
        writeItemRow(data.id, parent_id, parent, data.item_name, data.quantity);
    } else {
        alert("Sorry, we couldn't process your request at this time.");
    }
}

async function new_pantry() {
    let response = await fetch("/src/commons/new_pantry.php", { method: "POST" });
    let data = await response.json();
    if (data.status == 'success') {
        writePantryRow(data.id, data.pantry_name);
    } else {
        alert("Sorry, we couldn't process your request at this time.");
    }
}

document.addEventListener("click", function(event){
    let button = event.target.closest(".item-options");
    let actionContainer = button?.closest(".item-actions");
    let menu = actionContainer ? actionContainer.querySelector(".meatball"): null;
    document.querySelectorAll(".meatball").forEach(div => {
        if(div!=menu){
            div.classList.add("hidden");
        }
    })
    if (button!=null && button.classList.contains("item-options")) {
        menu.classList.toggle("hidden");
    }
});

document.addEventListener("click", function (event) {
    let li = event.target.closest("li");
    if (!li) return;
    let table;
    let cartButton = li.querySelector(".add-cart");
    let type = li.hasAttribute("pantry-id") ? "pantry" : "item";
    if(type=="pantry"){ table = "pantries";}
    else if(type=="item" && cartButton==null){ table = "shopping_list";}
    else{ table = "pantry_item";}
    let id = li.getAttribute(`${type}-id`);
    if (event.target.classList.contains(`delete-${type}`)) {
        deleteEntity(id, li, table);
    }
    if (event.target.classList.contains(`edit-${type}`)) {
        editEntity(id, li, type);
    }
    if (event.target.classList.contains("add-item")) {
        new_item(id, type);
    }
    if (event.target.classList.contains("add-cart")) {
        addToShoppingList(id);
    }
});

document.addEventListener("change", function(event){
    let li = event.target.closest("li");
    if(!li) return;
    let cartButton = li.querySelector(".add-cart");
    let id = li.getAttribute("item-id");
    let input = event.target;
    if(input){
        if( cartButton == null){ table = "shopping_list";}
        else{ table = "pantry_item";}
        if(input.type == "number"){
            changeEntity(id, li, input.value,"", table, "quantity");
        }
    }
});

function addToShoppingList(id){
    new_item(id,"item");

}

function editEntity(id, li, type) {
    let input, table;
    let edit = li.querySelector(`.${type}-name`);
    let oldName = edit.textContent;
    let cartButton = li.querySelector(".add-cart");
    edit.innerHTML = `<input type="text" class="${type}-rename" value="${oldName}">`;
    edit.querySelector(`.${type}-rename`).focus();
    input = edit.querySelector(`.${type}-rename`);
    if (type=="pantry"){ table = "pantries";}
    if (type == "item"){ table = "pantry_item";}
    if (cartButton == null){ table = "shopping_list";}
    input.addEventListener("blur", function (event) {
        changeEntity(id, li, input.value, type, table, "name");
    });
    input.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            changeEntity(id, li, input.value, type, table, "name");
        }
    });
}

async function changeEntity(id, li, val, type, table, column) {
    let response = await fetch("/src/commons/edit.php", { method: "POST", body: new URLSearchParams({ table: table, column: column, id: id, val: val }) });
    let data = await response.json();
    if(column=="name"){
        if (data.status == 'success') {
            let text = li.querySelector(`.${type}-name`);
            text.textContent = val;
        }
    }
}

async function deleteEntity(id, li, table) {
    if (table == 'pantries') {
        if (confirm("Are you sure you want to delete this Pantry? This action cannot be undone.") == false) {
            return;
        }
    }
    let response = await fetch(`/src/commons/delete.php`, {
        method: "POST", body: new URLSearchParams({ table: table, id: id })
    });
    let data = await response.json();
    if (data.status == 'success') {
        li.remove();
    }
}