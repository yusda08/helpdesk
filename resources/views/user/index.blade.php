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
                    @slot('header')
                        Form Input User
                    @endslot
                    <div class="mb-3">
                        <label>Name</label>
                        <x-input name="name" placeholder="Name"/>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <x-input name="username" placeholder="Username"/>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <x-input type="password" name="password" placeholder="Password"/>
                    </div>
                    @slot('footer')
                        <button class="btn btn-warning"><i class="bi bi-save"></i> Simpan</button>
                    @endslot
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
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Reset</th>
                                <th>Status</th>
                                <th><i class="bi bi-code"></i></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </x-card>
                {{ json_encode($cookie, 128) }}
            @endif
        </div>
    </div>
    @include('js.global')
    @slot('script')
        <script>
        </script>
    @endslot
</x-app-layout>
