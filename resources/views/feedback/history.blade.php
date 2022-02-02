<x-app-layout title="Home Page">
    <x-slot name="ribbon">
        History
    </x-slot>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <x-card>
                @slot('header')
                    Data Complaint
                @endslot
                @if(session('msg'))
                    <x-alert col="6" type="{{session('type')}}" status="{{session('status')}}"
                             title="{{session('msg')}}"/>
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
                                <div>
                                    <a href="/feedback/detail/{{$complaint['ticket_code']}}"
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
    @include('js.global')
    @slot('script')
        <script>

        </script>
    @endslot
</x-app-layout>
