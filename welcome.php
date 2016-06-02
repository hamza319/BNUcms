<!DOCTYPE html>
<html>
    <head>
        <title>Welcome To BNU CRMS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="css/menu.css" type="text/css">
        <style type="text/css">
            #marqueecontainer{
            position: relative;
            width: 700px; /*marquee width */
            height: 200px; /*marquee height */
            background-color: white;
            overflow: hidden;
            padding: 2px;
            padding-left: 4px;
            margin: 0 auto;
            margin-top: 6%;
            }
        </style>
        <script src="js/jquery.min_2.js"></script>
        <script type="text/javascript">
            function getDetails()
            {

                $.ajax({
                    type: "POST",
                    url: "welcomeData.php",
                    data: { roll: document.getElementById("rollNum").innerHTML
                        },
                    dataType:"json",
                    cache: false,
                    success: function(result){
                    
                        console.log(result);
                        if(jQuery.type(result)=== "object")
                        {
                            
                            document.getElementById("name").innerHTML=result.name;
                            
                            if(result.rollNum)
                            {
                                document.getElementById("rollNum").innerHTML=result.rollNum;
                                document.getElementById("dept").innerHTML=result.Dept;
                                document.getElementById("foot").innerHTML="***STUDENT&nbsp;MODE***";
                                
                                $('.student').css("display","none");
                                $('#something2').css("display","initial");
                                $('#something').css("display","none");
                                
                            }
                            else if(result.Id)
                            {
                                document.getElementById("id").innerHTML="ID:";
                                document.getElementById("rollNum").innerHTML=result.Id;
                                document.getElementById("DP").innerHTML="Department:";
                                document.getElementById("dept").innerHTML=result.Dept;
                                document.getElementById("foot").innerHTML="***FACULTY&nbsp;MODE***";
                                
                            }
                        }
                        else if(result==="not logged-in")
                        {
                            alert("you are not logged-in. Please log-in");
                        }
                           
                    },
                    error: function(event){
                        document.getElementById("errors").innerHTML=event.responseText;
                    }
                    
            });
            }
            
            function newComplaint()
            {
                window.location.href="newCR.php?type=complaint";
            }
            
            function newRequest()
            {
                window.location.href="newCR.php?type=request";
            }
            
            function getMsgs()
           {
               
              $.ajax({
                  type: 'POST',
                  url: "scrollerData.php",
                  dataType: 'json',
                  cache: false,
                  success: function (data) {

                        jQuery.each(data, function(index, items) {
                            $("#vmarquee").append("<div class='well' style='width: 660px'><b>"+items+"</b></div>");
                    });
                    }
                    
              });
           }
          
        </script>
    </head>
    <body>
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
            <li ><a href="welcome.php">Home</a></li> 
            <li><a href="ViewSent.php">Sent</a></li>
            <li><a href="ViewResponses.php">Responses</a></li>
            <li class="student"><a href="ViewRecieved.php">Received</a></li>
        </ul>
        </div>
       </div>    
        
    <div class="container">
        <div class="main">
            <div class="panel panel-primary">
                <div class="panel-heading" style="text-align: center"><h4>Welcome</h4></div>
                    <div class="panel-body">
                        
                        <span id='errors'></span>
                        <div style="text-align: center">
                                <strong>Name:</strong>
                                <span id="name"></span>
                                
                                <strong id="DP">Program:</strong>
                                <span id="dept"></span>
                                
                                <strong id="id">Roll#:</strong>
                                <span id="rollNum"><?php  if (isset($_POST['roll'])) {
                                                                echo $_POST['roll'];
                                                                         }
                                                                         else
                                                                             echo "nothing";
                                ?></span>
                        </div>
                        <br><br><br>
                        <div class="form-group" style="text-align: center">
                        <button type='button' class="btn-lg btn-default" onclick="newComplaint();">New Complaint</button>
                        <button type='button' class="btn-lg btn-default" onclick="newRequest();">New Request</button>
                        </div>
                        
                        
                            <script type="text/javascript">
                            
                            </script>
                            <div id="marqueecontainer" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">
                            <div id="vmarquee"  style="position: absolute; width: 100%;">
                            </div>
                            </div>
                            <script type="text/javascript">getMsgs();</script>
                            <script src="js/scroller.js"></script>
                        <br><br>
                        <div id="something"><div class="form-group" style="margin-top: 10% "><textarea style="width: 500px;" rows="3" id="announce" placeholder="Type in an announcment"></textarea><br><button class="btn-lg btn-primary" id="post" >Post!</button><div></div>
                        
                       
                        
                </div>
            </div>
        </div>
        <sub><span id="foot" style="margin-left: 46%;position: relative "></span></sub>
    </div>
        <script src="js/menu_1.js"></script> 
        <script>
            getDetails();
            
             
           function togglePost(toggle)
            {
                if(toggle === 1)
                    $('#post').prop("disabled", false);
                else if (toggle === 0)
                    $('#post').prop("disabled", true);
            }
            
            $('#announce').keyup(function(){
                if(this.value === "")
                {
                    togglePost(0);
                }
                else
                {
                    togglePost(1);
                }
            });
//            
            $('#post').click(function (){
                
                 $.ajax({
                    type: "POST",
                    url: "addAnnouncement.php",
                    data: { des: document.getElementById("announce").value
                            
                            },
                    cache: false,
                    success: function(result){
                    if(result ==="done")    
                    {
                        alert("POSTED!");
                        window.location.href = "welcome.php";
                    }
                    else{
                        alert(result);

                    }
               }
            });
           });
       
            
        </script>
    </body>
</html>
