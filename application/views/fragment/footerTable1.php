    <!-- jscript <script src=""></script> -->
    <script src="<?= base_url('assets/dist/jquery3.6.0/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/dist/popper-2.10.2/popper.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/dist/datatables140422/DataTables-1.11.5/js/jquery.dataTables.min.js') ?>"></script>
    <script>
        $(document).ready(function() {
            $('#table1').DataTable({scrollX: true});
        } );
    </script>
    </body>
</html>