<?= $this->extend("templates/user"); ?>
<?= $this->section("content"); ?>
  
  <form method="post" action="<?= base_url("user/action"); ?>" class="form">
    <input type="text" name="nik" placeholder="NIK">
    <input type="text" name="nama" placeholder="Nama Lengkap">
    <div class="btn-group">
      <button type="submit" class="btn btn-primary" name="action" value="register">Saya Pengguna Baru</button>
      <button type="submit" class="btn btn-success" name="action" value="login">Masuk</button>
    </div>
  </form>

<?= $this->endSection(); ?>