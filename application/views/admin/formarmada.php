<div class="contents">
      <section class="form-register">
        <div class="container">
          <div class="row">
            <section class="col-md-8 col-md-sm-8">
              <form action="<?php echo site_url('admin/armada/'); ?>" method="post">
              <ul class="nav-tabs nav" role="tablist">
                <li role="presentation" class="active"><a href="#viewarmada" aria-controls="viewarmada" role="tab" data-toggle="tab">View Armada</a></li>
                <li role="presentation" ><a href="#createedit" aria-controls="createedit" role="tab" data-toggle="tab">Create/Edit Armada</a></li>
              </ul>
              <div class="tab-content">
              <div class="tab-pane fade in active" id="viewarmada" role="tabpanel">
                <div class="col-md-16 col-sm-16">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <div class="collapse navbar-collapse">
                          <ul class="nav navbar-nav">
                            <li><class="panel-title"><span class="glyphicon glyphicon-list"></span> Daftar Armada</h3></li>
                          </ul>
                          <ul class="nav navbar-nav navbar-right">
                            <li><input class="right" type="search" name="cari" placeholder="Search Armada..."> <input type="submit" name="q" value="Search"></li>
                          </ul>
                      </div>
                      </div>
                      <div class="panel-body">
                          <table class="table table-bordered">
                              <th>No</th>
                              <th>Nama Armada</th>
                              <th>Rute</th>
                              <th></th>
                              <tbody id="daftararmada">
                                  <?php
                                  $no = 1;
                                  if (count($ListArmada) > 0) {
                                  foreach ($ListArmada as $armada) {
                                      ?>
                                      <tr>
                                          <td><?php echo $no;?></td>
                                          <td><?php echo $armada['namaarmada'];?></td>
                                          <td><?php echo $armada['rute'];?></td>
                                          <td>
                                            <button a href="#createedit" aria-controls="createedit" role="tab" data-toggle="tab" type="button" class="btn btn-sm btn-info" data-idarmada="<?php echo $armada['id_armada'];?>" name="editarmada<?php echo $armada['id_armada'];?>" id="editarmada"><span class="glyphicon glyphicon-edit" ></span></button>
                                            <button type="button" class="btn btn-sm btn-danger" data-idarmada="<?php echo $armada['id_armada'];?>" name="deletearmada<?php echo $armada['id_armada'];?>" id="deletearmada"><span class="glyphicon glyphicon-trash"></span></button>
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
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="createedit" role="tabpanel">
                  <div class="col-md-6 col-sm-6">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Form Armada</h3>
                        </div>
                        <div class="panel-body">
                            <form action="#">
                              <div class="form-group">
                                <label for="namaarmada">Nama Armada</label>
                                <input type="text" class="form-control" id="namaarmada" placeholder="">
                                <input type="hidden" name="id_armada" id="id_armada" value="">
                              </div>
                              <div class="form-group">
                                <label for="rute">Rute</label>
                                <textarea name="keterangan" class="form-control" id="rute"></textarea>
                              </div>
                                <div class="form-group">
                                  <button a href="#viewarmada" aria-controls="viewarmada" role="tab" data-toggle="tab" type="button" name="simpanarmada" id="simpanarmada" class="btn btn-primary">Simpan</button>
                                  <button type="button" name="resetarmada"  id="resetarmada" class="btn btn-warning">Reset</button>
                                  <button a href="#viewarmada" aria-controls="viewarmada" role="tab" data-toggle="tab" type="button" name="updatearmada" id="updatearmada" class="btn btn-info" disabled="true">Update</button>
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
    $(document).on('click','#simpanarmada',simpanarmada)
    .on('click','#resetarmada',resetarmada)
    .on('click','#updatearmada',updatearmada)
    .on('click','#editarmada',editarmada)
    .on('click','#deletearmada',deletearmada);
    function simpanarmada() {//simpan armada
        var dataarmada = {'namaarmada':$('#namaarmada').val(),
        'rute':$('#rute').val()};console.log(dataarmada);
        $.ajax({
            url : '<?php echo site_url("admin/armada/create");?>',
            data : dataarmada,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('#daftararmada').load('<?php echo current_url()." #daftararmada > *";?>');
                    resetarmada();//form langsung dikosongkan pas selesai input data
                }else{
                    alert(data.msg);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
            }
        })
    }
    function resetarmada() {//reset form armada
        $('#namaarmada').val('');
        $('#rute').val('');
        $('#id_armada').val('');
        $('#simpanarmada').attr('disabled',false);
        $('#updatearmada').attr('disabled',true);
    }
    function updatearmada() {//update armada
        var dataarmada = {'namaarmada':$('#namaarmada').val(),
        'rute':$('#rute').val(),
        'id_armada':$('#id_armada').val()};console.log(dataarmada);
        $.ajax({
            url : '<?php echo site_url("admin/armada/update");?>',
            data : dataarmada,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('#daftararmada').load('<?php echo current_url()." #daftararmada > *";?>');
                    resetarmada();//form langsung dikosongkan pas selesai input data
                }else{
                    alert(data.msg);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
            }
        })
    }
    function editarmada() {//edit armada
        var id = $(this).data('idarmada');
        var dataarmada = {'id_armada':id};console.log(dataarmada);
        $('input[name=editarmada'+id+']').attr('disabled',true);//biar ga di klik dua kali, maka di disabled
        $.ajax({
            url : '<?php echo site_url("admin/armada/edit");?>',
            data : dataarmada,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('input[name=editarmada'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
                    $('#simpanarmada').attr('disabled',true);
                    $('#updatearmada').attr('disabled',false);
                    $.each(data.msg,function(k,v){
                        $('#id_armada').val(v['id_armada']);
                        $('#namaarmada').val(v['namaarmada']);
                        $('#rute').val(v['rute']);
                    })
                }else{
                    alert(data.msg);
                    $('input[name=editarmada'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
                $('input[name=editarmada'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
            }
        })
    }
    function deletearmada() {//delete armada
        if (confirm("Anda yakin akan menghapus data armada ini?")) {
            var id = $(this).data('idarmada');
            var dataarmada = {'id_armada':id};console.log(dataarmada);
            $.ajax({
                url : '<?php echo site_url("admin/armada/delete");?>',
                data : dataarmada,
                dataType : 'json',
                type : 'POST',
                success : function(data,status){
                    if (data.status!='error') {
                        $('#daftararmada').load('<?php echo current_url()." #daftararmada > *";?>');
                        resetarmada();//form langsung dikosongkan pas selesai input data
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
