<!DOCTYPE html>
<html>
    <head>
        <title>BNU RCMS</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
       <script src="js/jquery.min_2.js"></script>
       <style>
           .box
           {
               height: 700px;
           }
           
           .innerBox
           {
               height: 90%;
               overflow:hidden;
           }
           
           
#marqueecontainer{
position: relative;
width: 600px; /*marquee width */
height: 626px; /*marquee height */
background-color: white;
overflow: hidden;

padding: 2px;
padding-left: 4px;
}

           
           
       </style>
       <script type="text/javascript">//open source scroller thing

                    /***********************************************
                    * Cross browser Marquee II- � Dynamic Drive (www.dynamicdrive.com)
                    * This notice MUST stay intact for legal use
                    * Visit http://www.dynamicdrive.com/ for this script and 100s more.
                    ***********************************************/

                    var delayb4scroll=2000 //Specify initial delay before marquee starts to scroll on page (2000=2 seconds)
                    var marqueespeed=2 //Specify marquee scroll speed (larger is faster 1-10)
                    var pauseit=1 //Pause marquee onMousever (0=no. 1=yes)?

                    ////NO NEED TO EDIT BELOW THIS LINE////////////

                    var copyspeed=marqueespeed
                    var pausespeed=(pauseit==0)? copyspeed: 0
                    var actualheight=''

                    function scrollmarquee(){
                    if (parseInt(cross_marquee.style.top)>(actualheight*(-1)+8)) //if scroller hasn't reached the end of its height
                    cross_marquee.style.top=parseInt(cross_marquee.style.top)-copyspeed+"px" //move scroller upwards
                    else //else, reset to original position
                    cross_marquee.style.top=parseInt(marqueeheight)+8+"px"
                    }

                    function initializemarquee(){
                    cross_marquee=document.getElementById("vmarquee")
                    cross_marquee.style.top=0
                    marqueeheight=document.getElementById("marqueecontainer").offsetHeight
                    actualheight=cross_marquee.offsetHeight //height of marquee content (much of which is hidden from view)
                    if (window.opera || navigator.userAgent.indexOf("Netscape/7")!=-1){ //if Opera or Netscape 7x, add scrollbars to scroll and exit
                    cross_marquee.style.height=marqueeheight+"px"
                    cross_marquee.style.overflow="scroll"
                    return
                    }
                    setTimeout('lefttime=setInterval("scrollmarquee()",30)', delayb4scroll)
                    }

                    if (window.addEventListener)
                    window.addEventListener("load", initializemarquee, false)
                    else if (window.attachEvent)
                    window.attachEvent("onload", initializemarquee)
                    else if (document.getElementById)
                    window.onload=initializemarquee


