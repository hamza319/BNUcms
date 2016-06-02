<!DOCTYPE html>
<html>
    <head>
        <title>Received Complaints</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="css/menu.css" type="text/css">
        <script src="js/jquery.min_2.js"></script>
        
        <style type="text/css">
            tr.item.hover {
                cursor: pointer;
            }   
        </style>
        <script type="text/javascript">
           
            function toggleSearch(toggle)
            {
                if(toggle === 1)
                    $('#submit').prop("disabled", false);
                else if (toggle === 0)
                    $('#submit').prop("disabled", true);
            }

            function filter(toggle)
            {
                if(toggle === "Complaint")
                {
                    $('.item').css("display","none");
                    $(' .Complaint').css("display","table-row");
                }
                else if (toggle === "Request")
                {
                    $('.item').css("display","none");
                    $('.Request').css("display","table-row");
                }
                else
                {
                    $('.item').css("display","table-row");
                }
            }
           var main = function (){
               
               
                $('#filter').change(function (){
                    selection = document.getElementById('filter').value;
                    filter(selection);
                });               
               
                $('#reset').click(function(){
                    $('.item').css("display","table-row");
                });
                
                $('#query').keyup(function(){
                if(this.value === "")
                {
                    toggleSearch(0);
                }
                else
                {
                    toggleSearch(1);
                }
            });
               
                $('tr.item').click( function() {
                    window.location= $(this).data("href");
                    }).hover( function() {
                        $(this).toggleClass('hover');
                    });
                
                $('#submit').click(function (){
                    $.ajax({
                        type: "POST",
                        url: "search.php",
                        data:{ query: document.getElementById("query").value,
                               inbox: "sent"
                            },
                        cache: false,
                        dataType: 'json',
                        success: function(result){
                            $('.item').css("display","none");
                            
                            jQuery.each(result, function(index, items) {
                                $('#'+items).css("display","table-row");
                            });
                        }
                    });
                    });
            };
            
            function toggleStudent()
                {
                    $('.student').css("display","none");
                }
            
            $(document).ready(main);
        </script>
    </head>
    <body>
            <?php
                require_once './classes/mailbox.php';
                session_start();
                
                $mode = $_SESSION['mode'];
               
            ?>
    
        <nav class="navbar navbar-inverse " style="z-index: 3">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="pull-left" href="#"><img src="images/bnulogo.webp" height="70" style="padding: 2px"></a>
                </div>
                
                <p class="navbar-text" style="font-size: 20px">Complaint/Request Management System</p>
                
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php?logout=yes" style="font-size: 20px">logout <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></li>
                </ul>
                
            </div>
        </nav>
       
    <div id="menuMain">
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
            <li><a href="#">Sent</a></li>
            <li><a href="ViewResponses.php">Responses</a></li>
            <li class="student"><a href="ViewRecieved.php">Received</a></li>
        </ul>
        </div>
       </div> 

        <div class="container">
            <div class="main" style="text-align: center">
                <strong style='font-size: 20px'>Sent Complaints</strong>
                
                               <br/>
                                <div class="form-group form-inline">
                                    <input type="text" id="query" placeholder="Srearch" style="width: 270px" >
                                    <button id="submit" class="btn btn-default" disabled="disabled">Find!</button>
                                    <select class="form-control" id="filter" style="width: 125px;">
                                        <option selected="selected" >All</option>
                                        <option >Complaint</option>
                                        <option>Request</option>
                                    </select>                                    
                                    <button id="reset" class="btn btn-info" >RESET</button>
                                </div>
                                
                <div class="row" style="border-style: solid">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <table class="table table-hover" style="text-align: left">
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Recipient</th>
                                <th>Date</th>
                                <th>Type</th> 
                            </tr>
                            <?php
                            
                                $mailbox = $_SESSION['mailbox'];
                                
                                for($i=0; $i<$mailbox->getSentSize();$i++){
                                
                                    $cr = $mailbox->getSent($i);
                                    
                                    echo "<tr class='item ".$cr->getType()."' id='".$cr->getID()."' data-href='Complaint.php?thing=".$cr->getID()."&From=snt'>";
                                    echo "<td>".$cr->getID()."</td>";
                                    echo "<td>".$cr->getSubject()."</td>";
                                    echo "<td>".$cr->getRecpt()."</td>";
                                    echo "<td>".$cr->getDate()."</td>";
                                    echo "<td>".$cr->getType()."</td>";
                                    echo "<tr>";
                                }
                            ?>
                        </table>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
        <script src="js/jquery.min_2.js"></script>
        <script src="js/menu.js"></script> 
        <?php
        if($mode==="student")
        {
            echo '<script type="text/javascript">toggleStudent();</script>';
        }
        ?>
    </body>
    
</html>
