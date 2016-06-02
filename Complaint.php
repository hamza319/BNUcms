<!DOCTYPE html>
<html>
    <head>
        <title>Complaint</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="css/menu.css" type="text/css">
        <script src="js/jquery.min_2.js"></script>
        <script type="text/javascript">
        function toggleStudent()
                {
                    $('.student').css("display","none");
                }
            function toggleResponse()
            {
                $('#response').css("display","none");
            }
            
            function toggleReply(toggle)
            {
                if(toggle === 1)
                    $('#reply').prop("disabled", false);
                else if (toggle === 0)
                    $('#reply').prop("disabled", true);
            }
            
            var main = function(){
            $('#replyDesc').keyup(function(){
                if(this.value === "")
                {
                    toggleReply(0);
                }
                else
                {
                    toggleReply(1);
                }
            });
            
            $('#reply').click(function (){
                 $.ajax({
                    type: "POST",
                    url: "reply.php",
                    data: { des: document.getElementById("replyDesc").value,
                            id: document.getElementById("id").innerHTML,
                            sender: document.getElementById('sender').innerHTML
                            },
                    cache: false,
                    success: function(result){
                    if(result ==="done")    
                    {
                        alert("SENT!");
                        window.location.href = "welcome.php";
                    }
                    else{
                        alert(result);

                    }
               }
            });
           });
       };
       
       $(document).ready(main);
        </script>
    </head>
    <body>
        <?php
            require_once './classes/mailbox.php';
            require_once './classes/faculty.php';
            require_once './classes/student.php';
            session_start();

            $mailbox = $_SESSION['mailbox'];
            $mode = $_SESSION['mode'];
            
            $id= isset($_GET['thing']) ? $_GET['thing'] : NULL;
            $inbox= isset($_GET['From']) ? $_GET['From'] : NULL;
            
            
            
            if($inbox === "res")
            {
                $thing = $mailbox->getResponseById($id);
            }
            if($inbox === "snt")
            {
                $thing = $mailbox->getSentById($id);
            }
            if($inbox === "rec")
            {
                $thing = $mailbox->getRecievedById($id);
            }
            
            $sender = $thing->getRoll();
            if($sender[0]==="f" || $sender[0]==="s")
            {
                $user= new Student();
                $user->loadUser($thing->getRoll());
            }
            else
            {
                $user=new Faculty();
                $user->loadUser($thing->getRoll());
            }
           
        ?>

        <nav class="navbar navbar-inverse " style="z-index: 3">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="pull-left" href="welcome.php"><img src="images/bnulogo.webp" height="70" style="padding: 2px"></a>
                </div>
                
                <p class="navbar-text" style="font-size: 20px">Complaint/Request Management System</p>
                
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php?logout=yes" style="font-size: 20px">logout <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></li>
                </ul>
                
            </div>
        </nav>
       
        <<div id="menuMain">
        <div class="smallMenu">
            <span class="glyphicon glyphicon-home" aria-hidden="true" style="top: 130px;"></span>
            <span class="glyphicon glyphicon-envelope student" aria-hidden="true" style="top: 285px;"></span>
            <span class="glyphicon glyphicon-send " aria-hidden="true" style="top: 181px;"></span>
            <span class="glyphicon glyphicon-repeat " aria-hidden="true" style="top: 235px;"></span>
        </div>
        
        <div class="menu">
        <br/><br/>
        <ul>
            <li><a href="welcome.php">Home</a></li>  
            <li><a href="ViewSent.php">Sent</a></li>
            <li><a href="ViewResponses.php">Responses</a></li>
            <li class="student"><a href="ViewRecieved.php">Received</a></li>
        </ul>
        </div>
       </div> 
        <br/>
        <div class="container">
            <div class="main">
                <div class="panel panel-primary">
                    <div class="panel-heading" style="text-align: center"><h4>Subject: <?php echo $thing->getSubject(); ?></h4></div>
                        <div class="panel-body">
                            <br/>
                            
                            <div style="text-align: center">
                                <strong>Name:</strong>
                                <i><?php echo $user->getName(); ?>&nbsp;</i>
                                
                                <?php
                                        
                                if($sender[0]==="f" || $sender[0]==="s")
                                {
                                    echo "<strong>Program:</strong>";
                                    echo "<i>".$user->getDept() ."&nbsp;&nbsp;</i>";
                                    echo "<strong>Roll#:</strong>";
                                    echo "<i><span id='sender'>". $user->getRoll() ."</span>&nbsp;&nbsp;</i>";
                                }
                                else
                                {
                                    echo "<strong>Department:</strong>";
                                    echo "<i>".$user->getDept() ."&nbsp;&nbsp;</i>";
                                    echo "<strong>ID#:</strong>";
                                    echo "<i><span id='sender'>". $user->getId() ."</span>&nbsp;&nbsp;</i>";
                                }
                                ?>
                           </div>
                            <br/>
                            <div style="text-align: center">
                                <strong>Type:</strong>
                                <i><?php echo $thing->getType(); ?>&nbsp;&nbsp;</i>
                                <strong>Date:</strong>
                                <i><?php echo $thing->getDate();?>&nbsp;&nbsp;</i>
                                <strong>Complaint ID:</strong>
                                <i><span id="id"><?php echo $thing->getId(); ?></span>&nbsp;&nbsp;</i>
                            </div>
                            <br/><br/>
                            
                            <div class="container">
                            <div class="row">
                                <div class="col-sm-1"></div>
                                    <div class="col-sm-9" style="border-style: solid; border-width: 2px; min-height: 200px">
                                        <p><?php echo $thing->getDecrpiton();?></p>                                    
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                                <br/>
                                <p><b><i>Attachments: </i></b></p>
                                <img id="uploaded" src="<?php echo $thing->getAtt(); ?>"  width="100" height="100">
                                <br/><br/>

                            
                            <div class="row" id="response">                                
                                <div class="col-sm-1"></div>
                                    <div class="col-sm-9" style="border-style: solid; border-width: 2px; min-height: 100px; ">
                                        <p style="text-align: center; margin-top: 10px"><b><i>Response </i></b></p>
                                        <hr>
                                            <p><?php echo $thing->getResponse();?></p> 
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                                <br/><br/>
                                </div>
                              <?php 
                              if($mode==="faculty")
                              {
                                  if($_GET['From'] === "rec")
                                  {
                                    echo '<textarea style="width: 500px; margin-left: 9%" rows="8" id="replyDesc" placeholder="Type in a response"></textarea>';
                                    echo '<div style="margin-left: 45%">';
                                    echo '<button class="btn btn-default" id="reply" disabled="disabled">Reply</button></div>';
                                  }
                              }
                              if($mode==="student")
                                {
                                    echo '<script type="text/javascript">toggleStudent();</script>';
                                }
                                if($_GET['From'] === "snt" || $_GET['From'] === "rec")
                                {
                                    
                                    ?>
                                    <script type="text/javascript">
                                        toggleResponse();
                                    </script>
                                    <?php
                                }
                             ?>
                        
                        </div>
                    </div>
                </div>
        </div>
        <script src="js/jquery.min_2.js"></script>
        <script src="js/menu.js"></script> 
    </body>
</html>

