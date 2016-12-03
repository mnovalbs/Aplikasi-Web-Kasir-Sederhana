<?php
  $this->view('header');
?>

  <form method='POST' action='<?php echo base_url('petugas/login'); ?>'>
    <input name='email'/>
    <input name='password'/>
    <button type='submit' name='login'>Login</button>
  </form>

<?php
  $this->view('footer');
?>
