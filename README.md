**This is a simple REST API used for the calorie tracker application.**<br/><br/>
<u>How To Deploy</u>
<ol>
    <li>Deploy <i>trackcal_api</i> forder to local Apache.</li>
    <li>Run SQL script on local MySQL server.</li>
    <li>Check credentials in <i>Database.php</i> and/or configure accordingly.</li>
    <li>Perform HTTP operations via Postman.</li>
</ol>

<u>HTTP Operation Scheme</u>

<b>Read</b><br/>
GET request to <i>read.php</i>

<b>Create</b><br/>
POST request to <i>create.php</i><br/>
Payload:
<pre>{"name":"test", "calories":100}</pre>

<b>Update</b><br/>
PUT request to <i>update.php</i><br/>
Payload:
<pre>{"id":1, "name":"updated name", "calories":100}</pre>

<b>Delete</b><br/>
DELETE request to <i>delete.php</i><br/>
Payload:
<pre>{"id":1}</pre>

<b>Delete All</b><br/>
DELETE request to <i>delete_all.php</i>