</script>

       <script type="text/javascript">
           
           function getMsgs()
           {
               
              $.ajax({
                  type: 'POST',
                  url: "scrollerData.php",
                  dataType: 'json',
                  cache: false,
                  success: function (data) {

                        jQuery.each(data, function(index, items) {
                            $("#vmarquee").append("<div class='well' style='width: 525px'><b>"+items+"</b></div>");
                    });
                    }
                    
              });
           }
           
           function checkClassError(obj)
    {
        if(obj.className.match(/(?:^|\s)has-error(?!\S)/))
            return true;
        else
            return false;
    }
        
            
            function togglePass(feild)
            {
                if(feild === 0)
                {                    
                    $('#pass').prop("disabled", true);
                    
                    document.getElementById("pwd").innerHTML="";
                    
                    par.className="form-group";
                    toggleSubmit(0);
                }
                else if(feild === 1)
                    $('#pass').prop("disabled", false);
                    
            }
            
            function toggleSubmit(input)
            {
                if(input === 0){                    
                    $('#login').prop("disabled", true);
                }
                else if(input === 1)
                    $('#login').prop("disabled", false);
            }
            
            var main = function(){
                
           $("#username").keyup(function (){
               
               user = document.getElementById("username").value;
               
               par = document.getElementById("usr").parentNode;
               
               if(user === "")
               {
                   document.getElementById("usr").innerHTML="enter username";
                   
                    if(!checkClassError(par))
                        par.className+=" has-error";
                    
                    togglePass(0);
               }
               else
               {
                   $.ajax({
                        type: "POST",
                        url: "login.php",
                        data: { user: document.getElementById("username").value
                            },
                        cache: false,
                        success: function(result){
                            if(result === "found")
                            {
                                document.getElementById("usr").innerHTML="";
                                par.className="form-group has-success";
                                togglePass(1);
                            }
                            else
                            {
                                document.getElementById("usr").innerHTML=result;
                               
                                if(!checkClassError(par))
                                    par.className+=" has-error";
                                togglePass(0);
                            }
                            }
                        });
            }
               
           });
           
           $("#pass").keyup(function (){
               
               pass = document.getElementById("pass").value;
               
               par = document.getElementById("pass").parentNode;
               
               if(pass === "")
               {
                   document.getElementById("pwd").innerHTML="enter password";
                   
            if(!checkClassError(par))
                par.className+=" has-error";
            
            toggleSubmit(0);
                }
               else
               {
                   $.ajax({
        type: "POST",
        url: "login.php",
        data: { user: document.getElementById("username").value,
                pass: document.getElementById("pass").value
            },
        cache: false,
        success: function(result){
            if(result === "found")
            {
                document.getElementById("pwd").innerHTML=result;
                par.className="form-group has-success";
                
                toggleSubmit(1);
            }
            else
            {
                document.getElementById("pwd").innerHTML="wrong password";
                if(!checkClassError(par))
                    par.className="form-group has-error";
                
                toggleSubmit(0);
            }
        }
    });
              
                    
               }
               
           });

            };
           $(document).ready(main);
       </script>
    </head>
    <body>
        <?php
            if(isset($_SESSION['user']))
                 header("Location: index.php");
        ?>
        <nav class="navbar navbar-inverse ">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="pull-left" href="#"><img src="images/bnulogo.webp" height="70" style="padding: 2px"></a>
                </div>
                
                <p class="navbar-text" style="font-size: 20px">Complaint/Request Management System</p>
                
               
                
            </div>
        </nav>
               
        <div class="container">
            <div class='row' style=" border-width: 2px; border-style: solid">
                <div class="col-md-7" style="background-color: #cac9c9" >
                    <br/>
                    <div class="row box" >                       
                        
                        <div class="col-sm-1">
                        </div>
                        
                        <div class="col-sm-10 innerBox" style="background-color: white;border-style: solid;border-width: 1px">
                            
                           <div id="marqueecontainer" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">
                            <div id="vmarquee"  style="position: absolute; width: 100%;">
                            </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                
                <div class="col-md-5 " style="background-color: #cac9c9;">
                    <br/>    
                    <div class="row box" >
                        <div class="col-sm-1">
                        </div>
                        
                        <div class="col-sm-10 innerBox" style="background-color: whitesmokee">
                            <form method="post" action="welcome.php">
                                <div class="form-group">
                                    <label for="username" class="control-label">Username:</label>
                                    <input type="text" class="form-control" placeholder="Roll# or Faculy ID" name="roll" id="username">
                                    <span id="usr" class="help-block"></span>
                                </div>    
                                
                                <div class="form-group">
                                    <label for="pass" class="control-label">Password</label>
                                    <input type="password" class="form-control" placeholder="Password" id="pass" name='pass' disabled="disabled">
                                    <span class="help-block" id="pwd"></span>
                                </div>    
                                
                                
                                
                                <button type="submit" class="btn btn-default" disabled="disabled" id="login">Log-in</button>
                                                       
                            </form>
                            
                            <br/>
                             <a href="Forgot.php">Forgot Password.</a>
                            <p>First time visiting this site? <a href="CreateAccount.html">Sign up.</a></p>
                        </div>
                    </div>
                    
                </div>
            </div>  
        </div>
        <script type="text/javascript">
            getMsgs();
        </script>
    </body>
</html>
