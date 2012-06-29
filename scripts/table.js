var items = ['id', 'pname', 'fname', 'gender', 'id_num', 'birth_date', 'team', 'class', 'city', 'address', 'zip_code', 'phone', 'cell_phone', 'email', 'shirt', 'medical', 'notes', 'dad', 'dad_cell', 'dad_job', 'mom', 'mom_cell', 'mom_job', 'parent_email'];
member=[];
memobj = {};
$(function() {
$("body").on('click', '#mainTable tbody tr:has(:checkbox)', function(event) { // Color selected tr
    $(this).toggleClass('selected');
    if (event.target.type !== 'checkbox') { // Even when the user doesn't click the checkbox itself
      $(':checkbox', this).attr('checked', function() {
        return !this.checked;
      });
    }
      if ($('#mainTable tbody tr td input[type=checkbox]:checked').length > 0) {
        $('#toolbar-editmemb').addClass('available'); // make edit member button avilable
        $('#toolbar-printTable').addClass('available');
	$('#toolbar-exportTable').addClass('available');
        $('#mainTable thead tr td.cb input:checkbox').attr('checked', 'checked'); // check .cb
      }
      else {
        $('#toolbar-editmemb').removeClass('available');
        $('#toolbar-printTable').removeClass('available');
        $('#toolbar-exportTable').removeClass('available');
        $('#mainTable thead tr td.cb input:checkbox').removeAttr('checked');
      }
});
$("#browser").treeview({ // TreeView
    collapsed: true
});

$("body").on('click', '#mainTable thead tr td input:checkbox', function(event) { // Select all table
    var checkedStatus = this.checked;

    $("#mainTable tbody tr td:first-child input:checkbox").each(function() {
        this.checked = checkedStatus;
    });
    $("#mainTable tbody tr").each(function() { // Even when the user doesn't click the checkbox itself
    if (event.target.type !== 'checkbox') {
      $(':checkbox', this).attr('checked', function() {
        return !this.checked;
      }); 
    }   
    if (checkedStatus) {
        $(this).addClass('selected');
    }
    else {
        $(this).removeClass('selected');
    }
    });
    if ($('#mainTable tbody tr td input[type=checkbox]:checked').length > 0) {
        $('#toolbar-editmemb').addClass('available'); // make edit member button avilable
        $('#toolbar-printTable').addClass('available');
        $('#toolbar-exportTable').addClass('available');
    }
    else {
      $('#toolbar-editmemb').removeClass('available');
        $('#toolbar-printTable').removeClass('available');
        $('#toolbar-exportTable').removeClass('available');
    }

});
$("body").on('click', '#toolbar-printTable', function(event) { window.print(); });
$("body").on('click', '#toolbar-exportTable', function(event) {
	const MIME_TYPE = 'text/csv';
	var current_date = new Date();
	var dd = current_date.getDate();
	var mm = current_date.getMonth()+1;
	var yyyy = current_date.getFullYear();
	if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var current_date = yyyy+mm+dd;

	$('#mainTable').addClass('exporting');
        var csv = $('#mainTable').table2CSV({delivery:'value'});
	$('#mainTable').removeClass('exporting');
	var file_name = $('.selected-ken').text()+'-'+current_date+'.csv';

	window.URL = window.webkitURL || window.URL;
	window.BlobBuilder = window.BlobBuilder || window.WebKitBlobBuilder || window.MozBlobBuilder;

	var bb = new BlobBuilder();
	bb.append(csv);

	$('.exportTable a').attr('download', file_name);
	$('.exportTable a').attr('href', window.URL.createObjectURL(bb.getBlob(MIME_TYPE)));
});
});  

function loadTable(ken) {
$.getJSON('dataGen.php', { 'ken' : ken }, function(json_data){
	var table_obj = $('.table-content');
	$.each(json_data, function(index, item){
		table_obj.append(function(){
                        var curRow = '<tr id="member-'+item.id+'"><td class="cb"><input type="checkbox" value="yes"></td>';
			member[item.id] = [];
			for (var i=0; i<items.length; i++) {
				member[item.id][i] = item[items[i]];
				curRow += '<td class="'+items[i]+'">'+item[items[i]]+'</td>';
			}
			curRow += '</tr>';
			return curRow;
		});
});
        $("#mainTable").tablesorter();

});
	$('#toolbar-newmemb').show();
	$('#ken-title.print').text('קן '+$('.selected-ken').text()+' - השומר הצעיר');
}
