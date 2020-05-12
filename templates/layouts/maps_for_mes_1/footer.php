<!-- jQuery 2.1.4 -->
<script src="<?= $baseUrl ?>/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= $baseUrl ?>/assets/admin_lte_js/jquery-ui.min.js"></script>


<!--bootstrap js -->
<script src="<?= $baseUrl ?>/assets/maps_for_mes/bootstrap.bundle.js"></script>


<!-- select2 jquery js - поиск в выпад списке -->
<script src="<?= $baseUrl ?>/assets/js/select2/select2.min.js" type="text/javascript" charset="utf-8"></script>



<script src="<?= $baseUrl ?>/assets/toastr/js/toastr.min.js"></script>



<!-- Chosen jquery js -->
<script src="<?= $baseUrl ?>/assets/chosen_v1.8.2/chosen.jquery.js" type="text/javascript"></script>
<script src="<?= $baseUrl ?>/assets/chosen_v1.8.2/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= $baseUrl ?>/assets/chosen_v1.8.2/docsupport/init.js" type="text/javascript" charset="utf-8"></script>


<script src="<?= $baseUrl ?>/assets/leaflet/leaflet.js"></script>



<script  type="text/javascript" src="<?= $baseUrl ?>/assets/maps_for_mes/manual_leaflet.js"></script>


		<script src="<?= $baseUrl ?>/assets/maps_for_mes/js/classie.js"></script>
		<script src="<?= $baseUrl ?>/assets/maps_for_mes/js/gnmenu.js"></script>
		<script>
			//new gnMenu( document.getElementById( 'gn-menu' ) );


//                        $( ".gn-trigger" ).click(function() {
//  $( ".gn-menu-wrapper" ).toggle( "slow", function() {
//    // Animation complete.
//  });
//});

		</script>





<script>
$( "#gn-icon-button" ).click(function() {


  if($( "#theme_panel" ).hasClass('open_panel')){
  $( "#theme_panel" ).removeClass('open_panel');
  $( "#theme_panel" ).addClass('close_panel');
  $( "#theme_panel" ).hide();
  $('.leaflet-bottom.leaflet-left').show();
  $('.leaflet-top.leaflet-left').show();
  }
  else{
  $( "#theme_panel" ).removeClass('close_panel');
   $( "#theme_panel" ).addClass('open_panel');
   $( "#theme_panel" ).show();

   $('.leaflet-bottom.leaflet-left').hide();
   $('.leaflet-top.leaflet-left').hide();
  }



});
</script>

</body>
</html>