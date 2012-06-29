<h2 id='ken-title' class='print'></h2>
<table id="mainTable" class='tablesorter' border="0" cellpadding="0" cellspacing="1">
<thead><tr class="table-title">
<td class='cb'><input type='checkbox' value='yes'></td>
<?php
$titles = array(
	array('class'=>'pname', 'hebrew'=>'שם'),
	array('class'=>'fname', 'hebrew'=>'משפחה'),
	array('class'=>'gender', 'hebrew'=>'ז/נ'),
        array('class'=>'id_num', 'hebrew'=>'מספר זהות'),
        array('class'=>'birth_date', 'hebrew'=>'תאריך לידה'),
	array('class'=>'team', 'hebrew'=>'קבוצה'),
        array('class'=>'class', 'hebrew'=>'שכבה'),
        array('class'=>'city', 'hebrew'=>'ישוב'),
        array('class'=>'address', 'hebrew'=>'כתובת'),
        array('class'=>'zip_code', 'hebrew'=>'מיקוד'),
        array('class'=>'phone', 'hebrew'=>'טלפון'),
        array('class'=>'cell_phone', 'hebrew'=>'סלולרי'),
        array('class'=>'email', 'hebrew'=>'דוא"ל'),
        array('class'=>'shirt', 'hebrew'=>'חולצה'),
        array('class'=>'medical', 'hebrew'=>'בעיות רפואיות'),
        array('class'=>'notes', 'hebrew'=>'הערות'),
        array('class'=>'dad', 'hebrew'=>'אב'),
        array('class'=>'dad_cell', 'hebrew'=>'נייד אב'),
        array('class'=>'dad_job', 'hebrew'=>'עבודת אב'),
        array('class'=>'mom', 'hebrew'=>'אם'),
        array('class'=>'mom_cell', 'hebrew'=>'נייד אם'),
        array('class'=>'mom_job', 'hebrew'=>'עבודת אם'),
        array('class'=>'parent_email', 'hebrew'=>'דוא"ל הורים'),
);

foreach($titles as $title){
echo "<th class='header {$title['class']}'>{$title['hebrew']}</td>";
}
?>
</tr></thead>
<tbody class='table-content'>
</tbody>
</table>
<div id='credit-for-print' class='print'>מודפס באמצעות המערכת לרישום חניכים של השומר הצעיר - פותח על־ידי דור דנקנר.</div>
