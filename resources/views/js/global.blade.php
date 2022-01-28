<script src="{{ mix('js/app.js') }}"></script>
<script>
    const BASEURL = (pathUrl = '') => {
        return `{{ url('') }}/${pathUrl}`
    };

    $('.table-1').DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: false,
        info: true,
        autoWidth: true,
        pageLength: 25
    });
    $('.table-2').DataTable({
        scrollY: '85vh',
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        ordering: false
    });

    $('.btn-logout').click(function () {
        const urlData = $(this).data('url');
        console.log(urlData)
        $.ajax({
            type: "POST",
            url: urlData,
            data: {_token: "{{ csrf_token() }}"},
            dataType: 'json',
            success: function (response) {
                if (response.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then((result) => {
                        window.location.href = BASEURL('');
                    })
                } else {
                    Swal.fire('Failed', response.message, 'error')
                }
            }

        });
    })
</script>
