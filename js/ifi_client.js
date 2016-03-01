/*
 * 
 * Popup div handler
 */
/************** start: functions. **************/

var popupStatus = 0; // set value

function loadPopup() {
    if (popupStatus == 0) { // if value is 0, show popup
        //closeloading(); // fadeout loading
        $("#waitpopup-wrapper").fadeIn(0500); // fadein popup div
        $("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
        $("#backgroundPopup").fadeIn(0001);
        popupStatus = 1; // and set value to 1
    }
}

function disablePopup() {
    if (popupStatus == 1) { // if value is 1, close popup
        $("#waitpopup-wrapper").fadeOut("normal");
        $("#backgroundPopup").fadeOut("normal");
        popupStatus = 0;  // and set value to 0
        window.location.replace("home.php");
    }
}
/************** end: popupdiv End functions. **************/




$(document).ready(function() {

    
    $("#go2home").click(function() {
        window.location.replace("home.php");
    });
});


$(document).ready(function() {
    $('.editable').editable('php/updateTransc.php', {
        indicator: '正在保存',
        tooltip: '双击可以编辑',
        event: "dblclick",
        submit: "OK",
        callback: function(data, settings) {
            //$(this).siblings(".help_text").text("(Click on the label to edit)");
//                    console.log(this);
            // console.log(data);
//                    console.log(settings);
            ajaxSum();

        },
        onsubmit: function(settings, td) {
            //var form = $(td).find('form');

            $(this).validate({
                rules: {
                    value: {
                        number: true
                    }
                },
                errorLabelContainer: '#errMsg',
                messages: {
                    value: '错误：只能输入数字！'
                }
            });

            return ($(this).valid());
        }
    });



});



function ajaxSum() {

    $.ajax({
        url: 'php/updateTransc.php',
        type: 'POST',
        data: {action: 'sum'},
        success: function(data) {
            $('#sum_row').html(data);
        }
    });
}


function confirmDel(rid) {
    //console.log('try to delete' + id);
    var v_sure = confirm('确定删除记录吗?');
    if (v_sure) {
        //console.log(v_sure);
        $.ajax({
            url: 'php/updateTransc.php',
            type: 'POST',
            data: {del: rid},
            success: function(data) {
                //delete successfully

                if (data === '1') {
                    //console.log("data:" + data+ " row:"+'#row'+id);
                    $('#row' + rid).fadeOut(500);
                    ajaxSum();
                }
            }
        });
    }
}

function saveNewRecd(rid) {
    console.log($('#de' + rid).val(), $('#cr' + rid).val(), $('#bad' + rid).val(), $('#date' + rid).html());
    loadPopup();
    
    $.ajax({
        url: 'php/updateTransc.php',
        type: 'POST',
        data: {action: 'add',
            date: $('#date' + rid).html(),
            de: $('#de' + rid).val(),
            cr: $('#cr' + rid).val(),
            bad: $('#bad' + rid).val()
        },
        dataType: 'json',
        success: function(data) {
            window.location.replace(data.location);
        }
    });

}

function cancelNewRecd(rid) {
    var v_sure = confirm('确定取消记录吗?');
    if (v_sure) {
        $('#' + rid).fadeOut(500);
    }
}

function addRow() {

    var datetime = $.format.date(new Date($.now()), "yyyy-MM-dd HH:mm:ss");
    var rid = 'newRecd' + $.now();
    var newRow = "<tr id='" + rid + "'><td class ='date' id='date" + rid + "'>" + datetime +
            "</td><td><input id='de" + rid + "' type='text'  class='newRecd'></input>" +
            "</td><td><input id='cr" + rid + "' type='text'  class='newRecd'></input>" +
            "</td><td><input id='bad" + rid + "' type='text'  class='newRecd'></input>" +
            "</td><td><a href='javascript:void(0)' onClick=\"saveNewRecd('" + rid + "')\">保存</a>" +
            "&nbsp<a href='javascript:void(0)' onClick=\"cancelNewRecd('" + rid + "')\">取消</a>" +
            "</td></tr>";

    $('#transcTable tr:last').after(newRow);
}

