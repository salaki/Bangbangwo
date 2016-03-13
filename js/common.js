function isEmailAddress(str) {
    var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return pattern.test(str);  // returns a boolean 
}
function emailExists()
{
    $.ajax({
        url: 'ajax/commonAjax.php?email',
        type: 'POST',
        data: $('form').serialize(),
        success: function (msg) {
            if (msg == 'true')
            {
                $('#email').css('border-color', 'red');
                $('#email-msg').html('E-Mail Already Exists...').show();
                return 'already';
            }
            else
            {
                $('#email').css('border-color', 'None');
                $('#email-msg').html('Please Enter Your Valid E-Mail Address').hide();
            }
        }


    });
}
function validation()
{
    var error = 0;
    var field = '';
    $('.login-error').hide();
    $('form input').each(function () {
        field = $(this).attr('id');
        //alert($(this).attr('id'));
        field = field + '-msg';
        if ($(this).val() == '')
        {

            $("#" + field).show();
            $(this).css('border-color', 'red');
            error += 1;
        }
        else {
            $("#" + field).hide();
            $(this).css('border-color', 'none');
        }
        field = '';
    });

    if (!isEmailAddress($('#email').val()))
    {
        $('#email').css('border-color', 'red');
        error += 1;
    }



    if ($('#pass').val() != '')
    {
        if ($('#pass').val().length < 6)
        {
            $('#pass').css('border-color', 'red');
            $('#pass-msg').html('Password must be 6 Charecters').show();
            error += 1;
        }
        else
        {
            $('#pass').css('border-color', 'none');
            $('#pass-msg').html('Please Enter Password').hide();
        }
    }
    if ($('#cpass').val() != '')
    {
        if ($('#pass').val() != $('#cpass').val())
        {
            $('#cpass').css('border-color', 'red');
            $('#pass-msg').html('Password does not match').show();
            error += 1;
        }
        else
        {
            $('#cpass').css('border-color', 'none');
            $('#cpass-msg').html('Please Re-Enter Password').hide();
        }
    }
    if ($('#contact').val() == '' || $('#contact').val().length < 12)
    {
        if ($('#contact').val().length > 1)
        {
            $('#contact-msg').html('Phone Number should be look like 123-456-7890');
        }
        else
        {
            $('#contact-msg').html('Please Enter a Valid Phone Number');
        }
        $('#contact-msg').show();

        $('#contact').css('border-color', 'red');
        error = 1;
    }
    if ($('#pass').val() != $('#cpass').val())
    {
        error += 1;
    }
    if (error > 0)
        return false;
    else
        emailExists();
}
function validation_new(type)
{
    var fname = $('#name').val();
    var lname = $('#lname').val();
    var email = $('#email').val();
    var invitation = $('#register').val();
    var linkedin = $('#linkedin').val();
    var contact = $('#contact').val();
    var pass = $('#pass').val();
    var cpass = $('#cpass').val();
    var splited_email = email.split(".");
    var last_str = splited_email[splited_email.length - 1];


    var t = true;
    if (fname == '')
    {
        $('#name').css('border-color', 'red');
        $('#name-msg').show();
        t = false;
    }
    else
    {
        $('#name').css('border-color', 'none');
        $('#name-msg').hide();
    }
    if (lname == '')
    {
        $('#lname').css('border-color', 'red');
        $('#lname-msg').show();
        t = false;
    }
    else
    {
        $('#lname').css('border-color', 'none');
        $('#lname-msg').hide();
    }
    if (email == '')
    {
        $('#email').css('border-color', 'red');
        $('#email-msg').html('Please Enter Your E-Mail Address').show();
        t = false;
    }
    else if (!isEmailAddress($('#email').val()))
    {
        $('#email').css('border-color', 'red');
        $('#email-msg').html('Please Enter Valid E-Mail Address').show();
        t = false;
    }
    else if(last_str!='edu'){
     $('#email').css('border-color','red');
     $('#email-msg').html('Please Enter an University E-Mail Address').show();                
     t=false;
     }
    /*else if(invitation == ''){
     $('#register').css('border-color','red');
     $('#register-msg').html('Please Enter Registration Code').show();                
     t=false;
     }*/
    else if (emailExists() == 'already' && email != '')
    {
        t = false;
    }
    else
    {
        $('#email').css('border-color', 'none');
        $('#email-msg').hide();

    }


    if (type == 'tasker')
    {
        if (contact == '' || contact.length < 12)
        {
            if (contact.length > 1)
            {
                $('#contact-msg').html('Phone Number should be look like 123-456-7890');
            }
            else if (contact == '')
            {
                $('#contact-msg').html('Please Enter Your Phone Number');
            }
            else
            {
                $('#contact-msg').html('Please Enter a Valid Phone Number');
            }
            $('#contact-msg').show();
            $('#contact').css('border-color', 'red');
            t = false;
        }
        else
        {
            $('#contact').css('border-color', 'none');
            $('#contact-msg').hide();
        }
    }
//    if (invitation == '')
//    {
//        $('#register').css('border-color', 'red');
//        $('#register-msg').show();
//        t = false;
//    }
//    else if (invitation != 'LEBIU2015')
//    {
//        $('#register-msg').html('Please Enter a Valid  Registration Code').show();
//        $('#register').css('border-color', 'red');
//        t = false;
//    }
//    else
//    {
//        $('#register').css('border-color', 'none');
//        $('#register-msg').hide();
//    }

    if (pass == '')
    {
        $('#pass-msg').html('Please Enter Password').show();
        $('#pass').css('border-color', 'red');
        t = false;
    }
    else
    {
        $('#pass').css('border-color', 'none');
        $('#pass-msg').hide();
    }
    if (pass.length < 6)
    {
        $('#pass-msg').html('Password must be 6 Charecters').show();
        $('#pass').css('border-color', 'red');
        t = false;
    }
    else
    {
        $('#pass').css('border-color', 'none');
        $('#pass-msg').hide();
    }
    if (cpass == '')
    {
        $('#cpass-msg').html('Please Enter Re-Password').show();
        $('#cpass').css('border-color', 'red');
        t = false;
    }
    else
    {
        $('#cpass').css('border-color', 'none');
        $('#cpass-msg').hide();
    }
    if (cpass.length < 6)
    {
        $('#cpass-msg').html('Password must be 6 Charecters').show();
        $('#cpass').css('border-color', 'red');
    }
    else
    {
        $('#cpass').css('border-color', 'none');
        $('#cpass-msg').hide();
        if (pass != cpass)
        {
            $('#pass-msg').html('Password does not match').show();
            $('#pass').css('border-color', 'red');
            $('#cpass-msg').html('Password does not match').show();
            $('#cpass').css('border-color', 'red');
            t = false;
        }
        else
        {
            $('#pass,#cpass').css('border-color', 'none');
            $('#pass-msg,#cpass-msg').hide();
        }
    }

    if (t == false)
    {

        return false;
    }
}


