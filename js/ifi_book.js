/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$(document).ready(function () {
    //$("div.loader").hide();

    $.validator.addMethod("isName", function (value, element) {
        return this.optional(element) || /^[a-zA-Z0-9 \-\_\u4e00-\u9eff]*$/.test(value);
    }, 'Only allowed alphabet .');

    $.validator.addMethod("isText", function (value, element) {
        return this.optional(element) || /^[a-zA-Z]* or ^\D*$/.test(value);
    }, 'Only allowed alphabet .');
    // validate edit form on keyup and submit
    $("#newBookForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 4,
                isName: true,
                isText: true
            }

        },
        messages: {
            name: "输入账本名称",
            minlength: "最少需要4个字"
        }
    });
});


$(document).ready(function () {
    var options = {
        target: '#newBookOutput', // target element(s) to be updated with server response 
        beforeSubmit: beforeSubmit, // pre-submit callback 
        success: afterSuccess, // post-submit callback 
        resetForm: true        // reset the form after successful submit 
    };

    $('#newBookForm').submit(function () {
        $(this).ajaxSubmit(options);
        // always return false to prevent standard browser submit and page navigation 
        return false;
    });
});



function afterSuccess()
{

    setTimeout(function () { // then show popup, deley in .5 second
        window.location.replace("manBook.php");
    }, 1000); // .5 second


}

//function to check file size before uploading.
function beforeSubmit() {
    $("#output").html("");
}