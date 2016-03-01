/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function deleteClient(cid) {
    //console.log('try to delete' + id);
    var v_sure = confirm('确定删除该客户吗?');
    if (v_sure) {
        //console.log(v_sure);
        $.ajax({
            url: 'php/clientMan.php',
            type: 'POST',
            data: {del: cid},
            dataType: 'json',
            success: function(data) {
                window.location.replace(data.location);
            }
        });
    }
}