function validation_rqst()
{
    var error = 0;
    var field = '';
    $('.login-error').hide();
    $('form input').each(function () {
        field = $(this).attr('id');
        //alert($(this).attr('id'));
        field = field + '-msg';
        if ($(this).val() == '')
        {

            $("#" + field).show();
            $(this).css('border-color', 'red');
            error += 1;
        }
        else {
            $("#" + field).hide();
            $(this).css('border-color', 'none');
        }
        field = '';
    });

    if (!isEmailAddress($('#email').val()))
    {
        $('#email').css('border-color', 'red');
        error += 1;
    }
    if ($('#pass').val() != '')
    {
        if ($('#pass').val().length < 6)
        {
            $('#pass').css('border-color', 'red');
            $('#pass-msg').html('Password must be 6 Charecters').show();
            error += 1;
        }
        else
        {
            $('#pass').css('border-color', 'none');
            $('#pass-msg').html('Please Enter Password').hide();
        }
    }
    if ($('#cpass').val() != '')
    {
        if ($('#pass').val() != $('#cpass').val())
        {
            $('#cpass').css('border-color', 'red');
            $('#pass-msg').html('Password does not match').show();
            error += 1;
        }
        else
        {
            $('#cpass').css('border-color', 'none');
            $('#cpass-msg').html('Please Re-Enter Password').hide();
        }
    }
    if ($('#pass').val() != $('#cpass').val())
    {
        error += 1;
    }
    if (error > 0)
        return false;
    else
        emailExists();
}

