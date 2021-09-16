<?php
    include 'action.php';
?>

<div class="modal-header">
    <h5 class="modal-title"><?= $vname; ?></h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"></span>
    </button>
</div>
<div class="modal-body">
    <img src="<?= $vimage; ?>" class="img-fluid mx-auto d-block">
    <p class="mt-3"><strong class="text-primary">Genre:</strong> <?= $vgenre; ?></p>
    <p><strong class="text-primary">Rating:</strong> <?= $vrating; ?></p>
    <p><strong class="text-primary">Status:</strong> <?= $vstatus; ?></p>
    <p><strong class="text-primary">Comments:</strong> <?= $vcomments; ?></p>
</div>
<div class="modal-footer">
<a href="index.php?edit=<?= $row['ID']; ?>"><button type="button" class="btn btn-primary">Edit</button></a>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
 