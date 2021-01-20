
</body>

</html>
<script src="lib/jquery.js"></script>
<script src="lib/Semantic-UI-CSS-master/semantic.min.js"></script>
<script src="lib/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
<script src="lib/bootstrap-4.5.3-dist/js/jquery.dataTables.min.js"></script>
<script src="lib/bootstrap-4.5.3-dist/js/dataTables.fixedHeader.min.js"></script>
<script src="lib/bootstrap-4.5.3-dist/js/dataTables.responsive.min.js"></script>
<script src="lib/bootstrap-4.5.3-dist/js/dataTables.bootstrap4.min.js"></script>
<script src="lib/bootstrap-4.5.3-dist/js/custom.js"></script>
<script src="lib/select2-develop/dist/js/select2.min.js"></script>
<script src="lib/chart_js/dist/moment.js"></script>
<script src="lib/chart_js/dist/Chart.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable({"ordering": false,responsive: true});
} );

$(document).ready(function() {
    $('#example2').DataTable({"ordering": false,responsive: true,searching: false, paging: false, info: false});
} );
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});


</script>