<!-- page title area end -->
     <link href="<?php echo base_url();?>assets/admin/css/datepicker3.css" rel="stylesheet">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.3/jquery.timepicker.min.css">

<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-6 col-ml-12">
            <div class="row">
                <!-- Textual inputs start -->
                <div class="col-12 mt-5">
				<div class="col-12" style="display:inline-flex">
				<div class="form-group col-lg-3">
                                <label for="example-text-input" class="col-form-label">Date</label>
                                   <div class="input-group date" id="sandbox-container">
         <input type="text" name='mapdate' class="form-control" placeholder="dd-mm-yyyy" value = "<?php echo $mapdate;?>" >
         
      </div>
                            </div>
						<div class="text-right col-lg-3" style="margin:33px">
            <button type="button" id="button-filter" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
          </div>
		  </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Map</h4>
                           <div id="map" style="top :20px; border: 1px solid; width:100%;height:600px;float: right;"></div>
                        </div>
                    </div>
                </div>
                <!-- Textual inputs end -->
            </div>
        </div>
    </div>
</div>
   <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
<script>
function myMap() {
 
      //lat_txt='<?php if(!empty($latitude)){ echo $latitude; }else{ echo "29.31166"; } ?>';
//lng_txt='<?php if(!empty($longitude)){ echo $longitude; }else{ echo "47.48176599999999"; }  ?>';
      var mapProp= {
        center:new google.maps.LatLng("29.31","47.48"),
        zoom:8.8,
      };

  var map=new google.maps.Map(document.getElementById("map"),mapProp);

  //var myLatLng = {lat: parseFloat(lat_txt), lng: parseFloat(lng_txt)};

//   var marker = new google.maps.Marker({
//           position: myLatLng,
//           map: map,
//           title: 'Selected location'
//         });
  var geocoder = new google.maps.Geocoder;

  //latitude  = marker.getPosition().lat();               
 // longitude = marker.getPosition().lng();
  //var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content');
    infowindow.setContent(infowindowContent);
    var marker, i;

    <?php if(!empty($locations)){  foreach ($locations as $key => $value) { ?>
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(<?php echo $value->fld_lattitude; ?> ,<?php echo $value->fld_longitude; ?>),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(<?php echo $value->fld_user_id; ?>);
          infowindow.open(map, marker);
        }
      })(marker, i));
    
<?php } } ?>


      }
	  
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEYd7VWAGlhxRpTuEusCx9fhiGa4WuLpU&libraries=places&callback=myMap"
        async defer></script>
          <script src="<?php echo base_url();?>assets/admin/css/bootstrap-datepicker.js"></script>
  <script>
      $('#sandbox-container input').datepicker({
          autoclose: true,
          format:"dd-mm-yyyy"
      });

      $('#sandbox-container input').on('show', function(e){
          console.debug('show', e.date, $(this).data('stickyDate'));

          if ( e.date ) {
              $(this).data('stickyDate', e.date);

              format:"dd-mm-yyyy";
          }
          else {
              $(this).data('stickyDate', null);
          }
      });

      $('#sandbox-container input').on('hide', function(e){
          console.debug('hide', e.date, $(this).data('stickyDate'));
          var stickyDate = $(this).data('stickyDate');

          if ( !e.date && stickyDate ) {
              console.debug('restore stickyDate', stickyDate);
              $(this).datepicker('setDate', stickyDate);
              $(this).data('stickyDate', null);
              format:"dd-mm-yyyy";
          }
      });


  </script>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = '';

	var mapdate = $('input[name=\'mapdate\']').val();

	if (mapdate) {
		url += '?mapdate=' + encodeURIComponent(mapdate);
	}

	
	location = '<?php echo base_url().'admin/map';?>' + url;
});
//--></script> 