<x-app-layout title="Home Page">
    <div class="row-cols-1">
        <h3 class="mb-0">Home</h3>
    </div>
    <div class="row">
        <div class="col-md-4">
            <x-card>
                <div class="mb-3">
                    <label>Pegawai</label>
                    <select class="form-select select2serverside" name="" style="width: 100%">
                        <option selected disabled value="">.: Masukan NIP :.</option>
                        <option value="">.: Masukan NIP :.</option>
                        <option value="">.: Masukan NIP :.</option>
                    </select>
                </div>
            </x-card>
        </div>
        <div class="col-md-8">
            <div class="card-data-pegawai"></div>
        </div>
    </div>
    <pre>
    {{ json_encode(Auth::user(), 128) }}
    </pre>
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
                    minimumInputLength: 3,
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
                $(".select2serverside").change(function () {
                    const response = $(this).select2('data');
                    const data = response[0];
                    const htmlPegawai = htmlDataPegawai(data);
                    $('.card-data-pegawai').html(htmlPegawai)
                });
                const htmlDataPegawai = (data) => {
                    return `<x-card>
                        <x-slot name="header">Data Pegawai</x-slot>
                        <div class="table-responsive">
                            <table class="table table-borderless">
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
                                    <td>${data.pegawai_nama}</td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td>${data.pegawai_jabatan}</td>
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
                console.log(nip)
            })
        </script>
    @endslot
</x-app-layout>
