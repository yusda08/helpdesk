<x-app-layout title="Home Page">
    <x-slot name="ribbon">
        <a href="{{ route('feedback') }}">Feedback</a> / <small>Detail</small>
    </x-slot>
    <div class="row">
        <div class="col-md-5">
            <x-card>
                <h4>Ticket : {{ $complaint['ticket_code'] }}</h4>
                <table class="table table-sm">
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
                <div class="row mt-3">
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
        </div>
        <div class="col-md-7">
            <x-card>
                @slot('header')
                    <div class="d-flex justify-content-between">
                        <div>Data Feedback</div>
                        <div>
                            @if (!$complaint['ticket_status'])
                                <form action="/feedback/{{$complaint['ticket_code']}}"
                                      method="post">
                                    @csrf
                                    @method('put')
                                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-power"></i> Feedback
                                        End
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endslot
                @if (!$complaint['ticket_status'])
                    <form method="post" action="{{ route('feedback') }}" class="form-feedback">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <div class="form-floating">
                        <textarea class="form-control" name="feedback_desc" autofocus="true"
                                  placeholder="Leave a comment here"
                                  id="floatingTextarea2" style="height: 100px"></textarea>
                                    <label for="floatingTextarea2">Feedback Description</label>
                                </div>
                                <input type="hidden" name="user_id" value="{{ $cookie->id }}"/>
                                <input type="hidden" name="ticket_code" value="{{ $complaint['ticket_code'] }}"/>
                            </div>
                            <div class="col-md-3 d-grid gab-2">
                                <button type="submit" class="btn btn-warning btn-send">
                                    <i class="bi bi-send"></i> Send
                                </button>
                            </div>
                        </div>
                    </form>
                    <hr>
                @endif
                @foreach($complaint->feedbacks as $feedback)
                    <div class="direct-chat-msg {{$feedback->nip ? 'right' : ''}} mb-3">
                        <div class="direct-chat-infos clearfix">
                            <span
                                class="direct-chat-name {{$feedback->nip ? 'float-right' : 'float-left'}}">{{ $feedback->nip ?? 'Administrator' }}</span>
                            <span
                                class="direct-chat-timestamp {{$feedback->nip ? 'float-left' : 'float-right'}}">{{  $feedback->created_at->diffForHumans()}}</span>
                        </div>
                        <img class="direct-chat-img" src="/images/{{$feedback->nip ? 'avatar.png' : 'logo.png'}}">
                        <div class="direct-chat-text {{ $feedback->nip ? 'bg-gray-light' : '' }}">
                            {{ $feedback['feedback_desc'] }}
                        </div>
                    </div>
                @endforeach
            </x-card>
        </div>
    </div>
    @include('js.global')
    @slot('script')
        <script>
            $('.form-feedback').submit(function () {
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    beforeSend: () => {
                        $('.btn-send').html(`<i class="bi bi-arrow-repeat"></i> Loading . . .`).prop('disabled', true)
                    },
                    complete: () => {
                        $('.btn-send').html(`<i class="bi bi-send"></i> Send`).prop('disabled', false)
                    },
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
                });
                return false;
            });
        </script>
    @endslot
</x-app-layout>
