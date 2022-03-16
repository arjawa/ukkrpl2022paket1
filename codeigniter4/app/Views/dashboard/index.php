<?= $this->extend("templates/dashboard"); ?>
<?= $this->section("content"); ?>
  
  <div id="welcome-section">Selamat datang <b><?= $nama; ?></b> di aplikasi catatan perjalanan</div>
  
  <button type="button" class="btn btn-success float-right mx-12" onclick="location.href='<?= base_url("dashboard/insert"); ?>'">Isi Catatan Perjalanan</button>

<?= $this->endSection(); ?>