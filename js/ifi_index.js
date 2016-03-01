
/*
 * 
 * Popup div handler
 */
jQuery(function ($) {

    $("a#newclient").click(function () {
        loading(); // loading
        setTimeout(function () { // then show popup, deley in .5 second
            loadPopup(); // function show popup
        }, 100); // .5 second
        return false;
    });

    /* event for close the popup */
    $("div.close").hover(
            function () {
                $('span.esc_tooltip').show();
            },
            function () {
                $('span.esc_tooltip').hide();
            }
    );

    $("div.close").click(function () {
        disablePopup();  // function close pop up
    });

    $(this).keyup(function (event) {
        if (event.which === 27) { // 27 is 'Ecs' in the keyboard
            disablePopup();  // function close pop up
        }
    });

    $("div#backgroundPopup").click(function () {
        // disablePopup();  // function close pop up
    });

//    $('a.livebox').click(function() {
//        alert('Hello World!');
//        return false;
//    });

    /************** start: functions. **************/
    function loading() {
        $("div.loader").show();
    }
    function closeloading() {
        $("div.loader").fadeOut('normal');
    }

   // var popupStatus = 0; // set value

    function loadPopup() {
       // if (popupStatus === 0) { // if value is 0, show popup
        if ($("#popup-wrapper").css("display")==='none'){
            closeloading(); // fadeout loading
            $("#popup-wrapper").fadeIn(0500); // fadein popup div
            $("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
            $("#backgroundPopup").fadeIn(0001);
           // popupStatus = 1; // and set value to 1
        }
    }

    function disablePopup() {
        //if (popupStatus === 1) { // if value is 1, close popup
       if ($("#popup-wrapper").css("display")==='block'){
            $("#popup-wrapper").fadeOut("normal");
            $("#backgroundPopup").fadeOut("normal");
            //popupStatus = 0;  // and set value to 0
            window.location.replace("home.php");
        }
    }
    /************** end: functions. **************/
}); // jQuery End


$(document).ready(function () {
   
    //$("div.loader").hide();
//form validation rules
    $.validator.addMethod("isName", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9 \-\_\u4e00-\u9eff]*$/.test(value);
    }, 'Only allowed alphabet .');

    $.validator.addMethod("isText", function (value, element) {
        //return this.optional(element) || /^[a-zA-Z]* or ^\D*$/.test(value);
         return this.optional(element) || (/^[^0-9]*$/.test(value));
    }, "请正确填写项目名称。");
    // validate edit form on keyup and submit
    $("#newClientForm").validate({
        rules: {
            name: {
                required: true,
                isName: true
                //isText: true
            },
            contact: {
                required: false
                //minlength: 1
            },
            phone: {
                required: false
            }
        },
        messages: {
            name: "请输入客户名称",
            contact: "输入联系人名称.",
            phone: "输入联系人电话."
        }
    });
});


$(document).ready(function () {
    var newClientOptions = {
        target: '#newClientOutput', // target element(s) to be updated with server response 
        beforeSubmit: b4SubNewClient, // pre-submit callback 
        success: afterSucNewClient, // post-submit callback 
        resetForm: true        // reset the form after successful submit 
    };

    $('#newClientForm').submit(function () {
        $(this).ajaxSubmit(newClientOptions);
        // always return false to prevent standard browser submit and page navigation 
        return false;
    });

//    var bookSelectFormOptions ={
//        target: null, // target element(s) to be updated with server response 
//        beforeSubmit: null, // pre-submit callback 
//        success: null, // post-submit callback 
//        resetForm: false        // reset the form after successful submit 
//    };
//    
//    $('#bookSelectForm').submit(function(){
//         $(this).ajaxSubmit(bookSelectFormOptions);
//        // always return false to prevent standard browser submit and page navigation 
//        return false;
//    });
});



function afterSucNewClient()
{
    $('#submit-btn').show(); //hide submit button
    $('#loading-img').hide(); //hide submit button

}

//function to check file size before uploading.
function b4SubNewClient() {
    $('#submit-btn').hide(); //hide submit button
    $('#loading-img').show(); //hide submit button
    $("#output").html("");
}