<style>
        /* Important part */
#modal-show-ss .modal-dialog{
    overflow-y: initial !important;
      max-width: 100%;
  max-height: 98%;
  padding: 0;
      margin: 5px 5px 5px 5px;

}
#modal-show-ss .modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}
#modal-show-ss .modal-content {
  height: 100%;
  border-radius: 0;
}

#modal-show-ss{
        padding-left: 1px;
    padding-right: 8px;
}

#tblcapt{
    font-size: 15px;
}


#modal-foto-fasad .modal-dialog{

      max-width: 34%;


}


#tblcapt td,  th {
    padding: .30rem;


}
#tblcapt  th {
    background-color: #eee;
    border: 1px solid #d3d4d6;
}

#tblcapt  .warning {
    background-color: #faf2cc;

}

#tblcapt  .danger {
    background-color: #ebcccc;

}
#tblcapt  .success{
    background-color: #d0e9c6;

}

#tblcapt td{

border: 1px solid rgba(145, 138, 143, 0.33) !important;
}

.hide{
    display: none  !important;
}

</style>
<div id="mapid"></div>

<?php
include 'modals/modal-show-ss.php';
?>
<script>

</script>