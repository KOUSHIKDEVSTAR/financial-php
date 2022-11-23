<style>
.select2-container .select2-selection--single {
    height: 34px !important;
}

.select2-container--default .select2-selection--single {
    border: 1px solid #ccc !important;
    border-radius: 0px !important;
}
</style>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>
                <?php if ($user['id']): ?>
                Transfer user <b><?= $user['name'] ?></b><br>
                <a class="btn btn-secondary" href="index.php">Back</a>
                <?php else: ?>
                Create new User
                <?php endif ?>
            </h3>
        </div>
        <div class="card-body">

            <form method="POST" enctype="multipart/form-data" action="">
                <label> Supplier Name</label>
                <select class="form-control select2 <?= $errors['ammount'] ? 'is-invalid' : '' ?>" value=""  name="transfer_account" required>
                    <option>Select Account</option>
                    <?php foreach ($alluser as $key => $value) {?>
                        <?php if ($value['id'] != $user['id']): ?>
                       <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                       <?php endif ?>
                    <?php } ?>
                    
                </select>
                <div class="invalid-feedback">
                        <?=  $errors['transfer_account'] ?>
                    </div>
                

                <div class="form-group">

                    <input name="withdrawalDate" value="<?= $date = date('Y-m-d H:i:s'); ?>" class="form-control"
                        type="hidden">

                </div>
                <div class="form-group">
                    <label>Ammount</label>
                    <input name="withdrawalammount" value="" id="ammount"
                        class="form-control <?= $errors['ammount'] ? 'is-invalid' : '' ?>">
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
$('.select2').select2();
</script>