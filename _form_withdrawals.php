<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>
                <?php if ($user['id']): ?>
                    Withdrawals user <b><?= $user['name'] ?></b><br>
                    <a class="btn btn-secondary" href="index.php">Back</a>
                <?php else: ?>
                    Create new User
                <?php endif ?>
            </h3>
        </div>
        <div class="card-body">

            <form method="POST" enctype="multipart/form-data"
                  action="">
                  
                
                <div class="form-group">
                    
                    <input name="withdrawalDate" value="<?= $date = date('Y-m-d H:i:s'); ?>"
                           class="form-control" type="hidden">
                    
                </div>
                <div class="form-group">
                    <label>Ammount</label>
                    <input name="withdrawalammount" value="" id="ammount" class="form-control <?= $errors['ammount'] ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback">
                        <?=  $errors['withdrawalammount'] ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Balance</label>
                    <input name="balance" id="balance" value="<?php if($user['balance']==0){echo 0;}else{echo $user['balance'];}?>" class="form-control  <?= $errors['balance'] ? 'is-invalid' : '' ?>">
                    <input id="balance_main" value="<?php if($user['balance']==0){echo 0;}else{echo $user['balance'];}?>" class="form-control  <?= $errors['balance'] ? 'is-invalid' : '' ?>" type="hidden">
                    <div class="invalid-feedback">
                        <?=  $errors['balance'] ?>
                    </div>
                </div>
                
                

                <button class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
<script>
    $('#ammount').on('keyup', function() {
            var price = parseInt($('#balance_main').val());
            var price_dis = parseInt($('#ammount').val());
            sell_price = price - price_dis;
            $('#balance').val(sell_price);
        })
</script>
