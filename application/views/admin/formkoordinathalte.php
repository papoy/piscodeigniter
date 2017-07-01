<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-sm-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon glyphicon-globe"></span> Peta</h3>
        </div>
        <div class="panel-body">
          <div style="height:300px;" id="map-canvas">
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon glyphicon-map-globe"></span> Form Maker Halte</h3>
        </div>
        <div class="panel-body">
          <form>
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="latitude">Latitude</label>
                  <input type="text" class="form-control" id="latitude" placeholder="">
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group">
                  <label for="longitude">Longitude</label>
                  <input type="text" class="form-control" id="longitude" placeholder="">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="id_halte">Nama Halte</label>
              <select class="form-control" name="id_halte" id="id_halte">
                <option value="Pilih Nama halte"></option>
                <?php
                foreach ($itemhalte->result() as $halte) {
                  ?>
                  <option value="<?php echo $halte->id_halte;?>"><?php echo $halte->namahalte; ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
              <button type="button" class="btn btn-warning" id="reset" name="reset">Reset</button>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="panel panel-deefault">
        <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon plyphicon-list"></span>Daftar Maker Halte</h3>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <th>No</th>
            <th>Nama Halte</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Keterangan</th>
            <th></th>
            <tbody id="daftarmarker">
              <?php
              $no = 1;
              foreach ($itemkoordinat->result() as $koordinat) {
                ?>
                <tr>
                  <td><?php echo $no; ?></td>
                  <td><?php echo $koordinat->namahalte ?></td>
                  <td><?php echo $koordinat->latitude ?></td>
                  <td><?php echo $koordinat->longitude ?></td>
                  <td><?php echo $koordinat->keterangan ?>
                  <td><button type="button" id="viewmarker" data-idkoordinathalte="<?php echo $koordinat->id_koordinathalte?>" class="btn btn-sm btn-info" name="button" title="view marker halte"><span class="glyphicon glyphicon-eye-open"></span></button>
                  <button type="button" id="deletemarker" data-idkoordinathalte="<?php echo $koordinat->id_koordinathalte?>" class="btn btn-sm btn-danger" name="button" title="hapus marker halte"><span class="glyphicon glyphicon-trash"></span></button></td>
                </tr>
                <?php
                $no++;
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
  var map;
  var markers = [];

  function initialize() {
      var mapOptions = {
      zoom: 13,
      // Center di Bandung
      center: new google.maps.LatLng(-6.921582958819783, 107.6109903752149)
      };

      map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

      // Add a listener for the click event
      google.maps.event.addListener(map, 'rightclick', addLatLng);
      google.maps.event.addListener(map, "rightclick", function(event) {
        var lat = event.latLng.lat();
        var lng = event.latLng.lng();
        $('#latitude').val(lat);
        $('#longitude').val(lng);
          //alert(lat +" dan "+lng);
      });
  }
  function addLatLng(event) {
        var marker = new google.maps.Marker({
        position: event.latLng,
        title: 'Simple GIS',
        map: map
        });
        markers.push(marker);
    }
    function addMarker(nama,location) {
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title : nama
        });
        markers.push(marker);
    }
    function clearmap(){
        //e.preventDefault();
        $('#latitude').val('');
        $('#longitude').val('');
        setMapOnAll(null);
    }
    //buat hapus marker
    function setMapOnAll(map) {
      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
      }
      markers = [];
    }
 google.maps.event.addDomListener(window, 'load', initialize);

 $(document).on('click', '#simpan', simpan)
 .on('click', '#viewmarker', viewmarker)
 .on('click', '#deletemarker', deletemarker)
 .on('click', '#reset', reset);
 function simpan() {
   var datamarker = {'id_halte':$('#id_halte').val(),
   'latitude':$('#latitude').val(),
   'longitude':$('#longitude').val()};console.log(datamarker);
   $.ajax({
     url : '<?php echo site_url("admin/koordinathalte/create") ?>',
     dataType : 'json',
     data : datamarker,
     type : 'POST',
     success : function(data,status){
       if (data.status!='error') {
         reset();
         $('#daftarmarker').load('<?php echo current_url()." #daftarmarker > *"; ?>');
       }else{
         alert(data.msg);
       }
     },
     error : function (x,t,m) {
       alert(x.responseText);
      }
  })
}
function reset() {
   $('#id_halte').val('');
   $('#latitude').val('');
   $('#longitude').val('');
   clearmap();
}
function viewmarker() {
   var id = $(this).data('idkoordinathalte');
   var datamarker = {'id_koordinathalte':id};console.log(datamarker);
   $.ajax({
     url : '<?php echo site_url("admin/koordinathalte/read") ?>',
     dataType : 'json',
     data : datamarker,
     type : 'POST',
     success : function(data,status){
       if (data.status!='error') {
         //reset();
         //$('#daftarmarker').load('<?php echo current_url()." #daftarmarker > *"; ?>');
         $.each(data.msg,function(k,v){
           $('latitude').val(v['latitude']);
           $('longitude').val(v['longitude']);
           $('id_halte').val(v['id_halte']);
           var myLatLng = {lat: parseFloat(v["latitude"]), lng: parseFloat(v["longitude"])};
           addMarker(v['namahalte'],myLatLng);
         })
       }else{
         alert(data.msg);
       }
     },
     error : function (x,t,m) {
       alert(x.responseText);
      }
  })
}

function deletemarker() {
  if (confirm("Anda yakin akan menghapus data koordinat halte?")) {
    var id = $(this).data('idkoordinathalte');
    var datamarker = {'id_koordinathalte':id};console.log(datamarker);
    $.ajax({
      url : '<?php echo site_url("admin/koordinathalte/delete") ?>',
      dataType : 'json',
      data : datamarker,
      type : 'POST',
      success : function(data,status){
        if (data.status!='error') {
          //reset();
          $('#daftarmarker').load('<?php echo current_url()." #daftarmarker > *"; ?>');
        }else{
          alert(data.msg);
        }
      },
      error : function (x,t,m) {
        alert(x.responseText);
       }
   })
  }
}
</script>
