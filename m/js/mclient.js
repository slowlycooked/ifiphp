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
        sleep(1000);
        $("#waitpopup-wrapper").fadeOut("normal");
        $("#backgroundPopup").fadeOut("normal");
        popupStatus = 0;  // and set value to 0
       // window.location.replace("mindex.php");
    }
}
/************** end: popupdiv End functions. **************/




$(document).ready(function() {

    
   
});


$(document).ready(function() {
 
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
            url: 'php/pdateTransc.php',
            type: 'POST',
            data: {del: rid},
            success: function(data) {
                //delete successfully

                if (data === '1') {
                    //console.log("data:" + data+ " row:"+'#row'+id);
                    $('#row').fadeOut(500);
                    ajaxSum();
                }
            }
        });
    }
}

function saveNewRecd() {
    console.log($('#deNew').val(), $('#crNew').val(), $('#badNew').val(), $('#date').html());
    loadPopup();
    
    $.ajax({
        url: '../../php/updateTransc.php',
        type: 'POST',
        data: {action: 'add',
            date: $('#date').html(),
            de: $('#deNew').val(),
            cr: $('#crNew').val(),
            bad: $('#badNew').val()
        },
        dataType: 'json',
        success: function(data) {
           window.location.replace(data.location);
           console.log("Add new Record successful.");
        }
    });

}

function cancelNewRecd(rid) {
    var v_sure = confirm('确定取消记录吗?');
    if (v_sure) {
        $('#').fadeOut(500);
    }
}

function addRow() {

    var datetime = $.format.date(new Date($.now()), "yyyy-MM-dd HH:mm:ss");
    var rid = 'newRecd' + $.now();
    var newRow = "<tr id='" + "'><td class ='date' id='date" + "'>" + datetime +
            "</td><td><input id='de" + "' type='text'  class='newRecd'></input>" +
            "</td><td><input id='cr" + "' type='text'  class='newRecd'></input>" +
            "</td><td><input id='bad" + "' type='text'  class='newRecd'></input>" +
            "</td><td><a href='javascript:void(0)' onClick=\"saveNewRecd('" + "')\">保存</a>" +
            "&nbsp<a href='javascript:void(0)' onClick=\"cancelNewRecd('" + "')\">取消</a>" +
            "</td></tr>";

    $('#transcTable tr:last').after(newRow);
}

