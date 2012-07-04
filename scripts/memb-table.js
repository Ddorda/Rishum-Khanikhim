jQuery(function ($) {
	// Load dialog on click
	$('body').on('click', '.newmemb a', function (e) {
		data2Table(0); //clean the table
                $('#memb-table-form').attr('action', 'add-memb.php');
		$('#memb-table-form').attr('class', 'new-memb-table-form');
		$('#memb-table').modal();

		return false;
	});

        $('body').on('click', '.editmemb a', function (e) {
		if ($('#mainTable tbody tr td input[type=checkbox]:checked').length > 1) {
			$('#yesno-dialog').dialog({
				dialogClass: 'yesno-dialog',
				autoOpen: true,
				modal: true,
				minHeight: 100,
				closeOnEscape: false,
				buttons: {
					'המשך': function() {
						$(this).dialog("close");
						editTable();
					},
					'ביטול': function() {
						$(this).dialog("close");
					}
				}
			});
		}
		else {
                editTable();	
		}
        });
});

function submitTable() { //IM HERE!!!
	$.ajax({type:'POST', url: 'edit-memb.php', data:$('#memb-table-form').serialize(), success: function(response) {
		console.log(response);
	}});
	$.modal.close(); // call next member
	return false;
}

function editTable () {
	var patt=/(?!member-\b)\b\w+/
	var checkedItems = $('#mainTable tbody tr:has(:checkbox:checked)').map(function() { return $(this).attr('id').match(patt)}); //checked members id's
	var currentItem = 0;

	loadItem();

	function loadItem () {
		if (currentItem<checkedItems.length) {
			data2Table(checkedItems[currentItem]);
			$('#memb-table-form').attr('onsubmit', 'return submitTable();');
                        $('#memb-table-form').attr('action', '');
			$('#memb-table-form').attr('class', 'edit-memb-table-form');
			currentItem++;
			$('#memb-table').modal({
				onClose: function() { $.modal.close(); loadItem(); } // Load next member
			});
		}
		else {
			location.reload(true); // If there's nothing more to show refresh page to get latest data
		}
	}

	function submitTable() { //IM HERE!!!
		$.ajax({type:'POST', url: 'edit-memb-ajax.php', data:$('#memb-table-form').serialize(), success: function(response) {
			  //$('#ContactForm').find('.form_result').html(response);
			console.log('submitted');
		}});
		$.modal.close(); currentItem++; loadItem();
		return false;
	}
}
function data2Table (id) { // use 0 to clean the table. mostly for new members
if (id == 0) {
	$('#memb-table-form .hidden_data .memb_id').attr('disabled', 'disabled');
	chooseLabel = '-- בחירה --';
        for (var i=0; i<items.length; i++) {
                switch(i) {
                        case 3: //gender
                                $('#memb-table-form input[value="1"].memb_gender').attr('checked', true);
                                break;
                        case 7: //class
                                $('#memb-table-form .memb_class option').filter(function() {return $(this).text() == chooseLabel}).attr('selected','selected');
                                break;
                        case 8: //city
                                $('#memb-table-form .memb_city option').filter(function() {return $(this).text() == chooseLabel}).attr('selected','selected');
                                break;
                        case 14: //Shirt
                                $('#memb-table-form .memb_shirt option').filter(function() {return $(this).text() == chooseLabel}).attr('selected','selected');
                                break;
                        case 15: //medical
                                $('#memb-table-form textarea[name='+items[i]+']').val('');
                                break;
                        case 16: //medical
                                $('#memb-table-form textarea[name='+items[i]+']').val('');
                                break;
                        default:
                                $('#memb-table-form input[name='+items[i]+']').val('');
                }
        }
}
else {
	$('#memb-table-form .hidden_data .memb_id').attr('disabled', false);
	for (var i=0; i<member[id].length; i++) {
		switch(i) {
			case 3: //gender
				if (member[id][i] == 'ז') {$('#memb-table-form input[value="1"].memb_gender').attr('checked', true);}
				else if (member[id][i] == 'נ') {$('#memb-table-form input[value="2"].memb_gender').attr('checked', true);}
				break;
			case 7: //class
				$('#memb-table-form .memb_class option').filter(function() {return $(this).text() == member[id][i]}).attr('selected','selected');
				break;
			case 8: //city
				$('#memb-table-form .memb_city option').filter(function() {return $(this).text() == member[id][i]}).attr('selected','selected');
				break;
			case 14: //Shirt
				$('#memb-table-form .memb_shirt option').filter(function() {return $(this).text() == member[id][i]}).attr('selected','selected');
				break;
			case 15: //medical
				$('#memb-table-form textarea[name='+items[i]+']').attr('value', member[id][i]);
				break;
			case 16: //medical
				$('#memb-table-form textarea[name='+items[i]+']').attr('value', member[id][i]);
				break;
			default: 
				$('#memb-table-form input[name='+items[i]+']').attr('value', member[id][i]);
			//	console.log(items[i]+': '+member[id][i]);
		}
	}
}
}

