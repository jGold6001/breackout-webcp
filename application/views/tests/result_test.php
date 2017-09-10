<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/style.css"); ?>" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enter the data</title>
</head>
<body>
    <main>
        <div class="row" id="testForm">
            <form>
                <input type="text" id="name_text" />
                <input type="text" id="score_text"/>
                <button>Click</button>
            </form>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $("button").click(function(){
                var data = {
                    "name": $("#name_text").val(),
                    "score": $("#score_text").val()
                };
                
               $.ajax({
                   url: "<?php echo base_url('index.php/game/adddata'); ?>",
                   type : "POST",
                   dataType : "json",
                   data: { data:  data }
               });
            });
        });
    </script>
</body>
</html>