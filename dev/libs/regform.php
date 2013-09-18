<form action="/registration/register.php" method="post" name="reg" id="reg">
                    <input type="text" id="inputusername" name="username" value="Username" maxlength="20" size="55" /><p></p>
                    <p id="errusr">[+] The username contains invalid characters.<br />
                    [+] Characters allowed are A-Z, a-z, 0-9, _- and .</p>
                    <p id="errusr2">[+] Username must be between 4 and 16 characters.</p>
                    <p id="errusr3">[+] This username is already taken</p>
                    <input type="text" id="inputname" name="name" value="Screen name" maxlength="20" size="55" /><p></p>
                    <p id="errname">[+] Characters allowed are A-Z, a-z, 0-9, _-. and space</p>
                    <p id="errname2">[+] Screen name must be between 4 and 16 characters.</p>
                    <input type="text" id="inputpasswordc" name="passwordc" value="Password" maxlength="24" size="55" />
                    <input type="password" id="inputpassword" name="password" value="" maxlength="16" size="55"/><p></p>
                    <p id="errpwd">[+] The password must contain a capitalized and lower-case letter, a special character, and a number.<br />
                    [+] Characters allowed are A-Z, a-z and 0-9.</p>
                    <p id="errpwd3">[+] Password must be between 6 and 16 characters.</p>
                    <input type="text" id="inputpassword2c" name="password2c" value="Confirm password" maxlength="24" size="55" />
                    <input type="password" id="inputpassword2" name="password2" value="" maxlength="16" size="55" /><p></p>
                    <p id="errpwd2">[+] Passwords do not match.</p>
                    <input type="text" id="inputemail" name="email" value="Email" maxlength="50" size="55" /><p></p>
                    <p id="erremail">[+] Invalid email address.</p>
                    <p id="erremail2">[+] There is already an account with that email.</p>
                    <div id="boxL"><input type="checkbox" name="acc" id="checkacc" value="1"></div>
                    <div id="boxL">Yes i accept the <a href="javascript:show('termss');">Terms</a></div><br>
                    <p id="erracc">[+] You need to accept the terms.</p><br />
                    <?php
$date = date("Ymd");
$rand = rand(0,9999999999999);
$height = "50";
$width  = "240";
$img    = "$date$rand-$height-$width.jpgx";
echo "<input type='hidden' name='img' value='$img'>";
echo '<div style="background-image: url(http://www.opencaptcha.com/img/'.$img.'); height:50px; width:240px;">&nbsp;</div><br />';
echo '<p id="errcap">[+] The code you entered is wrong.</p>';
echo "<input type='text' name='code' id='capcode' value='Enter the code' size='35' />";
?>
                    <p id="errcap2">[+] You need to enter the code.</p>
                    
                    <div id="regsubnav"><input type="button" onclick="register();" id="regsubbtn" value="Register"/></div>
                 </form>