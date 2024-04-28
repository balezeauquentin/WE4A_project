</div>
<div class="col-2 p-0 vh-100">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light h-100">
        <!-- search bar -->
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Rechercher" aria-label="Search">
            <button class="btn btn-outline-secondary" type="button">
                <i class="fa fa-search"></i>
            </button>
        </div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php if (isset($_SESSION['id'])) {
            echo "modalPost";
        } else {
            echo "modalPost";
        } ?>">
            Poster
        </button>
        <!-- Modal -->
        <div class="modal fade" id="modalPost" tabindex="-1" role="dialog" aria-labelledby="modalPostLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="formPostId" class="formPost" method="POST" action="">
                        <div class="modal-header border-bottom-0">
                            <h5 class="modal-title" id="modalPostLabel">Nouveau post</h5>
                        </div>
                        <div class="modal-body">
                            <textarea id="textAreaPostId" name="textAreaPostId" class="form-control"
                                placeholder="" required
                                style="resize: none; height:30vh"></textarea>
                        </div>
                        <div class="modal-footer border-top-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <input type="submit" class="btn btn-primary" name="postSubmit" value="Publier le post" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End of modal -->
</div>
</body>

</html>