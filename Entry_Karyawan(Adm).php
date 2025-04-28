<form method=POST action='?p=input&input=karyawan'>
    <fieldset>
        <legend><b>Entry Karyawan</b></legend>
        <?php include('../notif.php'); ?>
        <table>
            <tr>
                <td>ID</td>
                <td>:</td>
                <td><input type='text' name='ID' style='padding:0 10px'></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
<td><input type=text name='Nama' size=40></td>
</tr>
<tr>
<td>Alamat</td>
<td>:</td>
<td><input type=text name='Alamat' size=40></td>
</tr>
<tr>
<td>Jabatan</td>
<td>:</td>
<td>
    <select name='Jabatan'>
        <option value='agent'>agent</option>
        <option value='leader'>leader</option>
        <option value='admin'>admin</option>
        <option value='qc'>qc</option>
        <option value='spy'>spy</option>
    </select>
</td>
</tr>
<tr>
<td></td>
<td></td>
<td><input type=submit value='Simpan'></td>
</tr>
</table>
</fieldset>
</form>

<table border=1 style='border-collapse:collapse' cellpadding=4 align=center width='100%'>
<tr>
    <th>No</th>
    <th>ID</th>
    <th>Nama</th>
    <th>Alamat</th>
    <th>Jabatan</th>
    <th colspan=2>Option</th>
</tr>
<?php
include("./conn.php");
$no = 1;
$query = mysql_query("SELECT * FROM db_karyawan");
if (mysql_num_rows($query) < 1) {
    echo "
        <tr>
            <td colspan=6>Belum ada data yang dimasukkan</td>
        </tr>
    ";
} else {
    while ($view = mysql_fetch_array($query)) {
        echo "
            <tr>
                <td align=center>$no</td>
                <td align=center>$view[id]</td>
                <td align=center>$view[nama]</td>
        ";
    }
}
?>
</table>

            </tr>
        </table>
    </fieldset>
</form>
