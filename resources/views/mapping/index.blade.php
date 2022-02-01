<x-app-layout title="Home Page">
    <div class="row-cols-1">
        <h3 class="mb-0">Form Helpdesk</h3>
    </div>
    <div class="row">
        <div class="col-md-12">
            <x-card>
                @slot('header')
                    Data Mapping Sub Admin
                @endslot
                @if(session('msg'))
                    <x-alert col="4" type="{{session('type')}}" status="{{session('status')}}"
                             title="{{session('msg')}}"/>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-1">
                        <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Mapping SKPD</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $i => $user)
                            <tr>
                                <td class="text-center">
                                    <button data-user_id="{{ $user->id }}"
                                            class="btn btn-outline-primary btn-sm btn-add">
                                        <i class="bi bi-plus-circle"></i>
                                    </button>
                                </td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->username}}</td>
                                <td class="p-0">
                                    <ol class="list-group list-group-numbered m-0">
                                        @foreach($user->user_maps as $i => $map)
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    {{ $map->unit_kerja_nama }}
                                                </div>
                                                <button data-map_id="{{ $map->map_id }}"
                                                        class="btn btn-danger btn-sm rounded-pill btn-delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ol>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
    <x-modal id="modal-maps">
        <form method="POST" action="{{ route('mapping') }}">
            @csrf
            <table class="table table-bordered table-sm table-units">
                <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th><i class="bi bi-check-all"></i></th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
            <x-input type="hidden" name="user_id" attr="readonly"/>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save changes</button>
        </form>
    </x-modal>
    @include('js.global')
    @slot('script')
        <script>
            $('.btn-delete').click(function () {
                const map_id = $(this).data('map_id')
                swalAction(BASEURL(`mapping/delete/${map_id}`), {_token: "{{ csrf_token() }}"});
            })
            $('.btn-add').click(async function () {
                const user_id = $(this).data('user_id');
                const tagModal = $('#modal-maps');
                const loadUnits = await loadUnitKerja();
                const dataUnits = loadUnits.data;
                tagModal.modal('show');
                tagModal.find('.modal-title').text('Form Maps User Unit')
                tagModal.find('.user_id').val(user_id)
                $('.table-units > tbody').html('')
                let no = 1;
                dataUnits.forEach(unit => {
                    const tbody = `<tr>
                                    <td class="text-center">${no++}</td>
                                    <td>${unit.unit_kerja_nama}</td>
                                    <td>
                                        <div>
                                          <input class="form-check-input" type="checkbox" name="unit_kerja_kode[]" value="${unit.unit_kerja_kode}">
                                        </div>
                                    </td>
                                </tr>`;

                    $('.table-units > tbody').append(tbody);
                })
            })

            const loadUnitKerja = (params = {}) => {
                return $.getJSON(BASEURL('unit/load-unit'), params)
            }
        </script>
    @endslot
</x-app-layout>
