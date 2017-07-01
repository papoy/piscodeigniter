<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-sm-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon glyphicon-globe"></span> Peta</h3>
        </div>
        <div class="panel-body">
          <div style="min-height:300px;" id="map-canvas">

          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon glyphicon-map-globe"></span> Koordinat Rute</h3>
        </div>
        <div class="panel-body">
          <table class="table table-striped">
            <th>No</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <tbody id="daftarkoordinat">
              <?php
              $no = 1;
              foreach ($this->cart->contents() as $koordinat) {
                ?>
                <tr>
                  <td><?php echo $no; ?></td>
                  <td><?php echo $koordinat['latitude']; ?></td>
                  <td><?php echo $koordinat['longitude']; ?></td>
                  </tr>
                <?php
                $no++;
              }
               ?>
            </tbody>
          </table>
          <div class="form-group">
            <label for="id_jalan">Jalan</label>
            <select class="form-control" name="id_jalan" id="id_jalan">
              <option value="">Pilih Nama Rute</option>
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
            <button type="button" class="btn btn-primary" name="simpan" id="simpan"><span class="glyphicon glyphicon-save"></span> Simpan</button>
            <button type="button" class="btn btn-warning" name="clearmap" id="clearmap"><span class="glyphicon glyphicon-refresh"></span> Clear Map</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="panel panel-heading">
        <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon glyphicon-list"></span> Daftar Polyline Jalan</h3/>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <th>No</th>
            <th>Nama Rute</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Keterangan</th>
            <th></th>
            <tbody id="daftarpolyline">
              <?php
              $no = 1;
              foreach ($itemjalanpolyline->result() as $jalan) {
                ?>
                  <tr>
                  <td><?php echo $no; ?></td>
                  <td><?php echo $jalan->namajalan ?></td>

                  <td>
                    <?php
                    foreach ($itemkoordinat->result() as $koordinat) {
                      if ($koordinat->id_jalan == $jalan->id_jalan) {
                        echo $koordinat->latitude."<br>";
                      }
                    }
                    ?>
                  </td>
                  <td>
                    <?php
                    foreach ($itemkoordinat->result() as $koordinat) {
                      if ($koordinat->id_jalan == $jalan->id_jalan) {
                        echo $koordinat->longitude."<br>";
                      }
                    }
                    ?>
                  </td>

                  <td><?php echo $jalan->keterangan;?></td>
                    <td><button type="button" id="viewpolyline" data-idjalan="<?php echo $jalan->id_jalan;?>" class="btn btn-sm btn-info" name="button" title="view polyline jalan"><span class="glyphicon glyphicon-eye-open"></span></button>
                    <button type="button" id="deletepolyline" data-idjalan="<?php echo $jalan->id_jalan;?>" class="btn btn-sm btn-danger" name="button" title="hapus polyline jalan"><span class="glyphicon glyphicon-trash"></span></button></td>
                </tr>
                <?php
              }

               ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCeCAhmBV1aJRpEyTpQzwZV-NS_zIfGdSE&sensor=false&language=id"></script>
