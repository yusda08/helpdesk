<x-app-layout title="Home Page">
    <div class="row-cols-1">
        <h3 class="mb-0"><a href="{{ route('feedback') }}">Feedback</a> / <small>Detail</small></h3>
    </div>
    <div class="row">
        <div class="col-md-5">
            <x-card>
                <h4>Ticket : {{ $complaint['ticket_code'] }}</h4>
                <table class="table">
                    <tbody>
                    <tr>
                        <td width="30%">Judul</td>
                        <td width="3%">:</td>
                        <td class="col-auto">{{ $complaint['ticket_title'] }}</td>
                    </tr>
                    <tr>
                        <td width="30%">Keterangan</td>
                        <td width="3%">:</td>
                        <td class="col-auto">
                            @php($explod = explode(',', $complaint['ticket_desc']))
                            <ol class="list-group list-group-numbered">
                                @foreach($explod as $ex)
                                    <li class="list-group-item">{{$ex}}</li>
                                @endforeach
                            </ol>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Tanggal / Jam</td>
                        <td width="3%">:</td>
                        <td class="col-auto">
                            {{ date('d-m-Y', strtotime($complaint['ticket_date'])) }}
                            At. {{date('H:i:s', strtotime($complaint['ticket_date']))}}
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Pengirim</td>
                        <td width="3%">:</td>
                        <td class="col-auto">
                            NIP. {{ $complaint['nip'] }}<br>
                            {{ $complaint['employee_name'] }}
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Unit Kerja</td>
                        <td width="3%">:</td>
                        <td class="col-auto">
                            {{ $complaint['employee_unit'] }}
                        </td>
                    </tr>
                    <tr>
                        <td width="30%">Satuan Kerja</td>
                        <td width="3%">:</td>
                        <td class="col-auto">
                            {{ $complaint['employee_satker'] }}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="row">
                    @foreach($complaint['images'] as $image)
                        <div class="col-md-6">
                            <a href="{{ asset('storage/'.$image['file_image']) }}" target="_blank">
                                <img src="{{ asset('storage/'.$image['file_image']) }}"
                                     class="img-fluid" style="height: 250px"/>
                            </a>
                        </div>
                    @endforeach
                </div>
            </x-card>
            <pre>
                {{ json_encode($complaint, 128) }}
            </pre>
        </div>
        <div class="col-md-7">
            <x-card>
                @slot('header')
                    <div class="d-flex justify-content-between">
                        <div>Data Feedback</div>
                        <div>
                            <form action="/feedback/{{$complaint['ticket_code']}}"
                                  method="post">
                                @csrf
                                @method('put')
                                <button class="btn btn-danger btn-sm"><i class="bi bi-power"></i> Feedback End</button>
                            </form>
                        </div>
                    </div>
                @endslot
                <div class="row mb-3">
                    <div class="col-md-9">
                        <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here"
                                  id="floatingTextarea2" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Feedback Description</label>
                        </div>
                    </div>
                    <div class="col-md-3 d-grid gab-2">
                        <button class="btn btn-outline-warning"><i class="bi bi-send-check"></i> Send</button>
                    </div>
                </div>
                <hr>

            </x-card>
        </div>
    </div>
    @include('js.global')
    @slot('script')
        <script>

        </script>
    @endslot
</x-app-layout>
