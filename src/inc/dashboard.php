<main id="dashboard">
    <div id="sidemenu">
        <section>
            <div id="side-topbar">
                <h3>Your <span class="brand">Pantries</span></h3>
                <button id="add-pantry" class="small-button">➕</button>
            </div>
            <div>
                <ul id="pantry-list">

                </ul>
            </div>
        </section>

    </div>
    <div id="contents">
        <h1>Hello, <?= $_SESSION['name'] ?? 'welcome to Pantry' ?>!</h1>
        <section>
            <div>
                <h3>
                Shopping list
            </h3>
            <button id="new-item" class="small-button">➕</button>
            </div>
            <ul id="shopping-list">
                
            </ul>
            
        </section>
    </div>
</main>
<script src="/../script.js"></script>