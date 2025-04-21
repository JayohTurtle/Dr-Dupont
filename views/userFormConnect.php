<div class="d-flex justify-content-center mt-5">
    <div class="articles col-md-3 d-flex justify-content-center">
        <div class="article" style="width: 350px; max-width: 90%;">
            <h5 class="text-center mb-4">Connexion</h5>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success">
                    <?php 
                        echo $_SESSION['success_message']; 
                        unset($_SESSION['success_message']); // Supprime après affichage
                    ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?action=login">
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control input-clean" id="email" name="email" required autocomplete="off">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Mot de passe</label>
                    <input type="password" class="form-control input-clean" id="password" name="password" required autocomplete="off">
                </div>
                <button type="submit" class="btn btn-secondary w-100">Se connecter</button>
            </form>
        </div>
    </div>
</div>
