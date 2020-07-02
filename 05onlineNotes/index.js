//AJAX cal for signup form
//after submitted
$("#signupForm").submit(function(event){
    //prevent default php processing
    event.preventDefault();

    //collect user input
    var dataToPost = $(this).serializeArray();

    //send to php using AJAX call
    $.ajax({
        url: "signup.php",
        type: "POST",
        data: dataToPost,
        success: function(data){
            if(data){
                $("#signupMsg").html(data);
            }
        },
        error: function(){
            $("#signupMsg").html("<div class='alert alert-danger'>Error with AJAX Call. Please, try again later</div>");
        }
    });
})


//login form call
$("#loginForm").submit(function(event){
    //prevent default php processing
    event.preventDefault();

    //collect user input
    var dataToPost = $(this).serializeArray();

    //send to php using AJAX call
    $.ajax({
        url: "login.php",
        type: "POST",
        data: dataToPost,
        success: function(data){
            if(data == "success"){
                window.location = "loggedInPage.php";
            }else{
                //if error print error
                $("#loginMsg").html(data);
            }
        },
        error: function(){
            $("#loginMsg").html("<div class='alert alert-danger'>Error with AJAX Call. Please, try again later</div>");
        }
    });
})


//fgt form call
$("#forgotForm").submit(function(event){
    //prevent default php processing
    event.preventDefault();

    //collect user input
    var dataToPost = $(this).serializeArray();

    //send to php using AJAX call
    $.ajax({
        url: "forgotpswd.php",
        type: "POST",
        data: dataToPost,
        success: function(data){
            $("#forgotMsg").html(data);
        },
        error: function(){
            $("#forgotMsg").html("<div class='alert alert-danger'>Error with AJAX Call. Please, try again later</div>");
        }
    });
})