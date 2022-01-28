<x-app-layout title="Home Page">
    <div class="row-cols-1">
        <h3 class="mb-0">Complaint</h3>
    </div>
    <div class="row">
        <div class="col-md-4">
            <x-card>
                @slot('header')
                    Form Complaint
                @endslot
                <div class="mb-3">
                    <label>Isi Form Complaint</label>
                </div>
            </x-card>
        </div>
        <div class="col-md-8">
            <x-card>
                @slot('header')
                    Data Complaint
                @endslot
                <div class="mb-3">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered responsive nowrap table-1" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Ticket</th>
                                <th>Diskripsi</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
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
