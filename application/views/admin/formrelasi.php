<div class="contents">
  <section class="form-register">
        <div class="container">
          <div class="row">
            <section class="col-md-8 col-md-sm-8">
              <form action="<?php echo site_url('admin/relasi/'); ?>" method="post">
              <ul class="nav-tabs nav" role="tablist">
                <li role="presentation" class="active"><a href="#viewrelasi" aria-controls="viewrelasi" role="tab" data-toggle="tab">View Relasi</a></li>
                <li role="presentation" ><a href="#createedit" aria-controls="createedit" role="tab" data-toggle="tab">Create/Edit Relasi</a></li>
              </ul>
              <div class="tab-content">
              <div class="tab-pane fade in active" id="viewrelasi" role="tabpanel">
                <div class="col-md-16 col-sm-16">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <div class="collapse navbar-collapse">
                          <ul class="nav navbar-nav">
                            <li><class="panel-title"><span class="glyphicon glyphicon-list"></span> Daftar Relasi</h3></li>
                          </ul>
                          <ul class="nav navbar-nav navbar-right">
                            <li><input class="right" type="search" name="cari" placeholder="Search Relasi..."> <input type="submit" name="q" value="Search"></li>
                          </ul>
                      </div>
                      </div>
                      <div class="panel-body">
                          <table class="table table-bordered">
                              <th>No</th>
                              <th>Nama Halte</th>
                              <th>Nama Armada</th>
                              <th>Nama Rute </th>
                              <th></th>
                              <tbody>
                                <?php
                                $no = 1;
                                if (count($ListRelasi) > 0) {
                                foreach ($ListRelasi as $relasi){
                                  echo "<div class=\"letter\">";
                                 ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $relasi['namahalte'];?></td>
                                        <td><?php echo $relasi['namaarmada'];?></td>
                                        <td><?php echo $relasi['namajalan'];?></td>
                                        <td>
                                            <button a href="#createedit" aria-controls="createedit" role="tab" data-toggle="tab" type="button" class="btn btn-sm btn-info" data-idrelasi="<?php echo $relasi['id_relasi'];?>" name="editrelasi<?php echo $relasi['id_relasi'];?>" id="editrelasi"><span class="glyphicon glyphicon-edit" ></span></button>
                                            <button type="button" class="btn btn-sm btn-danger" data-idrelasi="<?php echo $relasi['id_relasi'];?>" name="deleterelasi<?php echo $relasi['id_relasi'];?>" id="deleterelasi"><span class="glyphicon glyphicon-trash"></span></button>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                        					?>
                                  <?php echo "</div>";
                        					}
                        					// echo "<tr><td colspan='6'><div style='background:000; float:right;'>".$this->pagination->create_links()."</div></td></tr>";
                        				} else {
                        					echo "<tbody><tr><td colspan='8' style='padding:10px; background:#F00; border:none; color:#FFF;'>Hasil pencarian tidak ditemukan.</td></tr></tbody>";
                        				} ?>

                              </tbody>
                          </table>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="createedit" role="tabpanel">
                  <div class="col-md-6 col-sm-6">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Form Relasi</h3>
                        </div>
                        <div class="panel-body">
                            <form action="#">
                              <div class="form-group">
                                <label for="id_halte">Nama Halte</label>
                                <select class="form-control" name="id_halte" id="id_halte">
                                  <option value="">Pilih Nama halte</option>
                                  <?php
                                  foreach ($itemhalte->result() as $halte) {
                                    ?>
                                    <<option value="<?php echo $halte->id_halte;?>"><?php echo $halte->namahalte; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="id_armada">Nama Armada</label>
                                <select class="form-control" name="id_armada" id="id_armada">
                                  <option value="">Pilih Nama armada</option>
                                  <?php
                                  foreach ($itemarmada->result() as $armada) {
                                    ?>
                                    <<option value="<?php echo $armada->id_armada;?>"><?php echo $armada->namaarmada; ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="id_jalan">Nama Rute </label>
                                <select class="form-control" name="id_jalan" id="id_jalan">
                                  <option value="">Pilih Nama Rute </option>
                                  <?php
                                  foreach ($itemjalan->result() as $jalan) {
                                    ?>
                                    <option value="<?php echo $jalan->id_jalan;?>"><?php echo $jalan->namajalan ?></option>
                                    <?php
                                  }
                                  ?>
                                </select>
                              </div>
                                <div class="form-group">
                                  <button a href="#viewrelasi" aria-controls="viewrelasi" role="tab" data-toggle="tab" type="button" name="simpanrelasi" id="simpanrelasi" class="btn btn-primary">Simpan</button>
                                  <button type="button" name="resetrelasi"  id="resetrelasi" class="btn btn-warning">Reset</button>
                                  <button a href="#viewrelasi" aria-controls="viewrelasi" role="tab" data-toggle="tab" type="button" name="updaterelasi" id="updaterelasi" class="btn btn-info" disabled="true">Update</button>
                                </div>
                            </form>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>
    </div>
<script>
    $(document).on('click','#simpanrelasi',simpanrelasi)
    .on('click','#resetrelasi',resetrelasi)
    .on('click','#updaterelasi',updaterelasi)
    .on('click','#editrelasi',editrelasi)
    .on('click','#deleterelasi',deleterelasi);
    function simpanrelasi() {//simpan relasi
        var datarelasi = {'id_halte':$('#id_halte').val(),
        'id_armada':$('#id_armada').val(),
        'id_jalan':$('#id_jalan').val()};console.log(datarelasi);
        $.ajax({
            url : '<?php echo site_url("admin/relasi/create");?>',
            data : datarelasi,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('#daftarrelasi').load('<?php echo current_url()." #daftarrelasi > *";?>');
                    resetrelasi();//form langsung dikosongkan pas selesai input data
                }else{
                    alert(data.msg);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
            }
        })
    }
    function resetrelasi() {//reset form relasi
        $('#id_halte').val('');
        $('#id_armada').val('');
        $('#id_jalan').val('');
        $('#simpanrelasi').attr('disabled',false);
        $('#updaterelasi').attr('disabled',true);
    }
    function updaterelasi() {//update relasi
        var datarelasi = {'id_halte':$('#id_halte').val(),
        'id_armada':$('#id_armada').val(),
        'id_jalan':$('#id_jalan').val(),
        'id_relasi':$('#id_relasi').val()};console.log(datarelasi);
        $.ajax({
            url : '<?php echo site_url("admin/relasi/update");?>',
            data : datarelasi,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('#daftarrelasi').load('<?php echo current_url()." #daftarrelasi > *";?>');
                    resetrelasi();//form langsung dikosongkan pas selesai input data
                }else{
                    alert(data.msg);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
            }
        })
    }
    function editrelasi() {//edit relasi
        var id = $(this).data('idrelasi');
        var datarelasi = {'id_relasi':id};console.log(datarelasi);
        $('input[name=editrelasi'+id+']').attr('disabled',true);//biar ga di klik dua kali, maka di disabled
        $.ajax({
            url : '<?php echo site_url("admin/relasi/edit");?>',
            data : datarelasi,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('input[name=editrelasi'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
                    $('#simpanrelasi').attr('disabled',true);
                    $('#updaterelasi').attr('disabled',false);
                    $.each(data.msg,function(k,v){
                        $('#id_relasi').val(v['id_relasi']);
                        $('#id_halte').val(v['id_halte']);
                        $('#id_armada').val(v['id_armada']);
                        $('#id_jalan').val(v['id_jalan']);
                    })
                }else{
                    alert(data.msg);
                    $('input[name=editrelasi'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
                $('input[name=editrelasi'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
            }
        })
    }
    function deleterelasi() {//delete relasi
        if (confirm("Anda yakin akan menghapus data relasi ini?")) {
            var id = $(this).data('idrelasi');
            var datarelasi = {'id_relasi':id};console.log(datarelasi);
            $.ajax({
                url : '<?php echo site_url("admin/relasi/delete");?>',
                data : datarelasi,
                dataType : 'json',
                type : 'POST',
                success : function(data,status){
                    if (data.status!='error') {
                        $('#daftarrelasi').load('<?php echo current_url()." #daftarrelasi > *";?>');
                        resetrelasi();//form langsung dikosongkan pas selesai input data
                    }else{
                        alert(data.msg);
                    }
                },
                error : function(x,t,m){
                    alert(x.responseText);
                }
            })
        }
    }
</script>
