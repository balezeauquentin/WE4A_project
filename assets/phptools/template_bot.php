</div>

<script src="assets/js/search.js" defer></script>

<div class="col-2 p-0 vh-100">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light h-100">
        <!-- search bar -->
        <div class="input-group">
            <input id="text-input" type="text" class="form-control" placeholder="Search" aria-label="Search">
            <button id="search-btn"class="btn btn-outline-secondary" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>
        <div class="nav col-12">
            <!-- Used to decide what is searched between usernames and posts -->
            <select class="form-select" aria-label="Search type">
            <option selected>Usernames</option>
            <option>Posts</option>
            </select>
        </div>
        <div id="search-container" class="overflow-auto h-100 mt-2 d-flex flex-column align-items-center"></div>
    </div>
    <!-- End of modal -->
</div>
</body>

</html>