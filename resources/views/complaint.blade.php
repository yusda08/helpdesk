<x-app-layout title="Home Page">
    <div class="row-cols-1">
        <h3 class="mb-0">Complaint</h3>
    </div>
    <div class="row">
        <div class="col-md-4">
            <x-card>
                @slot('header')
                    Form Input Deskripsi Komplain
                @endslot
                <form method="POST" action="{{ route('complaint') }}">
                    @csrf
                    <x-input title="Judul" name="ticket_title" attr="autofocus" value="{{old('ticket_title')}}"/>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control ticket_desc" name="ticket_desc"
                                  rows="5">{{ old('ticket_desc') }}</textarea>
                        @error('ticket_desc')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <span class="text-black-50 text-sm-start" style="font-size: 11pt">Gunakan Tanda KOMA (,) untuk membuat tulisan menurun.</span>
                    </div>
                    <x-input type="hidden" name="nip" value="{{ $pegawai->nip }}" attr="readonly required"/>
                    <x-input type="hidden" name="employee_name"
                             value="{{ $pegawai->gelar_depan.' '.$pegawai->nama.' '.$pegawai->gelar_belakang }}"/>
                    <x-input type="hidden" name="employee_position" value="{{ Str::title($pegawai->jabatan) }}"/>
                    <x-input type="hidden" name="employee_unit" value="{{ Str::title($pegawai->unker) }}"/>
                    <button class="btn btn-warning" type="submit">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </form>
            </x-card>
        </div>
        <div class="col-md-8">
            <x-card>
                @slot('header')
                    Data Komplain
                @endslot
                @if(session('msg'))
                    <x-alert type="{{session('type')}}" status="{{session('status')}}" title="{{session('msg')}}"/>
                @endif
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <form method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search"
                                       value="{{ request('search') }}" placeholder="Key word search . . .">
                                <button class="btn btn-outline-dark">
                                    <i class="bi bi-search"></i> Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @if($complaints->count())
                    @foreach($complaints as $complaint)
                        <x-card>
                            <div class="d-md-flex justify-content-between">
                                <div>
                                    <h5 class="card-title">Tiket : {{ $complaint['ticket_code'] }}</h5>
                                </div>
                                <div>
                                    <h5 class="card-title">Tanggal
                                        : {{ date('d-m-Y', strtotime($complaint['ticket_date'])) }}<br>
                                        <small
                                            class="text-muted">At. {{date('H:i:s', strtotime($complaint['ticket_date']))}}</small>
                                    </h5>
                                </div>
                            </div>
                            <span class="fs-5">{{$complaint['ticket_title']}}</span>
                            @php($explod = explode(',', $complaint['ticket_desc']))
                            <ol class="list-group list-group-numbered">
                                @foreach($explod as $ex)
                                    <li class="list-group-item">{{$ex}}</li>
                                @endforeach
                            </ol>
                            <p class="card-text">

                            </p>
                            <div class="d-md-flex justify-content-md-between">
                                <div>
                                    <button class="btn btn-primary btn-upload-images">
                                        <i class="bi bi-pencil-square"></i> Input Image
                                    </button>
                                    <a href="#" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                                    <button data-ticket_id="{{$complaint['ticket_id']}}"
                                            class="btn btn-danger btn-delete"><i class="bi bi-trash"></i></button>
                                </div>
                                <div>
                                    <button class="btn btn-outline-primary"><i class="bi bi-power"></i> Posting</button>
                                    <a href="#" class="btn btn-outline-warning"><i class="bi bi-search"></i> View</a>
                                </div>
                            </div>
                        </x-card>
                    @endforeach
                @else
                    <x-card>
                        <p class="text-center mt-3 fs-4"> No Complaint found.</p>
                    </x-card>
                @endif
            </x-card>
        </div>
    </div>
    @include('js.global')
    @slot('script')
        <script>
            $('.btn-delete').click(function () {
                const ticket_id = $(this).data('ticket_id')
                console.log(ticket_id)
                swalAction(BASEURL('complaint/delete'), {ticket_id, _token: "{{ csrf_token() }}"});
            });
        </script>
    @endslot
</x-app-layout>
