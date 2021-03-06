<x-app-layout title="Home Page">
    <x-slot name="ribbon">
        Complaint
    </x-slot>
    <div class="row">
        <div class="col-md-4">
            <x-card>
                @slot('header')
                    Form Input Data Keluhan
                @endslot
                <form method="POST" action="{{ route('complaint') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Kategori Keluhan</label>
                        <select class="select2" multiple="multiple" name="categories[]" style="width: 100%"
                                required>
                            @foreach($categories as $category)
                                <option value="{{$category}}">{{$category}}</option>
                            @endforeach
                        </select>
                    </div>
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
                    <x-input type="hidden" name="employee_satker" value="{{ Str::title($pegawai->satker) }}"/>
                    <x-input type="hidden" name="unit_kerja_kode" value="{{ Str::title($pegawai->kode_unker) }}"/>
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
                            <div class="row form-group">
                                <div class="col-md-12 d-flex justify-content-between">
                                    <div class="">
                                        <h5 class="card-title">Tiket : {{ $complaint['ticket_code'] }}</h5>
                                        <br>
                                        @php($explodCategories = explode(',', $complaint['ticket_categories']))
                                        @foreach($explodCategories as $category)
                                            <span class="badge bg-warning text-black fs-5">{{$category}}</span>
                                        @endforeach
                                    </div>
                                    <div class="text-right">
                                        <h6 class="card-title ">{{ date('d-m-Y', strtotime($complaint['ticket_date'])) }}
                                            <br>
                                            <small
                                                class="text-muted">At. {{date('H:i:s', strtotime($complaint['ticket_date']))}}
                                                , {{  $complaint->created_at->diffForHumans()}}</small>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-12">
                                    <p class="fs-5 mb-1">{{$complaint['ticket_title']}}</p>
                                    @php($explod = explode(',', $complaint['ticket_desc']))
                                    <ol class="list-group list-group-numbered">
                                        @foreach($explod as $ex)
                                            <li class="list-group-item">{{$ex}}</li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                            <div class="d-sm-flex justify-content-between mt-3">
                                @if($complaint['ticket_posting'] == 0)
                                    <div>
                                        <button class="btn btn-primary btn-upload-images"
                                                data-ticket_code="{{$complaint['ticket_code']}}">
                                            <i class="bi bi-pencil-square"></i> Input Image
                                        </button>
                                        <button data-ticket_code="{{$complaint['ticket_code']}}"
                                                class="btn btn-danger btn-delete"><i class="bi bi-trash"></i></button>
                                    </div>
                                    <div>
                                        <button data-ticket_code="{{$complaint['ticket_code']}}"
                                                class="btn btn-outline-primary btn-posting"><i class="bi bi-power"></i>
                                            Posting
                                        </button>
                                        <button class="btn btn-outline-warning btn-view"
                                                data-ticket_code="{{$complaint['ticket_code']}}">
                                            <i class="bi bi-search"></i> View Image
                                        </button>
                                    </div>
                                @else
                                    <div>
                                        <a href="/complaint/detail/{{$complaint['ticket_code']}}"
                                           class="btn btn-warning">
                                            <i class="bi bi-search"></i> View Feedback
                                        </a>
                                    </div>
                                    @if ($complaint['rating'])
                                        <div>
                                            Rating :
                                            @for ($i = 0; $i < $complaint['rating']['rating_star'] ; $i++)
                                                <span class="bi bi-star-fill"
                                                      style="font-size: 16pt;color: #ffaf11"></span>
                                            @endfor
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </x-card>
                    @endforeach
                @else
                    <x-card>
                        <p class="text-center mt-3 fs-4"> No Complaint found.</p>
                    </x-card>
                @endif
                <div class="d-flex justify-content-center">
                    {{ $complaints->links() }}
                </div>
            </x-card>
        </div>
    </div>
    <x-modal id="modal-images">
        <form method="POST" action="{{ route('complaint-images') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="formFile" class="form-label">Input File Images</label>
                <input class="form-control" type="file" name="image">
            </div>
            <x-input type="hidden" name="ticket_code" attr="readonly"/>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save changes</button>
        </form>
    </x-modal>
    <x-modal id="modal-view" type="modal-lg">
        <div class="row data-images"></div>
    </x-modal>
    @include('js.global')
    @slot('script')
        <script>
            $('.btn-upload-images').click(function () {
                const ticket_code = $(this).data('ticket_code');
                const tagModal = $('#modal-images');
                tagModal.modal('show');
                tagModal.find('.modal-title').text('Form Input Images')
                tagModal.find('.ticket_code').val(ticket_code)
            })
            $('.btn-view').click(async function () {
                const ticket_code = $(this).data('ticket_code');
                const tagModal = $('#modal-view');
                tagModal.modal('show');
                tagModal.find('.modal-title').text('View Image')
                const dataImages = await loadDataImages(ticket_code);
                const htmlImage = htmlImages(dataImages.data);
                $('.data-images').html(htmlImage);
            })
            $('.btn-delete').click(function () {
                const ticket_id = $(this).data('ticket_id')
                swalAction(BASEURL('complaint/delete'), {ticket_id, _token: "{{ csrf_token() }}"});
            });

            $('.btn-posting').click(function () {
                const ticket_code = $(this).data('ticket_code')
                swalAction(BASEURL(`complaint/posting/${ticket_code}`),
                    {_token: "{{ csrf_token() }}"},
                    {textBtn: 'Posting'}
                );
            });

            $(document).on('click', '.btn-delete-image', function () {
                const image_id = $(this).data('image_id')
                swalAction(BASEURL(`complaint-image/delete/${image_id}`), {_token: "{{ csrf_token() }}"});
            });

            const htmlImages = (images) => {
                let html = '';
                images.forEach(image => {
                    html += `<div class="col-md-6 mt-2 text-center">
                                <div class="card">
                                    <div class="image">
                                        <img src="${BASEURL(`storage/${image.file_image}`)}"
                                            class="img-fluid" style="height: 250px"/>
                                        <div class="overlay d-grid gap-2">
                                            <button data-image_id="${image.image_id}" class="btn btn-outline-danger btn-sm btn-delete-image"><i
                                                    class="bi bi-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>`
                });
                console.log(html)
                return html;
            }

            const loadDataImages = (ticket_code) => {
                return $.getJSON(BASEURL(`complaint-image/load-image/${ticket_code}`));
            }
        </script>
    @endslot
</x-app-layout>
