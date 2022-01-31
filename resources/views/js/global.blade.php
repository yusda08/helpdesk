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

    const swalAction = (url, data, params = {}) => {
        const btnAction = params.textBtn ?? 'Delete ';
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        return swalWithBootstrapButtons.fire({
            title: params.title ?? `Apa anda yakin ?`,
            text: `Silahkan Klik Tombol ${btnAction} Untuk melakukan Aksi`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: btnAction,
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: data,
                    success: (response) => {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            }).then((result) => {
                                window.location.reload();
                            })
                        } else {
                            Swal.fire('Failed', response.message, 'error')
                        }
                    },
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire('Cancelled', 'reset status canceled', 'error')
            }
        })
    }
</script>
