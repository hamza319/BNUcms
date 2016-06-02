<!DOCTYPE html>
<html>
    <head>
        <title>Forgot Password</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="css/menu.css" type="text/css">
        <script src="js/jquery.min_2.js"></script>
            <script type="text/javascript">
                
      feilds = [0,0,0];
    
    function checkFeilds(feild)
    {
     
        if(feild === 0)
            feilds[0]=1;
        else if(feild === 1)
            feilds[1]=1;
        else if(feild === 2)
            feilds[2]=1;
        
        

        
        if(feilds[0] === 1 && feilds[1] === 1 && feilds[2] === 1 )
            $('#submit').prop("disabled", false);
    }
        var main = function(){
                
                function checkClassError(obj)
    {
        if(obj.className.match(/(?:^|\s)has-error(?!\S)/))
            return true;
        else
            return false;
    }
    
            function toggleAns(feild)
            {
                if(feild === 0)
                {                    
                    $('#ans').prop("disabled", true);
                    
                }
                else if(feild === 1)
                    $('#ans').prop("disabled", false);
                    
            }
            
            function togglePass(feild)
            {
                if(feild === 0)
                {                    
                    $('#pass').prop("disabled", true);
                    $('#conPass').prop("disabled", true);
                    
                }
                else if(feild === 1)
                {
                    $('#pass').prop("disabled", false);
                    $('#conPass').prop("disabled", false);
                }
                    
            }
                
           $("#username").keyup(function (){
               
               user = document.getElementById("username").value;
               
               par = document.getElementById("usr").parentNode;
               
               if(user === "")
               {
                   document.getElementById("usr").innerHTML="enter username";
                   
                    if(!checkClassError(par))
                        par.className+=" has-error";
                    
                    toggleAns(0);
               }
               else
               {
                   $.ajax({
                        type: "POST",
                        url: "forgotPass.php",
                        data: { user: document.getElementById("username").value
                            },
                        cache: false,
                        success: function(result){
                            if(result !== "not found")
                            {
                                document.getElementById("usr").innerHTML="Username found";
                                document.getElementById('ques').innerHTML=result;
                                par.className="form-group has-success";
                                toggleAns(1);
                                checkFeilds(1);
                            }
                            else
                            {
                                document.getElementById("usr").innerHTML="Username not found";
                               
                                if(!checkClassError(par))
                                    par.className+=" has-error";
                                toggleAns(0);
                            }
                            }
                        });
            }
               
           });
           
           $("#ans").keyup(function (){
               
               pass = document.getElementById("ans").value;
               
               par = document.getElementById("ans").parentNode;
               
               if(pass === "")
               {
                   document.getElementById("ansl").innerHTML="Answer Question";
                   
            if(!checkClassError(par))
                par.className+=" has-error";
            
            togglePass(0);
                }
               else
               {
                   $.ajax({
        type: "POST",
        url: "forgotPass.php",
        data: { user: document.getElementById("username").value,
                ans: document.getElementById("ans").value
            },
        cache: false,
        success: function(result){
            if(result === "found")
            {
                document.getElementById("ansl").innerHTML="Corect Answer";
                par.className="form-group has-success";
                
                togglePass(1);
                checkFeilds(0);
            }
            else
            {
                document.getElementById("ansl").innerHTML="wrong answer";
                if(!checkClassError(par))
                    par.className="form-group has-error";
                
                togglePass(0);
            }
        }
    });
                     
    }
    });
    
    $("#conPass, #pass").keyup(function () {
        
    pass1=document.getElementById("pass").value;
    pass2=document.getElementById("conPass").value;
    
    par = document.getElementById("pass").parentNode;
    par=par.parentNode;
    
    if(pass1==="" || pass2==="")
    {
        document.getElementById("pasinfo").innerHTML="Password cannot be left blank";
        
        if(!checkClassError(par))
            par.className+=" has-error";
    }
    else if(pass1 !== pass2)
    {
        document.getElementById("pasinfo").innerHTML="passwords don't match";
        
            if(!checkClassError(par))
                par.className+=" has-error";
    }
    else
    {       
        document.getElementById("pasinfo").innerHTML="Passwords match";
        
        if(checkClassError(par))
        {
                par.className="form-group has-success";
        }
            
        checkFeilds(2);    
    }
});
    
    $('#submit').click(function(){
        $.ajax({
                        type: "POST",
                        url: "forgotPass.php?setPass",
                        data: { pass: document.getElementById("pass").value,
                                user: document.getElementById("username").value
                            },
                        cache: false,
                        success: function(result){
                            if(result === "done")
                            {
                                alert('Password Changed!');
                                window.location="index.php";
                            }
                            else
                            {
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
                <nav class="navbar navbar-inverse ">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="pull-left" href="index.php"><img src="images/bnulogo.webp" height="70" style="padding: 2px"></a>
                </div>
                
                <p class="navbar-text" style="font-size: 20px">Complaint/Request Management System</p>
                
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" style="font-size: 20px">About <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></li>
                </ul>
                
            </div>
        </nav>
        
        
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="text-align: center"><h4>Password Recovery</h4></div>
                        <div class="panel-body">
                            
                               <br/>
                                <div class="form-group">
                                    <label for="username" id="usr" class="control-label">Enter Username:</label>
                                    <input type="text" class="form-control" placeholder="Roll# or Faculy ID" name="roll" id="username">
                                </div>
                               <label class="h4" id="ansl">Answer Question</label>
                                    <p class="form-control-static" id="ques">This is later display the question?</p>
                                     <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Answer" id="ans" disabled="disabled">
                                     </div>
                                    
                                </div>
                                <br/>
                                
                                 <div class="form-group">
                                    <label for="pass">Enter desired password: 
                                        <input type="text" class="form-control" placeholder="Password" id="pass" disabled="disabled">
                                    </label>
                                    <label for="conPass">&nbsp;&nbsp;Confirm password:
                                    <input type="text" class="form-control" placeholder="Confirm" id="conPass" disabled="disabled">
                                    </label>
                                     <label class="help-block" id="pasinfo"></label>
                                </div>
                                <br/><br/>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" disabled="disabled" id="submit">Submit</button>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                                
                            
                        </div>
                        
                    </div>
                </div> 
                               
            </div>
        
        <script src="js/jquery.min_2.js"></script>
        <script src="js/menu.js"></script> 
    </body>
</html>

