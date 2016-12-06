<div class='form-login'>
  <?php
    echo $error_form;
    if(!empty($error)){echo "<div class='peringatan merah'>".$error."</div>";}
  ?>
  <div id='peringatan-js'></div>
  <form method='POST' onsubmit='do_login()' class='cd-form'>
    <div class='input'>
      <input name='email' placeholder='Email' onkeypress='inputKeyPress(event)' value='<?php echo set_value('email'); ?>'/>
    </div>
    <div class='input'>
      <input name='password' placeholder='Password' onkeypress='inputKeyPress(event)' type='password'/>
    </div>
    <button type='button' onclick='do_login()' name='login'>Login</button>
  </form>
</div>
