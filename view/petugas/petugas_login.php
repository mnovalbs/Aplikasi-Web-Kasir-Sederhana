<?php
  $this->view('header');
?>

  <form method='POST'>
    <input name='email'/>
    <input name='password'/>
    <button type='submit' name='login'>Login</button>
  </form>

<?php
  $this->view('footer');
?>
