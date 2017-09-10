<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Breackout</title>
    <link rel="stylesheet" href="<?php echo base_url("application/css/bootstrap.min.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("application/css/styles.css"); ?>" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
    <body style="background: url('<?php echo base_url();?>application/assets/img/bgBody.png');">
        
        <!--Game canvas-->
        <div class="container-fluid">
          <div class="row">
            <div id="breakoutGame"></div>
          </div>
        </div>
        
        <!--Print results-->
        <div class="container-fluid" id="result_view">
            <div class="row">
                <div id="result_txt"></div>
            </div>
            <div class="row">
                <div class="link_reff"></div>
            </div>
        </div>    
        
        <!--if click "Cancel"-->
        <div id="cancel" style="display: none;">
            <h1>Thanks for your visit</h1>
        </div>
        
        <!--Dialog for enter the name-->
        <div id="dialog" title="Welcome to Breackout" style="display:none; font-family:'Comic Sans MS';">
            <p>Enter your nickname<p>
            <form id="form">
                 <input type="text"  name="field" id="txtName" maxlength="25"/>
            </form>
        </div>
        
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>application/js/phaser.js" ></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script type="text/javascript" >
            $( function() {
              $("#dialog" ).dialog({
                modal: true,
                width: 220,
                resizable: false,
                buttons: {
                  Ok: function() {
                      
                        if ($('#form').valid()) {
                          
                            var game = new Phaser.Game(800, 600, Phaser.AUTO, 'breakoutGame', { preload: preload, create: create, update: update });
                  
                            function preload() {
                                game.canvas.id = "canvasId";
                                game.load.atlas('breakout', '<?php echo base_url();?>application/assets/img/breakOut.png', '<?php echo base_url();?>application/assets/json/breakOut.json');
                                game.load.image('starfield', '<?php echo base_url();?>application/assets/img/bgCanvas.png');
                            }
                            
                            var ball, paddle, bricks;
                            
                            var ballOnPaddle = true;
                            
                            var lives = 3;
                            var score = 0;
                            
                            var scoreText, livesText, introText;
                            
                            var s;
                            
                            function create() {
                                game.physics.startSystem(Phaser.Physics.ARCADE);
                                game.physics.arcade.checkCollision.down = false;
               
                                s = game.add.tileSprite(0, 0, 800, 600, 'starfield');
                            
                                bricks = game.add.group();
                                bricks.enableBody = true;
                                bricks.physicsBodyType = Phaser.Physics.ARCADE;
                            
                                var brick;
                            
                                var cnt = getRandomInt(0, 4);
                                var bricksMap = generateMap(cnt, 4, 15);
                            
                                for (var y = 0; y < 4; y++)
                                {
                                    for (var x = 0; x < 15; x++)
                                    {
                                        brick = bricks.create(120 + (x * 36), 100 + (y * 52), 'breakout', 'brick_' + getRandomInt(1,5) + '_1.png');
                                        brick.body.bounce.set(1);
                                        brick.body.immovable = true;
                                        
                                        if(x == bricksMap.get(y))
                                            brick =convertToBlick(brick);  
                                    }
                                }
                                
                                paddle = game.add.sprite(game.world.centerX, 500, 'breakout', 'paddle_big.png');
                                paddle.anchor.setTo(0.5, 0.5);
                            
                                game.physics.enable(paddle, Phaser.Physics.ARCADE);
                            
                                paddle.body.collideWorldBounds = true;
                                paddle.body.bounce.set(1);
                                paddle.body.immovable = true;
                            
                                ball = game.add.sprite(game.world.centerX, paddle.y - 16, 'breakout', 'ball_1.png');
                                ball.anchor.set(0.5);
                                ball.checkWorldBounds = true;
                            
                                game.physics.enable(ball, Phaser.Physics.ARCADE);
                            
                                ball.body.collideWorldBounds = true;
                                ball.body.bounce.set(1);
                            
                                ball.animations.add('spin', [ 'ball_1.png', 'ball_2.png', 'ball_3.png', 'ball_4.png', 'ball_5.png' ], 50, true, false);
                            
                                ball.events.onOutOfBounds.add(ballLost, this);
                            
                                scoreText = game.add.text(32, 550, 'score: 0', { font: "20px Arial", fill: "#ffffff", align: "left" });
                                livesText = game.add.text(680, 550, 'lives: 3', { font: "20px Arial", fill: "#ffffff", align: "left" });
                                introText = game.add.text(game.world.centerX, 400, '- click to start -', { font: "40px Arial", fill: "#ffffff", align: "center" });
                                introText.anchor.setTo(0.5, 0.5);
                            
                                game.input.onDown.add(releaseBall, this);
                            }
                            
                            function convertToBlick(_brick){
                                _brick.animations.add('animationBrick', [ 'brick_1_1.png', 'brick_2_1.png', 'brick_3_1.png', 'brick_4_1.png'], 10, true, false);
                                _brick.animations.play('animationBrick');
                                return _brick;
                            }
                            
                            function getRandArr(_cnt, _maxNum){
                                let arr = [];
                                while(_cnt != arr.length){
                                      let element = getRandomInt(0, _maxNum)
                                      if(!arr.includes(element))
                                        arr.push(element);
                                }
                                return arr;
                            }
                            
                            function generateMap(_cnt, _rows, _cols){
                                let arrKeys = getRandArr(_cnt, _rows);
                                let arrValues= [];
                                let mapElements = new Map();
                                let i=0;
                                while(_cnt != arrValues.length){
                                      var element = getRandomInt(0, _cols)
                                      if(!arrValues.includes(element)){
                                        arrValues.push(element);
                                        mapElements.set(arrKeys[i], element);
                                        i++;
                                      }
                                }
                                return mapElements;
                            }
                            
                            
                            function update () {
                                paddle.x = game.input.x;
                            
                                if (paddle.x < 24)
                                    paddle.x = 24;
                                else if (paddle.x > game.width - 24)
                                    paddle.x = game.width - 24;
                            
                                if (ballOnPaddle)
                                    ball.body.x = paddle.x;
                                else{
                                    game.physics.arcade.collide(ball, paddle, ballHitPaddle, null, this);
                                    game.physics.arcade.collide(ball, bricks, ballHitBrick, null, this);
                                }
                            }
                            
                            function getRandomInt(_min, _max) {
                                return Math.floor(Math.random() * (_max - _min)) + _min;
                            }
                            
                            function releaseBall () {
                            
                                if (ballOnPaddle){
                                    ballOnPaddle = false;
                                    ball.body.velocity.y = -300;
                                    ball.body.velocity.x = -75;
                                    ball.animations.play('spin');
                                    introText.visible = false;
                                }
                            }
                            
                            function ballLost () {
                                lives--;
                                livesText.text = 'lives: ' + lives;
                            
                                if (lives === 0)
                                    gameOver();
                                else{
                                    ballOnPaddle = true;
                                    ball.reset(paddle.body.x + 16, paddle.y - 16);
                                    ball.animations.stop();
                                }
                            }
                            
                            function gameOver () {
                                ball.body.velocity.setTo(0, 0);
                                
                                introText.text = 'Game Over!';
                                introText.visible = true;
                                
                                var name = $("#txtName").val();
                                
                                var data = {
                                  "name": name,
                                  "score": score
                                };
                            
                                $.ajax({
                                     url: "<?php echo base_url('index.php/game/adddata'); ?>",
                                     type : "POST",
                                     dataType : "json",
                                     data: { data: data }
                                });
                                
                                $("#result_txt").html("<h3>'"+name+"' your score: "+score+"</h3>");
                                $(".link_reff").html("<div class='loader'></div>");
                                setTimeout(function() {
                                     $(".link_reff").remove('.loader');
                                     $(".link_reff").load("<?php echo base_url('index.php/game/showresults'); ?>");
                                } ,2500);
                            } 
                            
                            function ballHitBrick (_ball, _brick) {
                                _brick.kill();
                                score += getScoreBrick(_brick);
                                scoreText.text = 'score: ' + score;
                            
                                if (bricks.countLiving() == 0){
                                    score += 1000;
                                    scoreText.text = 'score: ' + score;
                                    introText.text = '- Next Level -';
                            
                                    ballOnPaddle = true;
                                    ball.body.velocity.set(0);
                                    ball.x = paddle.x + 16;
                                    ball.y = paddle.y - 16;
                                    ball.animations.stop();
                            
                                    bricks.callAll('revive');
                                }
                            }
                            
                            function getScoreBrick(_brick){
                                let indexFrame;
                                const BRICK_BLICK_ID = 8;
                                if(isAnimation(_brick))
                                    indexFrame = BRICK_BLICK_ID;
                                else
                                    indexFrame = _brick._frame.index;
                                
                                var score_brick;
                                switch (indexFrame) {
                                    case 22: score_brick =10;
                                        break;
                                    case 5: score_brick =15;
                                        break;
                                    case 9: score_brick =20;
                                        break;
                                    case 13: score_brick =25;
                                        break;
                                    case BRICK_BLICK_ID: score_brick=2000;
                                        break;
                                }
                                return score_brick;
                            }
                            
                            function isAnimation(_brick){
                                if(_brick.animations._anims.animationBrick != null)
                                    return true;
                                else
                                    return false;
                            }
                            
                            
                            function ballHitPaddle (_ball, _paddle) {
                                var diff = 0;
                            
                                if (_ball.x < _paddle.x){
                                    diff = _paddle.x - _ball.x;
                                    _ball.body.velocity.x = (-10 * diff);
                                }
                                else if (_ball.x > _paddle.x){
                                    diff = _ball.x -_paddle.x;
                                    _ball.body.velocity.x = (10 * diff);
                                }
                                else
                                    _ball.body.velocity.x = 2 + Math.random() * 8;
                            }   
                            $( this ).dialog( "close" ); 
                        }
                  },
                  Cancel: function() {
                    $("#cancel").css("display", "block"); 
                    $( this ).dialog( "close" );
                  }
                }
              });
              $('#form').validate({
                rules: {
                  field: {
                    required: true,
                    maxlength: 25,
                    minlength: 3
                  }
                }
              });
            });
        </script>
    </body>
</html>