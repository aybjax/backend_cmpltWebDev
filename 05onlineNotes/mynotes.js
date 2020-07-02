$(function(){
    //define variables
    var activeNote = 0; //id of note to write
    var editMode = false; //edit mode on?
    //ajax call to load notes to page
    $.ajax({
        url: "loadnotes.php",
        success: function(data)
        {
            $("#notes").html(data);
            clickOnNote();
            clickOnDelete();
        },
        error: function()
        {
            $("#alertMsg").text("Issue with AJAX call");
            $("#alert").removeClass("collapse").fadein();
        }
        
    })

    //add notes
    $("#addNote").click(function(){
        $.ajax({
            url:"createnote.php",
            success:function(data)
            {
                if(data=="error")
                {   //if error
                    $("#alertMsg").text("Issue with creation of notes into database");
                    $("#alert").removeClass("collapse").fadein();
                }else
                {   //creating note
                    activeNote = data;
                    $("textarea").val("");
                    //show hide elements
                    showHide(["#allNotes", "#notePad"], ["#notes", "#addNote", "#edit", "#done"]);
                    $("textarea").focus();
                }
            },
            error: function()
            {
                    $("#alertMsg").text("Issue with AJAX call");
                    $("#alert").removeClass("collapse").fadein();
                    window.alert("Issue with AJAX call");
            }
        })
    })


    //return on clicking all notes
    $("#allNotes").click(function(){
        //load notes as before
        $.ajax({
            url: "loadnotes.php",
            success: function(data)
            {
                $("#notes").html(data);
                clickOnNote();
                clickOnDelete();
            }
            
        })

        //shoHide
        showHide(["#notes", "#addNote", "#edit"], ["#allNotes", "#notePad", "#done"]);
    })


    //typing notes
    $("textarea").keyup(function(){
        //ajax call to update note
        $.ajax({
            url: "updatenote.php",
            type: "POST",
            //send current note with id to php file
            data:
            {
                note: $(this).val(),
                id: activeNote
            },
            success: function(returned)
            {   //do nothing if success
                if(returned == 'error')
                {
                    $("#alertMsg").text("Issue with updating the note...");
                    $("#alert").removeClass("collapse").fadein();
                    window.alert("Issue with updating the note...");
                }
            },
            error: function(){
                $("#alertMsg").text("Issue with AJAX call");
                $("#alert").removeClass("collapse").fadein();
                window.alert("Issue with AJAX call");
            }
        })
    })

    //editing mode
    $("#edit").click(function(){
        //switch to edit mode
        editMode = true;
        //reduce width of notes
        $(".note").addClass("col-xs-7 col-sm-9");
        
        showHide(["#done", ".delete"],[this]);
    })

    //done btn
    $("#done").click(function()
    {
        editMode=false;
        $(".note").removeClass("col-xs-7 col-sm-9");
        showHide(["#edit"], [".delete", this]);
    })










    //click on delete
    function clickOnDelete()
    {
        $(".delete").click(function()
        {
            //div of clicked button
            var deleteBtn = $(this);
            //ajax call to delete btn
            $.ajax({
                url: "deletenote.php",
                type: "POST",
                //send current note with id to php file
                data:
                {
                    id: deleteBtn.next().attr("id")
                },
                success: function(returned)
                {   //do nothing if success
                    if(returned == 'error')
                    {
                        $("#alertMsg").text("Issue with deleting the note...");
                        $("#alert").removeClass("collapse").fadein();
                        window.alert("Issue with deleting the note...");
                    }else
                    {
                        //remove containing div
                        deleteBtn.parent().remove();
                    }
                },
                error: function(){
                    $("#alertMsg").text("Issue with AJAX call");
                    $("#alert").removeClass("collapse").fadein();
                    window.alert("Issue with AJAX call");
                }
            })
        });
    }


    //used fnxs
    function showHide(show, hide)
    {
        for(i=0; i<show.length; i++)
        {
            $(show[i]).show();
        }
        for(i=0; i<hide.length; i++)
        {
            $(hide[i]).hide();
        }
    }

    //open note contents
    function clickOnNote()
    {
        $(".note").click(function(){
            if(!editMode)
            {
                activeNote = $(this).attr("id");
                //fill textarea
                $("textarea").val(
                    $(this).find(".text").text()
                );
                //showHide
                showHide(["#allNotes", "#notePad"], ["#notes", "#addNote", "#edit", "#done"]);
            }
        })
    }
})