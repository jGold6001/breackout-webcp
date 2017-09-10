<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
</head>
    <body>
        <div id="dialog" title="Welcome to Breackout">
             <p>Enter your name<p>
             <input type="text" id="txtName" />
        </div>
        <script>
          $( function() {
            $( "#dialog" ).dialog({
              modal: true,
              width: 220,
              resizable: false,
              buttons: {
                Ok: function() {
                    
                    /*my code*/
                    
                    $( this ).dialog( "close");
                },
                Cancel: function() {
                  $( this ).dialog( "close" );
                }
              }
            });
          } );
         </script>
    </body>
</html>