
<div class = "row">
    <div class = "container mt-5">
        <div class="row d-flex">
            <?php foreach ($services as $service): ?>
                <div class = "articles col-md-4 mb-3 actualite">
                    <div class="article">
                        <h5> <?= ($service->getService()) ?></h5>
                        <p> <?= ($service->getDescription()) ?> </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-md-12 text-center mt-5">
            <div class="mt-3 mb-4">
                <a href="index.php?action=new_rdv" class="cta-appointment mb-3">Je prends rendez-vous</a>
            </div>
        </div>
    </div>
</div>