/**
 *  highlightRow and highlight are used to show a visual feedback. If the row has been successfully modified, it will be highlighted in green. Otherwise, in red
 */
function highlightRow(rowId, bgColor, after)
{
    var rowSelector = $("#" + rowId);

    rowSelector.css("background-color", bgColor);
    rowSelector.fadeTo("normal", 0.5, function() {
        rowSelector.fadeTo("fast", 1, function() {
            rowSelector.css("background-color", '');
        });
    });
}

function highlight(div_id, style) {
    highlightRow(div_id, style == "error" ? "#e5afaf" : style == "warning" ? "#ffcc00" : "#8dc70a");
}

/**
 updateCellValue calls the PHP script that will update the database. 
 */
function updateCellValue(editableGrid, rowIndex, columnIndex, oldValue, newValue, row, onResponse)
{
    $.ajax({
        url: 'update.php',
        type: 'POST',
        dataType: "html",
        data: {
            tablename: editableGrid.name,
            id: editableGrid.getRowId(rowIndex),
            newvalue: editableGrid.getColumnType(columnIndex) == "boolean" ? (newValue ? 1 : 0) : newValue,
            colname: editableGrid.getColumnName(columnIndex),
            coltype: editableGrid.getColumnType(columnIndex)
        },
        success: function(response)
        {
            // reset old value if failed then highlight row
            var success = onResponse ? onResponse(response) : (response == "ok" || !isNaN(parseInt(response))); // by default, a sucessfull reponse can be "ok" or a database id 
            if (!success)
                editableGrid.setValueAt(rowIndex, columnIndex, oldValue);
            highlight(row.id, success ? "ok" : "error");
        },
        error: function(XMLHttpRequest, textStatus, exception) {
            alert("Ajax failure\n" + errortext);
        },
        async: true
    });

}



function DatabaseGrid()
{
    this.editableGrid = new EditableGrid("demo", {
        enableSort: true, // true is the default, set it to false if you don't want sorting to be enabled
        editmode: "absolute", // change this to "fixed" to test out editorzone, and to "static" to get the old-school mode
        editorzoneid: "edition", // will be used only if editmode is set to "fixed"

        tableLoaded: function() {
            datagrid.initializeGrid(this);
        },
        modelChanged: function(rowIndex, columnIndex, oldValue, newValue, row) {
            updateCellValue(this, rowIndex, columnIndex, oldValue, newValue, row);
        }
    });
    this.fetchGrid();

}

// helper function to get path of a demo image
function image(relativePath) {
	return "images/" + relativePath;
}

DatabaseGrid.prototype.fetchGrid = function() {
    // call a PHP script to get the data
    this.editableGrid.loadXML("loaddata.php");
};

DatabaseGrid.prototype.initializeGrid = function(grid) {

    // render for the action column
    grid.setCellRenderer("action", new CellRenderer({render: function(cell, value) {
            // this action will remove the row, so first find the ID of the row containing this cell 
            var rowId = editableGrid.getRowId(cell.rowIndex);

            cell.innerHTML = "<a onclick=\"if (confirm('Are you sure you want to delete this person ? ')) { editableGrid.remove(" + cell.rowIndex + "); editableGrid.renderCharts(); } \" style=\"cursor:pointer\">" +
                    "<img src=\"" + image("delete.png") + "\" border=\"0\" alt=\"delete\" title=\"Delete row\"/></a>";

            cell.innerHTML += "&nbsp;<a onclick=\"editableGrid.duplicate(" + cell.rowIndex + ");\" style=\"cursor:pointer\">" +
                    "<img src=\"" + image("duplicate.png") + "\" border=\"0\" alt=\"duplicate\" title=\"Duplicate row\"/></a>";

        }}));
    
    grid.renderGrid("tablecontent", "testgrid", "tableid");
 
};





