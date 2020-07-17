**This is a simple REST API demo.**<br/><br/>
<u>How To Deploy</u>
<ol>
    <li>Copy <i>trackcal_api</i> folder to local Apache.</li>
    <li>Run SQL script on local MySQL server.</li>
    <li>Check database credentials in <i>Database.php</i> and/or configure accordingly.</li>
    <li>Perform HTTP operations via Postman for example.</li>
</ol>

<u>HTTP Operation Scheme</u>

<b>Read</b><br/>
GET request to <i>read.php</i>

<b>Create</b><br/>
POST request to <i>create.php</i><br/>
Payload:
<pre>{"description":"test", "calories":100}</pre>

<b>Update</b><br/>
PUT request to <i>update.php</i><br/>
Payload:
<pre>{"id":1, "description":"updated description", "calories":100}</pre>

<b>Delete</b><br/>
DELETE request to <i>delete.php</i><br/>
Payload:
<pre>{"id":1}</pre>

<b>Delete All</b><br/>
DELETE request to <i>delete_all.php</i>

**To-Do:**
<ul>
<li>Implement routing for clean resource paths (e.g. UPDATE to <i>https://myapi.com/meal/2</i>.)</li>
<li>Implement test cases using Guzzle and PHPUnit to validate result.</li>
<li>Static helper class to compact JSON server responses?</li>
<li><del>Validate request method in endpoint resources to restrict server to server communication.</del></li>
</ul>