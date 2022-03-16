<?= $this->extend("templates/dashboard"); ?>
<?= $this->section("content"); ?>

  <form action="" method="get" class="container mx-12" id="filter">
    <label for="filter">Urutkan berdasarkan</label>
    <select name="filter">
      <option value="tanggal">Tanggal</option>
      <option value="suhu">Suhu Tubuh</option>
    </select>
    <button type="submit" class="btn btn-primary">Urutkan</button>
  </form>
  
  <div class="container">
    <table class="table-catatan" border="1" cellpadding="0" cellspacing="0">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Waktu</th>
          <th>Lokasi</th>
          <th>Suhu Tubuh</th>
        </tr>
      </thead>
      <tbody>
      <?php 
      if (gettype($notes) != "string") {
        foreach ($notes as $note) {
          echo "
            <tr>
              <td>".$note->tanggal."</td>
              <td>".$note->jam."</td>
              <td>".$note->lokasi."</td>
              <td>".$note->suhu."</td>
            </tr>
          ";
        }
      } else {
        echo "
          <tr>
            <td colspan=\"4\">".$notes."</td>
          </tr>
        ";
      }
      ?>
      </tbody>
    </table>
  </div>
  
  <button type="button" class="btn btn-success float-right mx-12" onclick="location.href='<?= base_url("dashboard/insert"); ?>'">Isi Catatan Perjalanan</button>

<?= $this->endSection(); ?>