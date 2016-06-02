<!DOCTYPE html>
<html>
    <head>
        <title>New Submission</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="css/menu.css" type="text/css">
        <script src="js/jquery.min_2.js"></script>
        <?php
        require_once './classes/student.php';
        require_once './classes/faculty.php';
        session_start();
        require_once './classes/user.php';

        if(!isset($_SESSION['user']))
        {
            header("Location: index.php");
        }
        else
        {
        $user= $_SESSION['user'];
        $mode = $_SESSION['mode'];
        }
        ?>
        
        <script type="text/javascript">
           
         var main = function(){  
            $('#submit').click(function (){
                
        $.ajax({
        type: "POST",
        url: "c-rData.php",
        data: { cat: document.getElementById("cat").value,
                resp: document.getElementById("resp").value,
                des: document.getElementById("des").value,
                sub: document.getElementById("subj").value,
                ath: document.getElementById('imgSRC').innerHTML
               
            },
        cache: false,
        success: function(result){
        if(result ==="Entry successful")    
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
   
    $('#upload').on('click', function() {
        //alert();
    var file_data = $('#sortpicture').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    alert(form_data);                             
    $.ajax({
                url: 'uploadImage.php', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(data)
                {   name=data;
                    
                    document.getElementById('uploaded').src="uploads/"+name;
                    document.getElementById('imgSRC').innerHTML="uploads/"+name;
                }
     });
});
    
    
    
    };
    
    function getRecipients()
    {
         $.ajax({
        type: "POST",
        url: "c-rData.php?resp",
        cache: false,
        success: function(result){
            document.getElementById('resp').innerHTML=result;
        }
    });
    }
    
    $(document).ready(main);
            
        </script>
    </head>
    <body>
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
            <?php 
            if($mode === "faculty")
            {
            echo '<span class="glyphicon glyphicon-envelope student" aria-hidden="true" style="top: 285px;"></span>';
            }
            ?>
            <span class="glyphicon glyphicon-send " aria-hidden="true" style="top: 181px;"></span>
            <span class="glyphicon glyphicon-repeat " aria-hidden="true" style="top: 235px;"></span>
        </div>
        
        <div class="menu">
        <br/><br/>
        <ul>
             <li><a href="welcome.php">Home</a></li> 
            <li><a href="ViewSent.php">Sent</a></li>
            <li><a href="ViewResponses.php">Responses</a></li>
            <?php 
            if($mode === "faculty")
            {
                echo '<li class="student"><a href="ViewRecieved.php">Received</a></li>';
            }
            ?>
        </ul>
        </div>
       </div>
       
        <br/>
        
        <div class="container">
            <div class="main">
                <div class="panel panel-primary">
                    <div class="panel-heading" style="text-align: center"><h4>New Complaint</h4></div>
                    <div class="panel-body">
                        <div class="form-group form-inline">
                            <br/>
                            <div class="form-group" style="margin-left: 12% ">
                                <label>Name:</label>
                                
                                 <input type="text" placeholder="<?php echo $user->getName();?>" class="form-control" id="name" readonly>
                                 <?php
                                 if($mode === "student")
                                 {
                                     echo '<label>Roll Number:</label>';
                                     echo '<input type="text" placeholder="'.$user->getRoll().'" class="form-control" id="roll" readonly>';
                                     echo '<label>Program:</label>';
                                     echo '<input type="text" placeholder="'.$user->getDept().'" class="form-control" id="dept" readonly>';
                                 }
                                 else
                                 {
                                     echo '<label>ID:</label>';
                                     echo '<input type="text" placeholder="'. $user->getId().'" class="form-control" id="roll" readonly>';
                                     echo '<label>Department:</label>';
                                     echo '<input type="text" placeholder="'.$user->getDept().'" class="form-control" id="dept" readonly>';
                                 }
                                 ?>
                                 
                                 
                            </div>
                            
                            <br/><br/>
                            
                             <div class="form-group" style="margin-left: 27% ">
                                    <label >Type:</label>
                                    <?php
                                    if($_GET['type'] === "request")
                                    {
                                        echo '<select class="form-control" id="cat">
                                            <option disabled hidden>Select</option>
                                            <option >Complaint</option>
                                            <option selected>Request</option>
                                        </select>';
                                    }
                                    elseif($_GET['type'] === "complaint")
                                    {
                                        echo '<select class="form-control" id="cat">
                                            <option disabled hidden>Select</option>
                                            <option selected>Complaint</option>
                                            <option >Request</option>
                                        </select>';
                                    }
                                    ?>        
                                            &nbsp;&nbsp;
                                    <label>Recipient</label>
                                    <select id="resp" class="form-control">
                                            
                                    </select>
                                     <br/><br/>
                                     <label>Subject:</label>
                                     <input type="text" class="form-control" style="width: 441px" placeholder="Subject" id="subj"><span id="imgSRC" style="visibility: hidden"></span>
                            </div>
                           
                            <br/><br/><br/>
                            <div class="form-group">
                                    <label>Give details:</label>
                                    <br/>
                                    <textarea style="width: 600px ;float: left;" rows="15" id="des" ></textarea>                                                              <img id="uploaded" src="" style="margin-left: 30px;" width="100" height="100">
                            </div>
                            
                            <div class='form-group'>
                            <input class="form-control" id="sortpicture" type="file" name='fime' accept="image/x-png, image/gif, image/jpeg">
                            <button id="upload" class="btn btn-primary">upload</button>
                            </div>
                            <br/>
                            
                            </div>
                        <button class="btn btn-primary btn-lg" style="margin-left: 48% " id="submit">Send!</button>
                    </div>
                    
                </div>
            </div>
        </div>
        <script src="js/jquery.min_2.js"></script>
        <script src="js/menu.js"></script> 
        <script type="text/javascript">getRecipients();</script>
    </body>
</html>
