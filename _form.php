<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>
                <?php if ($user['id']): ?>
                    Update user <b><?= $user['name'] ?></b>
                <?php else: ?>
                    Create new User
                <?php endif ?>
            </h3>
        </div>
        <div class="card-body">

            <form method="POST" enctype="multipart/form-data"
                  action="">
                <div class="form-group">
                    <label>Name</label>
                    <input name="name" value="<?= $user['name'] ?>"
                           class="form-control <?= $errors['name'] ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?=  $errors['name'] ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input name="email" value="<?= $user['email'] ?>"
                           class="form-control  <?= $errors['email'] ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?=  $errors['email'] ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input name="phone" value="<?= $user['phone'] ?>"
                           class="form-control  <?= $errors['phone'] ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?=  $errors['phone'] ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Image</label>
                    <input name="picture" type="file" class="form-control-file">
                </div>

                <button class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