function showForm(id)
{
    var i = 1;
    for (i = 1; i <= 5; i++)
    {
        $('#tskfrm-' + i).hide();
        $('input[type=text]').css('border-color', 'none');
    }
    $('input[type=text]').css('border-color', 'none');
    $('#' + id).show();
}
function frgtpass()
{
    var error = 0;
    if (!isEmailAddress($('#email1').val()) || $('#email1').val() == '')
    {
        $('#email1').css('border-color', 'red');
        error += 1;
    }
    else
    {
        $('#email1').css('border-color', 'none');
    }
    if (error == 0)
    {
        $.ajax({
            url: 'ajax/commonAjax.php?email=' + $('#email1').val(),
            type: 'GET',
            success: function (msg) {
                if (msg == 'false')
                {
                    $('#email1').css('border-color', 'red');
                    $('#email-msg1').html('Please Enter a Registered E-Mail...').show();
                    error += 1;
                    //alert();
                }
                else
                {
                    $('#confrmMsg').show();
                    $.ajax({
                        url: 'ajax/commonAjax.php?frgtemail=' + $('#email1').val(),
                        type: 'GET',
                        success: function (msg1) {
                            alert(msg1);
                        }
                    });
                    $('#email1').css('border-color', 'None');
                    $('#email1,#frgtPass').hide();

                }
            }


        });
    }
    if (error > 0)
        return false;
}
function submitTask(id, fid)
{

    var error = 0;
    $('#' + id + ' input').each(function () {
        if (($(this).val() == '' || $(this).val() == '0') && $(this).attr('name') != 'tdescription' && $(this).attr('name') != 'tother' && $(this).attr('name') != 'tpeople' && $(this).attr('name') != 'multi')
        {

            $(this).css('border-color', 'red');
            error += 1;

        }
        else {
            $(this).css('border-color', 'none');
        }
        /*if($('#'+id+' textarea').val() == '')
         {
         $('#'+id+' textarea').css('border-color','red');
         error += 1;
         }
         else
         $('#'+id+' textarea').css('border-color','none');*/
    });
    if (error == 0)
    {
        $('#hire-img' + fid).show();
        $.ajax({
            url: 'ajax/commonAjax.php?task',
            type: 'POST',
            data: $('#' + id).serialize(),
            success: function (msg) {
                $('#hire-img' + fid).hide();
                $('input[type=text]').val('');
                alert(msg);
                window.location = "dashboard.php";
            }
        });
    }
    return false;
}
function hideBid(id, pgno)
{
    $('#hire-bid-img' + id).show();
    $.ajax({
        url: 'ajax/commonAjax.php?action=hideBid&val=' + id,
        type: 'GET',
        success: function (msg) {
            $('#hire-bid-img' + id).hide();
            pagingAjax(this, 'ajax/mybids.php?page&page=' + pgno, 'showTopId');
        }
    });
}
function updateTask(id, fid)
{
    var error = 0;
    $('#' + id + ' input').each(function () {
        if ($(this).val() == '' && $(this).attr('name') != 'tdescription' && $(this).attr('name') != 'tother' && $(this).attr('name') != 'tpeople')
        {
            $(this).css('border-color', 'red');
            error += 1;
        }
        else {
            $(this).css('border-color', 'none');
        }
    });
    if (error == 0)
    {
        $('#hire-img' + fid).show();
        $.ajax({
            url: 'ajax/commonAjax.php?update',
            type: 'POST',
            data: $('#' + id).serialize(),
            success: function (msg) {
                $('#hire-img' + fid).hide();
                alert(msg);
                window.location = "dashboard.php";
            }
        });
    }
    return false;
}
function editProfile()
{
    var error = 0;

//	if($('#linkedin').val() == '')
//	{
//		$('#linkedin').css('border-color','red');
//		error =1;
//	}
//	else
//	{
//		$('#linkedin').css('border-color','none');
    //	}
    if ($('#contact').val() == '' || $('#contact').val().length < 12)
    {
        if ($('#contact').val().length > 1)
        {
            $('#contact-msg').html('Phone Number should be look like 123-456-7890');
        }
        else
        {
            $('#contact-msg').html('Please Enter a Valid Phone Number');
        }
        $('#contact-msg').show();
        $('#contact').css('border-color', 'red');
        error = 1;
    }
    else
        $('#contact').css('border-color', 'none');
    if ($('#oemail').val() != '' && !isEmailAddress($('#oemail').val()))
    {
        $('#oemail').css('border-color', 'red');
    }
    else {
        $('#oemail').css('border-color', 'none');
    }
    if (error > 0)
        return false;
}
function taskAction(id, tid, action, taskerid)
{

    var f = '';
    var t = 'GET';

    if (action == 'CancelTask')
    {
        if (taskerid != '' && $.isNumeric(taskerid)) {
            if (!confirm("Do you want to cancel this Hiring?"))
            {
                return false;
            }
        } else {
            if (!confirm("Do you want to cancel this request?"))
            {
                return false;
            }
        }
    }


    if (action == 'removeTask')
    {
        if (!confirm("Do you want to Delete this request?"))
        {
            return false;
        }
    }
    if (action == 'addBid')
    {

        if ($('#bid-amount' + tid).val() == '0')
        {
            alert("Please enter amount");
            return false;
        }
        if ($('#bid-amount' + tid).val() < parseInt(5))
        {
            alert("No bid lower than $5");
            return false;
        }

        f = $('#bid-slide' + tid + ' form').serialize();
        t = 'POST';
    }
    $('#bid-img' + tid).show();
    $('#remove-img' + tid).show();
    $('#bid-slide' + tid).slideUp('slow');

    if (taskerid === undefined || taskerid == "") {

        var posturl = 'ajax/commonAjax.php?action=' + action + '&taskid=' + tid;

    } else {
        var posturl = 'ajax/commonAjax.php?action=' + action + '&taskid=' + tid + '&taskerid=' + taskerid;
    }
    $.ajax({
        url: posturl,
        type: 'POST',
        data: f,
        success: function (msg) {
            if (action == 'addBid')
            {
                if (msg == 'error1') {
                    alert("Sorry, the task you bid on has been deleted.");
                    window.location.reload();
                    return false;
                } else {
                    alert("Your bid is successfully sent");
                }

                $('#bid-img' + tid).hide();
                $('#a-bid' + tid).attr('onclick', '').html('Request Sent');
                $.ajax({
                    url: 'ajax/bids-left.php',
                    type: 'GET',
                    success: function (msg) {

                        $('#taskercont1').html(msg);
                        $('#bid' + tid).hide();

                    }
                });


                //window.location = "/dashboard_tasker";

            }
            if (action == 'removeTask')
            {

                /*   $.ajax({
                 url:'/refund.php',
                 type:'POST',
                 data:{"tid":tid},
                 success:function(msg){
                 alert(msg);
                 }
                 }); */


                // alert(msg);

                $('#remove-img' + tid).hide();
                $('#' + id + tid).hide();
                alert('Task has been Removed');
                window.location = "/dashboard";

            }

            if (action == 'CancelTask')
            {

                 if (taskerid != '' && $.isNumeric(taskerid)) {
                      alert('This Hiring has been Canceled');
                 }else{
                      alert('Task has been Canceled');
                 }
               
                window.location = "/dashboard";

            }




        }
    });
}
function hireTask(id, tid, action, pgno)
{

    $('#hire-img' + id).show();
    //$('#hire-img'+id).fadeOut(1000);
    //$('#a-hire'+id).attr('onclick','').html('Hired');
    //$('#a-remove'+id).hide();
    $.ajax({
        url: 'ajax/commonAjax.php?action=' + action + '&taskid=' + tid + '&userid=' + id,
        type: 'GET',
        success: function (msg) {
            if (msg == 1) {
                if (!confirm("You have not added any payment method. Add Now !")) {
                    window.location = '/connect.php';
                    return false;
                } else {
                    window.location = '/connect.php';
                    return false;
                }
            }
            else if (msg != 'false')
            {
                $('#hire-img' + id).fadeOut(1000);
                $('#a-hire' + id).attr('onclick', '').html('Hired');
                $('#a-remove' + id).hide();
                pagingAjax(this, 'ajax/requests.php?page&page=' + pgno, 'showTopId');

            }
            else
            {
                alert("Task has been already assigned to other");
            }
        }
    });
}
function removeSingleBid(id, tid, pgno)
{
    var action = 'removeSingle';
    $('#hire-img' + id).show();
    $('#hire-img' + id).hide();
    $.ajax({
        url: 'ajax/commonAjax.php?action=' + action + '&taskid=' + tid + '&userid=' + id,
        type: 'GET',
        success: function (msg) {

            //$('#a-hire'+id).attr('onclick','').html('Hired');
            pagingAjax(this, 'ajax/requests.php?page&page=' + pgno, 'showTopId');

        }
    });
}
function rejectSingleBid(id, tid, pgno)
{
    var action = 'rejectSingle';
    $('#hire-img' + id).show();
    $.ajax({
        url: 'ajax/commonAjax.php?action=' + action + '&taskid=' + tid + '&userid=' + id,
        type: 'GET',
        success: function (msg) {

            $('#hire-img' + id).hide();
            //$('#a-hire'+id).attr('onclick','').html('Hired');
            var location = 'http://' + window.location.hostname + '/dashboard';
            window.location.href = location + "?page_no=" + pgno;

        }
    });
}
function satisfiedAction(bid, tid, status, pgno)
{
    var likes, dislikes;
    likes = $('#likeheart' + tid).html().trim();
    dislikes = $('#dislikeheart' + tid).html().trim();
    $('#hire-img' + tid).show();
  
    $.ajax({
        url: 'ajax/commonAjax.php?action=satisfiedAction&bid=' + bid + '&tid=' + tid + '&status=' + status,
        type: 'GET',
        success: function (msg) {

            $('#hire-img' + tid).hide();
            if (status == 0)
            {
                $('#like' + tid).hide();
                $('#dislike' + tid).attr('onclick', '');
                $('#dislike' + tid).css({'background-color': '#3071A9', 'color': '#fff'});
                $('#dislikeheart' + tid).html(parseInt(dislikes) + 1);
                pagingAjax(this, 'ajax/requests.php?page&page=' + pgno, 'showTopId');
            }
            else if (status == 1)
            {
                $('#dislike' + tid).hide();
                $('#like' + tid).attr('onclick', '');
                $('#like' + tid).css({'background-color': '#3071A9', 'color': '#fff'});
                $('#likeheart' + tid).html(parseInt(likes) + 1);
                pagingAjax(this, 'ajax/requests.php?page&page=' + pgno, 'showTopId');
            }
        }
    });


}
function onlyNumeric(event)
{
    /* if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 ))
     {
     event.preventDefault();
     
     }*/
}


