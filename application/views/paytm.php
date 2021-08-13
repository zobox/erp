<!DOCTYPE html>
<html lang="en">
<head>
  <title>Paytm Integration</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <div class="col-md-3"></div>
  <div class="col-md-6">

  <form action="<?php echo base_url()?>invoices/paytm_transaction" method="post" enctype="multipart/form-data">
     <div class="form-group">
      <label for="email"><?=ucfirst($field_name[0])?>:</label>
      <input type="text" class="form-control" name="<?=$field_name[0]?>" value="<?=$paytm_field[channelId]?>">
    </div>
     <div class="form-group">
      <label for="email"><?=ucfirst($field_name[1])?>:</label>
      <input type="text" class="form-control" name="<?=$field_name[1]?>" value="<?=$paytm_field[checksum]?>">
    </div>
     <div class="form-group">
      <label for="email"><?=ucfirst($field_name[2])?>:</label>
      <input type="text" class="form-control" name="<?=$field_name[2]?>" value="<?=$paytm_field[paytmMid]?>">
    </div>
     <div class="form-group">
      <label for="email"><?=ucfirst($field_name[3])?>:</label>
      <input type="text" class="form-control" name="<?=$field_name[3]?>" value="<?=$paytm_field[paytmTid]?>">
    </div>
     <div class="form-group">
      <label for="email"><?=ucfirst($field_name[4])?>:</label>
      <input type="text" class="form-control" name="<?=$field_name[4]?>" value="<?=$paytm_field[merchantTransactionId]?>">
    </div>
     <div class="form-group">
      <label for="email"><?=ucfirst($field_name[5])?>:</label>
      <input type="text" class="form-control" name="<?=$field_name[5]?>" value="<?=$paytm_field[transactionAmount]?>">
    </div>
     
   
    <button type="submit" class="btn btn-default" name="submit">Submit</button>
  </form>
</div>
 <div class="col-md-3"></div>
</div>

</body>
</html>