<script>
  var poly;
  var map;
  function initialize() {
    var mapOptions = {
      zoom: 13,
      center: new google.maps.LatLng(-6.921582958819783, 107.6109903752149)
    };
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    var polyOptions = {
      strokeColor: '#000000',
      strokeOpacity: 1.0,
      strokeWeight: 3
    };
    poly = new google.maps.Polyline(polyOptions);
    poly.setMap(map);
    // Add a listener for the click event
    google.maps.event.addListener(map, 'rightclick', addLatLng);
    google.maps.event.addListener(map, "rightclick", function(event) {
      var lat = event.latLng.lat();
      var lng = event.latLng.lng();
      var datakoordinat = {'latitude':lat, 'longitude':lng};
      $.ajax({
        url : '<?php echo site_url("admin/koordinatjalan/addmarker") ?>',
        data : datakoordinat,
        dataType : 'json',
        type : 'POST',
        success : function(data,status){
          if (data.status!='error') {
            $('#daftarkoordinat').load('<?php echo current_url()."/ #daftarkoordinat > *" ?>');
          }else{
            alert(data.msg);
          }
        }
      })
    });
  }
  function addLatLng(event) {
    var path = poly.getPath();
    // Because path is an MVCArray, we can simply append a new coordinate
    // and it will automatically appear.
    path.push(event.latLng);

    // Add a new marker at the new plotted point on the polyline.
    var marker = new google.maps.Marker({
      position: event.latLng,
      title: '#' + path.getLength(),
      map: map
    });
  }
  google.maps.event.addDomListener(window, 'load', initialize);

  $(document).on('click','#simpan',simpan)
  .on('click','#clearmap',clearmap)
  .on('click','#deletepolyline',deletepolyline)
  .on('click','#viewpolyline',viewpolyline);
  function simpan(){
    var datapolyline = {'id_jalan':$('#id_jalan').val()};console.log(datapolyline);
    $.ajax({
      url : '<?php echo site_url('admin/koordinatjalan/create');?>',
      data : datapolyline,
      dataType : 'json',
      type : 'POST',
      success : function (data,status) {
        if (data.status!='error'){
          $('#daftarpolyline').load('<?php echo current_url()." #daftarpolyline > *";?>');
          clearmap(e);
        }else {
          alert(data.msg);
        }
      },
      error : function (x,t,m) {
        alert(x.responseText);
      }
    })
  }
  function clearmap() {
  //e.preventDefault();
        $.ajax({
            url : '<?php echo site_url("admin/koordinatjalan/clearmap") ?>',
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                      $('#daftarkoordinat').load('<?php echo current_url()."/ #daftarkoordinat > *" ?>');
                  }else{
                      alert(data.msg);
                  }
            }
        })
            var mapOptions = {
            zoom: 14,

            center: new google.maps.LatLng(-6.9034443, 107.5731164)
          };

          map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

          var polyOptions = {
            strokeColor: '#000000',
            strokeOpacity: 1.0,
            strokeWeight: 3
          };
          poly = new google.maps.Polyline(polyOptions);
          poly.setMap(null);
          initialize();
  }
  function deletepolyline() {
    if (confirm("Anda yakin akan mengkahapus data polyline jalan tersebut?")) {
      var id = $(this).data('idjalan');
      var datapolyline = {'id_jalan':id};console.log(datapolyline);
      $.ajax({
        url : '<?php echo site_url('admin/koordinatjalan/delete');?>',
        data : datapolyline,
        dataType : 'json',
        type : 'POST',
        success : function (data,status) {
          if (data.status!='error'){
            $('#daftarpolyline').load('<?php echo current_url()." #daftarpolyline > *";?>');
          }else {
            alert(data.msg);
          }
        },
        error : function (x,t,m) {
          alert(x.responseText);
        }
      })
    }
  }
  function viewpolyline() {
    var id = $(this).data('idjalan');
    var datapolyline = {'id_jalan':id};console.log(datapolyline);
    $.ajax({
      url : '<?php echo site_url('admin/koordinatjalan/read');?>',
      data : datapolyline,
      dataType : 'json',
      type : 'POST',
      success : function (data,status) {
        if (data.status!='error'){
          //$('#daftarpolyline').load('<?php echo current_url()." #daftarpolyline > *";?>');
          clearmap();
          $.each(data.msg,function(k,v){
            var lat = v["latitude"];
            var lng = v["longitude"];
            console.log(k,v);
            $.each(data.msg,function(m,n){
              createpolylinedatajalan(data.msg,n['namajalan'],lat,lng);
            })
            return false;
          })
          //end load polyline
        }else{
          alert(data.msg);
        }
      },
      error : function (x,t,m) {
        alert(x.responseText);
      }
    })
  }
  function createpolylinedatajalan(datakoordinat,nama,lat,lon){
    var mapOptions = {
      zoom: 13,
      //get center latlong
      center: new google.maps.LatLng(lat, lon),
      //mapTypeId: google.maps.MapTypeId.TERRAIN
      //end get center latlong
    };

    var map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

    var listkoordinat = [];
    $.each(datakoordinat,function(k,v){
      listkoordinat.push(new google.maps.LatLng(parseFloat(v['latitude']), parseFloat(v['longitude'])));
    })
    var pathKoordinat = new google.maps.Polyline({
      path: listkoordinat,
      geodesic: true,
      strokeOpacity: 1.0,
    });
    pathKoordinat.setMap(map);
  }
</script>
