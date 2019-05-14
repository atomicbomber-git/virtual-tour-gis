<script>
    $(document).ready(function() {
        $("form.confirmed").submit(function(e) {
            e.preventDefault();
            let form = $(this);
            swal({
                icon: "warning",
                text: "Apakah Anda yakin Anda ingin melakukan tindakan ini?",
                dangerMode: true,
                buttons: ["Tidak", "Ya"],
            })
            .then(will_submit => {
                if (will_submit) {
                    form.off("submit").submit()
                }
            })
        })
    });
</script>