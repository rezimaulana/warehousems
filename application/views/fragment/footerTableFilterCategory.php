    <!-- jscript <script src=""></script> -->
    <script src="<?= base_url('assets/dist/jquery3.6.0/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/dist/popper-2.10.2/popper.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="<?= base_url('assets/dist/datatables140422/DataTables-1.11.5/js/jquery.dataTables.min.js') ?>"></script>
    <script>
        $(document).ready(function() {
        var table = $('#table1').DataTable({
            columnDefs: [
                {
                    targets: 3,
                    visible: false
                }
            ],
            scrollX: true
        });

        // Filter the table based on the selected category
        $('#category_filter').on('change', function() {
            var categoryID = $(this).val();

            if (categoryID) {
                table.column(3).search(categoryID).draw();
            } else {
                table.column(3).search('').draw();
            }
        });
    });
    </script>
    </body>
</html>