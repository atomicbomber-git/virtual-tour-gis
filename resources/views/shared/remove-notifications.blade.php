<script>
    // Remove notifications
    $(document).ready(() => {
        $('.notification').each((i, notification) => {
            setTimeout(() => { $(notification).fadeOut(); }, 3000)
        })
    })
</script>