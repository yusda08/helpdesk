<x-app-layout title="Home Page">
    <div class="row-cols-1">
        <h3 class="mb-0">Form Helpdesk</h3>
    </div>
    <div class="row">
        <div class="col-md-4">
            <x-card>
                @slot('header')
                    Form Reset Akun
                @endslot
                <div class="mb-3">
                    <label>Pegawai</label>
                    <select class="form-select select2serverside" name="" style="width: 100%">
                        <option selected disabled value="">.: Masukan NIP :.</option>
                    </select>
                </div>
            </x-card>
        </div>
        <div class="col-md-8">
            <div class="card-data-pegawai"></div>
        </div>
    </div>
    @include('js.select2')
    @include('js.global')
    @slot('script')
        <script>
            $(function () {
                $('.select2serverside').select2({
                    theme: "bootstrap-5",
                    placeholder: "Masukan NIP Pegawai",
                    templateResult: format,
                    templateSelection: formatSelection,
                    minimumInputLength: 10,
                    multiple: false,
                    ajax: {
                        type: 'post',
                        url: BASEURL('pegawai/load-data'),
                        dataType: 'json',
                        quietMillis: 250,
                        data: function (params) {
                            return {
                                _token: "{{ csrf_token() }}",
                                search: params.term,
                                page: params.page
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.items
                            };
                        },
                    }
                    // cache: true;
                });
                $(".select2serverside").change(async function () {
                    const response = $(this).select2('data');
                    const nip = (response[0].nip).toString();
                    const dataApiPegawai = await ApiPegawai(nip);
                    // console.log(dataApiPegawai.data[0]);
                    const data = dataApiPegawai.data[0]
                    const htmlPegawai = htmlDataPegawai(data);
                    $('.card-data-pegawai').html(htmlPegawai)
                });


                const htmlDataPegawai = (data) => {
                    return `<x-card>
                        <x-slot name="header">Data Pegawai</x-slot>
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                <tr>
                                    <td width="30%"></td>
                                    <td width="3%"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>NIP</td>
                                    <td>:</td>
                                    <td>${data.nip}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>${data.nama}</td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td>${data.jabatan}</td>
                                </tr>
                                <tr>
                                    <td>Pangkat / Gol</td>
                                    <td>:</td>
                                    <td>${data.pangkat} (${data.golongan})</td>
                                </tr>
                                <tr>
                                    <td>Satuan Kerja</td>
                                    <td>:</td>
                                    <td>${data.satker}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <x-slot name="footer">
                        <button data-nip='${data.nip}' class="btn btn-warning btn-reset"><i class="bi bi-power"></i> Reset Akun</button>
                        </x-slot>
                    </x-card>`
                }
            });
            $(document).on('click', '.btn-reset', function () {
                const nip = $(this).data('nip');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "reset the account.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Reset it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: BASEURL('pegawai/reset-account'),
                            data: {nip, _token: "{{ csrf_token() }}"},
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
                            error: (jqXHR, textStatus, errorThrown) => {
                                Swal.fire('The Internet?', 'That thing is still around?', 'error');
                            }
                        })
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire('Cancelled', 'reset status canceled', 'error')
                    }
                })
            })
            const ApiPegawai = (nip) => {
                return $.getJSON(BASEURL(`pegawai/api-pegawai/${nip}`));
            }
        </script>
    @endslot
</x-app-layout>
