    <footer class="main-footer">
        <strong>Copyright &copy; <?= date("Y"); ?> <a href="http://hmtiudinus.org">HMTI Udinus</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url(); ?>/assets/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url(); ?>/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url(); ?>/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>/assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/assets/admin/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>/assets/admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>/assets/admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>/assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>/assets/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>/assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>/assets/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url(); ?>/assets/admin/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#myTable").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>