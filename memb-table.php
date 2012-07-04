<?php
require('con.php');
?>
<div id='memb-table'><div id='memb-table-content'>
<form id='memb-table-form' method='post'>
<div id='memb-table-right' class='memb-table-form-side'><table>
<tr><td><label>*שם פרטי</label></td><td><input class='memb_pname' type='text' name='pname' maxlength='25' autocomplete='off' required /></td></tr>
<tr><td><label>*שם משפחה:</label></td><td><input class='memb_fname' type='text' name='fname' maxlength='100' autocomplete='off' required /></td></tr>
<tr><td>מין:</td><td><label><input type='radio' name='gender' value='1' class='radio memb_gender' checked>זכר</label><label><input type='radio' name='gender' value='2' class='radio memb_gender'>נקבה</label>
<tr><td><label>*תעודת זהות:</label></td><td><input class='memb_id_num'type='text' name='id_num' maxlength='9' required /></td></tr>
<tr><td><label>תאריך לידה:</label></td><td><input class='memb_birth_date' name='birth_date' type='date' value='' min='1912-01-01' placeholder='1993-02-13'></td></tr>
<tr><td><label>נייד חניך:</label></td><td><input class='memb_cell_phone' type='text' name='cell_phone' maxlength='10' /></td></tr>
<tr><td><label>*טלפון בית:</label></td><td><input class='memb_phone' type='text' name='phone' maxlength='9' required /></td></tr>
<tr><td><label>*קן:</label></td><td><select class='memb_ken' name='ken' required>
<option value=''>-- בחירה --</option>
<?php
if ($uid == 1) {
  $result = $con->query("SELECT id, name FROM ken ORDER BY id;"); // Get kens
} else {
  $result = $con->query("SELECT id, name FROM ken INNER JOIN permissions WHERE ken.id = permissions.ken_id AND permissions.user_id = {$uid};"); // Get kens
}
if (!$result) {
    die("Query to show fields from table failed");
}
while ($row = $result->fetch(PDO::FETCH_ASSOC))
{
	($row['id'] == $myken) ? $selected = " selected='selected'" : $selected = '';
	echo "<option value='{$row['id']}'$selected>{$row['name']}</option>";
}
$result = null;
?>
</select></td></tr>
<tr><td><label>*שכבה:</label></td><td><select class='memb_class' name='class' required>
<option value=''>-- בחירה --</option>
<?php
$result = $con->query("SELECT id, name FROM class ORDER BY id DESC;");
if (!$result) {
    die("Query to show fields from table failed");
}
while ($row = $result->fetch(PDO::FETCH_ASSOC))
{
	echo "<option value='{$row['id']}'>{$row['name']}</option>";
}
$result = null;
?>
</select></td></tr>
<tr><td><label>קבוצה:</label></td><td><input class='memb_team' type='text' name='team' maxlength='100' /></td></tr>
<tr><td><label>כתובת:</label></td><td><input class='memb_address' type='text' name='address' maxlength='255' /></td></tr>
<tr><td><label>*ישוב:</label></td><td><select class='memb_city' name='city' required>
<option value=''>-- בחירה --</option>
<?php
$result = $con->query("SELECT id, name FROM city ORDER BY id DESC;");
if (!$result) {
    die("Query to show fields from table failed");
}
while ($row = $result->fetch(PDO::FETCH_ASSOC))
{
        echo "<option value='{$row['id']}'>{$row['name']}</option>";
}
$result = null;
?>
</select></td></tr>
<tr><td><label>מיקוד:</label></td><td><input class='memb_zip_code' type='text' name='zip_code' maxlength='5' /></td></tr>
</table></div>
<div id='memb-table-left' class='memb-table-form-side'><table>
<tr><td><label>דוא"ל חניך:</label></td><td><input class='memb_email' type='email' name='email' maxlength='256' /></td></tr>
<tr><td><label>מידת חולצה:</label></td><td><select class='memb_shirt' name='shirt'>
<option value='0'>-- בחירה --</option>
<?php
$result = $con->query("SELECT id, name FROM shirt ORDER BY id;");
if (!$result) {
    die("Query to show fields from table failed");
}
while ($row = $result->fetch(PDO::FETCH_ASSOC))
{
        echo "<option value='{$row['id']}'>{$row['name']}</option>";
}
$result = null;
?>
</select></td></tr>
<tr><td><label>בעיות רפואיות:</label></td><td><textarea name='medical' maxlength='65000'></textarea></td></tr>
<tr><td><label>הערות נוספות:</label></td><td><textarea name='notes' maxlength='65000'></textarea></td></tr>
<tr><td><label>שם האב:</label></td><td><input class='memb_dad' type='text' name='dad' maxlength='100' /></td></tr>
<tr><td><label>נייד האב:</label></td><td><input class='memb_dad_cell' type='text' name='dad_cell' maxlength='10' /></td></tr>
<tr><td><label>עבודת האב:</label></td><td><input class='memb_dad_job' type='text' name='dad_job' maxlength='100' /></td></tr>
<tr><td><label>שם האם:</label></td><td><input class='memb_mom' type='text' name='mom' maxlength='100' /></td></tr>
<tr><td><label>נייד האם:</label></td><td><input class='memb_mom_cell' type='text' name='mom_cell' maxlength='10' /></td></tr>
<tr><td><label>עבודת האם:</label></td><td><input class='memb_mom_job' type='text' name='mom_job' maxlength='100' /></td></tr>
<tr><td><label>דוא"ל הורים:</label></td><td><input class='memb_parent_email' type='email' name='parent_email' maxlength='256' /></td></tr>
</table></div>
<center>
<input class='submit' type='submit' value='שמירת חניך' />
<div>שדות חובה מסומנים בכוכבית (*). מומלץ לודא את הפרטים שנית לפני השליחה.</div>
</center>
<div class='hidden_data'><input class="memb_id" type="text" name="id" maxlength="255"></div>
</form>
</div></div>
<?php
$con = null;
?>
<!-- multiedit dialog -->
<div id='yesno-dialog'>
בחרת לטעון מספר חניכים, האם להמשיך?
</div>
