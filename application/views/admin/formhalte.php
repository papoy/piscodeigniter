
<div class="contents">
  <section class="form-register">
        <div class="container">
          <div class="row">
            <section class="col-md-8 col-md-sm-8">
              <form action="<?php echo site_url('admin/halte/'); ?>" method="post">
              <ul class="nav-tabs nav" role="tablist">
                <li role="presentation" class="active"><a href="#viewhalte" aria-controls="viewhalte" role="tab" data-toggle="tab">View Halte</a></li>
                <li role="presentation" ><a href="#createedit" aria-controls="createedit" role="tab" data-toggle="tab">Create/Edit Halte</a></li>
              </ul>
              <div class="tab-content">
              <div class="tab-pane fade in active" id="viewhalte" role="tabpanel">
                <div class="col-md-16 col-sm-16">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <div class="collapse navbar-collapse">
                          <ul class="nav navbar-nav">
                            <li><class="panel-title"><span class="glyphicon glyphicon-list"></span> Daftar Halte</h3></li>
                          </ul>
                          <ul class="nav navbar-nav navbar-right">
                            <li><input class="right" type="search" name="cari" placeholder="Search Halte..."> <input type="submit" name="q" value="Search"></li>
                          </ul>
                      </div>
                      </div>
                      <div class="panel-body">
                          <table class="table table-bordered">
                              <th>No</th>
                              <th>Nama Halte</th>
                              <th>Keterangan</th>
                              <th></th>
                              <tbody>
                                <?php
                                $no = 1;
                                if (count($ListHalte) > 0) {
                                foreach ($ListHalte as $halte){
                                  echo "<div class=\"letter\">";
                                 ?>
                                    <tr>
                                        <td><?php echo $no;?></td>
                                        <td><?php echo $halte['namahalte'];?></td>
                                        <td><?php echo $halte['keterangan'];?></td>
                                        <td>
                                            <button a href="#createedit" aria-controls="createedit" role="tab" data-toggle="tab" type="button" class="btn btn-sm btn-info" data-idhalte="<?php echo $halte['id_halte'];?>" name="edithalte<?php echo $halte['id_halte'];?>" id="edithalte"><span class="glyphicon glyphicon-edit" ></span></button>
                                            <button type="button" class="btn btn-sm btn-danger" data-idhalte="<?php echo $halte['id_halte'];?>" name="deletehalte<?php echo $halte['id_halte'];?>" id="deletehalte"><span class="glyphicon glyphicon-trash"></span></button>
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
                          <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Form Halte</h3>
                        </div>
                        <div class="panel-body">
                            <form action="#">
                                <div class="form-group">
                                  <label for="namahalte">Nama Halte</label>
                                  <input type="text" class="form-control" id="namahalte" placeholder="">
                                  <input type="hidden" name="id_halte" id="id_halte" value="">
                                </div>
                                <div class="form-group">
                                  <label for="keterangan">Keterangan</label>
                                  <textarea name="keterangan" class="form-control" id="keterangan"></textarea>
                                </div>
                                <div class="form-group">
                                  <button a href="#viewhalte" aria-controls="viewhalte" role="tab" data-toggle="tab" type="button" name="simpanhalte" id="simpanhalte" class="btn btn-primary">Simpan</button>
                                  <button type="button" name="resethalte"  id="resethalte" class="btn btn-warning">Reset</button>
                                  <button a href="#viewhalte" aria-controls="viewhalte" role="tab" data-toggle="tab" type="button" name="updatehalte" id="updatehalte" class="btn btn-info" disabled="true">Update</button>
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
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script>
	    $("body").on("click", ".pagination a", function() {
	        var url = $(this).attr('href');
	        $("#the-content").load(url);
	        return false;
	    });
	</script>
<script>
    $(document).on('click','#simpanhalte',simpanhalte)
    .on('click','#resethalte',resethalte)
    .on('click','#updatehalte',updatehalte)
    .on('click','#edithalte',edithalte)
    .on('click','#deletehalte',deletehalte);
    function simpanhalte() {//simpan halte
        var datahalte = {'namahalte':$('#namahalte').val(),
        'keterangan':$('#keterangan').val()};console.log(datahalte);
        $.ajax({
            url : '<?php echo site_url("admin/halte/create");?>',
            data : datahalte,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('#daftarhalte').load('<?php echo current_url()." #daftarhalte > *";?>');
                    resethalte();//form langsung dikosongkan pas selesai input data
                }else{
                    alert(data.msg);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
            }
        })
    }
    function resethalte() {//reset form halte
        $('#namahalte').val('');
        $('#keterangan').val('');
        $('#id_halte').val('');
        $('#simpanhalte').attr('disabled',false);
        $('#updatehalte').attr('disabled',true);
    }
    function updatehalte() {//update halte
        var datahalte = {'namahalte':$('#namahalte').val(),
        'keterangan':$('#keterangan').val(),
        'id_halte':$('#id_halte').val()};console.log(datahalte);
        $.ajax({
            url : '<?php echo site_url("admin/halte/update");?>',
            data : datahalte,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('#daftarhalte').load('<?php echo current_url()." #daftarhalte > *";?>');
                    resethalte();//form langsung dikosongkan pas selesai input data
                }else{
                    alert(data.msg);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
            }
        })
    }
    function edithalte() {//edit halte
        var id = $(this).data('idhalte');
        var datahalte = {'id_halte':id};console.log(datahalte);
        $('input[name=edithalte'+id+']').attr('disabled',true);//biar ga di klik dua kali, maka di disabled
        $.ajax({
            url : '<?php echo site_url("admin/halte/edit");?>',
            data : datahalte,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('input[name=edithalte'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
                    $('#simpanhalte').attr('disabled',true);
                    $('#updatehalte').attr('disabled',false);
                    $.each(data.msg,function(k,v){
                        $('#id_halte').val(v['id_halte']);
                        $('#namahalte').val(v['namahalte']);
                        $('#keterangan').val(v['keterangan']);
                    })
                }else{
                    alert(data.msg);
                    $('input[name=edithalte'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
                $('input[name=edithalte'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
            }
        })
    }
    function deletehalte() {//delete halte
        if (confirm("Anda yakin akan menghapus data halte ini?")) {
            var id = $(this).data('idhalte');
            var datahalte = {'id_halte':id};console.log(datahalte);
            $.ajax({
                url : '<?php echo site_url("admin/halte/delete");?>',
                data : datahalte,
                dataType : 'json',
                type : 'POST',
                success : function(data,status){
                    if (data.status!='error') {
                        $('#daftarhalte').load('<?php echo current_url()." #daftarhalte > *";?>');
                        resethalte();//form langsung dikosongkan pas selesai input data
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
