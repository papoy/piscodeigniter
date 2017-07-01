<div class="contents">
  <section class="form-register">
        <div class="container">
          <div class="row">
            <section class="col-md-8 col-md-sm-8">
              <form action="<?php echo site_url('admin/jalan/'); ?>" method="post">
              <ul class="nav-tabs nav" role="tablist">
                <li role="presentation" class="active"><a href="#viewjalan" aria-controls="viewjalan" role="tab" data-toggle="tab">View Rute</a></li>
                <li role="presentation" ><a href="#createedit" aria-controls="createedit" role="tab" data-toggle="tab">Create/Edit Rute</a></li>
              </ul>
              <div class="tab-content">
              <div class="tab-pane fade in active" id="viewjalan" role="tabpanel">
                <div class="col-md-16 col-sm-16">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <div class="collapse navbar-collapse">
                          <ul class="nav navbar-nav">
                            <li><class="panel-title"><span class="glyphicon glyphicon-list"></span> Daftar Rute</h3></li>
                          </ul>
                          <ul class="nav navbar-nav navbar-right">
                            <li><input class="right" type="search" name="cari" placeholder="Search jalan..."> <input type="submit" name="q" value="Search"></li>
                          </ul>
                      </div>
                      </div>
                      <div class="panel-body">
                          <table class="table table-bordered">
                              <th>No</th>
                              <th>Nama Rute</th>
                              <th>Keterangan</th>
                              <th></th>
                              <tbody>
                                <?php
                                $no = 1;
                                if (count($ListRute) > 0) {
                                foreach ($ListRute as $jalan){
                                  echo "<div class=\"letter\">";
                                 ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $jalan['namajalan'];?></td>
                                        <td><?php echo $jalan['keterangan'];?></td>
                                        <td>
                                            <button a href="#createedit" aria-controls="createedit" role="tab" data-toggle="tab" type="button" class="btn btn-sm btn-info" data-idjalan="<?php echo $jalan['id_jalan'];?>" name="editjalan<?php echo $jalan['id_jalan'];?>" id="editjalan"><span class="glyphicon glyphicon-edit" ></span></button>
                                            <button type="button" class="btn btn-sm btn-danger" data-idjalan="<?php echo $jalan['id_jalan'];?>" name="deletejalan<?php echo $jalan['id_jalan'];?>" id="deletejalan"><span class="glyphicon glyphicon-trash"></span></button>
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
                          <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Form Rute</h3>
                        </div>
                        <div class="panel-body">
                            <form action="#">
                                <div class="form-group">
                                  <label for="namajalan">Nama Rute</label>
                                  <input type="text" class="form-control" id="namajalan" placeholder="">
                                  <input type="hidden" name="id_jalan" id="id_jalan" value="">
                                </div>
                                <div class="form-group">
                                  <label for="keterangan">Keterangan</label>
                                  <textarea name="keterangan" class="form-control" id="keterangan"></textarea>
                                </div>
                                <div class="form-group">
                                  <button a href="#viewjalan" aria-controls="viewjalan" role="tab" data-toggle="tab" type="button" name="simpanjalan" id="simpanjalan" class="btn btn-primary">Simpan</button>
                                  <button type="button" name="resetjalan"  id="resetjalan" class="btn btn-warning">Reset</button>
                                  <button a href="#viewjalan" aria-controls="viewjalan" role="tab" data-toggle="tab" type="button" name="updatejalan" id="updatejalan" class="btn btn-info" disabled="true">Update</button>
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
    $(document).on('click','#simpanjalan',simpanjalan)
    .on('click','#resetjalan',resetjalan)
    .on('click','#updatejalan',updatejalan)
    .on('click','#editjalan',editjalan)
    .on('click','#deletejalan',deletejalan);
    function simpanjalan() {//simpan jalan
        var datajalan = {'namajalan':$('#namajalan').val(),
        'keterangan':$('#keterangan').val()};console.log(datajalan);
        $.ajax({
            url : '<?php echo site_url("admin/jalan/create");?>',
            data : datajalan,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('#daftarjalan').load('<?php echo current_url()." #daftarjalan > *";?>');
                    resetjalan();//form langsung dikosongkan pas selesai input data
                }else{
                    alert(data.msg);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
            }
        })
    }
    function resetjalan() {//reset form jalan
        $('#namajalan').val('');
        $('#keterangan').val('');
        $('#id_jalan').val('');
        $('#simpanjalan').attr('disabled',false);
        $('#updatejalan').attr('disabled',true);
    }
    function updatejalan() {//update jalan
        var datajalan = {'namajalan':$('#namajalan').val(),
        'keterangan':$('#keterangan').val(),
        'id_jalan':$('#id_jalan').val()};console.log(datajalan);
        $.ajax({
            url : '<?php echo site_url("admin/jalan/update");?>',
            data : datajalan,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('#daftarjalan').load('<?php echo current_url()." #daftarjalan > *";?>');
                    resetjalan();//form langsung dikosongkan pas selesai input data
                }else{
                    alert(data.msg);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
            }
        })
    }
    function editjalan() {//edit jalan
        var id = $(this).data('idjalan');
        var datajalan = {'id_jalan':id};console.log(datajalan);
        $('input[name=editjalan'+id+']').attr('disabled',true);//biar ga di klik dua kali, maka di disabled
        $.ajax({
            url : '<?php echo site_url("admin/jalan/edit");?>',
            data : datajalan,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('input[name=editjalan'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
                    $('#simpanjalan').attr('disabled',true);
                    $('#updatejalan').attr('disabled',false);
                    $.each(data.msg,function(k,v){
                        $('#id_jalan').val(v['id_jalan']);
                        $('#namajalan').val(v['namajalan']);
                        $('#keterangan').val(v['keterangan']);
                    })
                }else{
                    alert(data.msg);
                    $('input[name=editjalan'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
                $('input[name=editjalan'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
            }
        })
    }
    function deletejalan() {//delete jalan
        if (confirm("Anda yakin akan menghapus data jalan ini?")) {
            var id = $(this).data('idjalan');
            var datajalan = {'id_jalan':id};console.log(datajalan);
            $.ajax({
                url : '<?php echo site_url("admin/jalan/delete");?>',
                data : datajalan,
                dataType : 'json',
                type : 'POST',
                success : function(data,status){
                    if (data.status!='error') {
                        $('#daftarjalan').load('<?php echo current_url()." #daftarjalan > *";?>');
                        resetjalan();//form langsung dikosongkan pas selesai input data
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
