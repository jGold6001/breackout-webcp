<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url("application/css/bootstrap.min.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("application/css/styles.css"); ?>" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Results</title>
</head>
<body>
    <main>
        <div id="result">
            <div class="row" style="border-bottom: 2px solid black; font-weight:bold;">
              <div class="col-md-4">place</div>
              <div class="col-md-4">name</div>
              <div class="col-md-4">score</div>
            </div>
            <?php 
            $count = 0;
            foreach($players as $row):?>
            <div class="row">
              <div class="col-md-4"><?= $count+1 ?></div>
              <div class="col-md-4"><?= $row['name'] ?></div>
              <div class="col-md-4"><?= $row['score'] ?></div>
            </div> 
            <?php 
             $count++;
            endforeach;?>
        </div>
        <div>
            <div class="link_reff">
                <h3><a href="<?php echo base_url('index.php/game'); ?>">Start new game</a><h3>
            </div>
        </div>
    </main>
</body>
</html>