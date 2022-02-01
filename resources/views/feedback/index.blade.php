<x-app-layout title="Home Page">
    <div class="row-cols-1">
        <h3 class="mb-0">Feedback</h3>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-card>
                @slot('header')
                    Data Complaint
                @endslot
                @if(session('msg'))
                    <x-alert col="6" type="{{session('type')}}" status="{{session('status')}}"
                             title="{{session('msg')}}"/>
                @endif
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
                                            class="text-muted">At. {{date('H:i:s', strtotime($complaint['ticket_date']))}}
                                            , {{  $complaint->created_at->diffForHumans()}}</small>
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
                            <div class="d-sm-flex justify-content-between mt-3">
                                <div>
                                    <a href="/feedback/detail/{{$complaint['ticket_code']}}"
                                       class="btn btn-warning btn-feedback">
                                        <i class="bi bi-search"></i> View Feedback
                                    </a>
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

        </script>
    @endslot
</x-app-layout>
