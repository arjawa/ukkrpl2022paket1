<?= $this->extend("templates/dashboard"); ?>
<?= $this->section("content"); ?>
  
  <form method="post" class="form mx-12" action="<?= base_url("dashboard/insert_data"); ?>">
    <input type="date" name="tanggal" placeholder="Tanggal">
    <input type="time" name="jam" placeholder="Jam">
    <input type="text" name="lokasi" placeholder="Lokasi yang dikunjungi">
    <input type="number" name="suhu" placeholder="Suhu tubuh">
    <button type="submit" class="btn btn-success">Simpan</button>
  </form>
  
<?= $this->endSection(); ?>