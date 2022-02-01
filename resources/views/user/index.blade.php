<x-app-layout title="Home Page">
    <div class="row-cols-1">
        <h3 class="mb-0">Form Helpdesk</h3>
    </div>
    <div class="row">
        <div class="col-md-4">
            <x-card>
                <form method="GET">
                    <div class="mb-3">
                        <label>Level User</label>
                        <select class="form-select" name="level" onchange="this.form.submit()">
                            <option disabled selected value="">.: Pilih Level {{$level_id}} :.</option>
                            @foreach($levels as $level)
                                <option {{ $level['level_id'] == $level_id ? 'selected' : '' }}
                                        value="{{$level['level_id']}}">{{$level['level_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </x-card>
            @if ($level_id)
                <x-card>
                    <form method="POST" action=" {{ route('user') }}">
                        @csrf
                        @slot('header')
                            Form Input User
                        @endslot
                        @if(session('msg'))
                            <x-alert type="{{session('type')}}" status="{{session('status')}}"
                                     title="{{session('msg')}}"/>
                        @endif
                        <div class="mb-3">
                            <label>Name</label>
                            <x-input name="name" placeholder="Name" value="{{ old('name') }}"/>
                        </div>
                        <div class="mb-3">
                            <label>Username</label>
                            <x-input name="username" placeholder="Username" value="{{ old('username') }}"/>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <x-input type="password" name="password" placeholder="Password"/>
                        </div>
                        <x-input type="hidden" name="level_id" value="{{$level_id}}"/>
                        <button type="submit" class="btn btn-warning"><i class="bi bi-save"></i> Simpan</button>
                    </form>
                </x-card>
            @endif

        </div>
        <div class="col-md-8">
            @if (!$level_id)
                <x-alert type="warning" status="false" title="Pilih level user terlebih dahulu."/>
            @else
                <x-card>
                    @slot('header')
                        Data User
                    @endslot
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-1">
                            <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Level User</th>
                                <th width="10%">Reset</th>
                                <th width="10%">Status</th>
                                <th width="5%"><i class="bi bi-code"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $i => $user)
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>{{ $user->user_level->level_name }}</td>
                                    <td>
                                        <button data-id="{{ $user['id'] }}"
                                                class="btn btn-outline-danger btn-sm btn-reset"><i
                                                class="bi bi-power"></i> Reset
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        @if ($user->is_active === 1)
                                            <span data-id="{{ $user['id'] }}"
                                                  class="badge btn btn-outline-primary text-black btn-status">
                                                <i class="bi bi-unlock"></i> Aktif
                                            </span>
                                        @else
                                            <span data-id="{{ $user['id'] }}"
                                                  class="badge btn btn-outline-danger text-black btn-status">
                                                <i class="bi bi-lock"></i> Non Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <button data-id="{{ $user['id'] }}" class="btn btn-danger btn-sm btn-delete"><i
                                                class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
            @endif
        </div>
    </div>
    @include('js.global')
    @slot('script')
        <script>
            $('.btn-delete').click(function () {
                const id = $(this).data('id')
                swalAction(BASEURL(`user/delete/${id}`), {_token: "{{ csrf_token() }}"});
            })

            $('.btn-status').click(function () {
                const id = $(this).data('id')
                swalAction(BASEURL(`user/update-status/${id}`), {_token: "{{ csrf_token() }}"}, {textBtn: 'Update'});
            })

            $('.btn-reset').click(function () {
                const id = $(this).data('id')
                swalAction(BASEURL(`user/reset-password/${id}`), {_token: "{{ csrf_token() }}"},
                    {textBtn: 'Reset', title: 'Reset Password Default 123456.'});
            })
        </script>
    @endslot
</x-app-layout>
