//update name
$("#updateUsernameForm").submit(function(event){
    //prevent default php processing
    event.preventDefault();

    //collect user input
    var dataToPost = $(this).serializeArray();

    //send to php using AJAX call
    $.ajax({
        url: "updatename.php",
        type: "POST",
        data: dataToPost,
        success: function(data){
            if(data){
                $("#updateUsernameMsg").html(data);
            }else
            {
                location.reload();
            }
        },
        error: function(){
            $("#updateUsernameMsg").html("<div class='alert alert-danger'>Error with AJAX Call. Please, try again later</div>");
        }
    });
})


//update pswd
$("#updatePswdForm").submit(function(event){
    //prevent default php processing
    event.preventDefault();

    //collect user input
    var dataToPost = $(this).serializeArray();

    //send to php using AJAX call
    $.ajax({
        url: "updatepswd.php",
        type: "POST",
        data: dataToPost,
        success: function(data){
            if(data){
                $("#updatePswdMsg").html(data);
            }
        },
        error: function(){
            $("#updatePswdMsg").html("<div class='alert alert-danger'>Error with AJAX Call. Please, try again later</div>");
        }
    });
})

//update email
$("#updateEmailForm").submit(function(event){
    //prevent default php processing
    event.preventDefault();

    //collect user input
    var dataToPost = $(this).serializeArray();

    //send to php using AJAX call
    $.ajax({
        url: "updatemail.php",
        type: "POST",
        data: dataToPost,
        success: function(data){
            if(data){
                $("#updateEmailMsg").html(data);
            }
        },
        error: function(){
            $("#updateEmailMsg").html("<div class='alert alert-danger'>Error with AJAX Call. Please, try again later</div>");
        }
    });
})