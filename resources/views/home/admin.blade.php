<x-app-layout title="Home Page">
    <x-slot name="ribbon">
        Home
    </x-slot>

    <div class="row d-flex justify-content-center">
        <x-box bgcolor="bg-warning">
            <h3 class="total-complaint">0</h3>
            <p>Total Complaint</p>
        </x-box>
        <x-box bgcolor="bg-warning">
            <h3 class="total-end">0</h3>
            <p>Complain End</p>
        </x-box>
        <div class="col-md-8">
            <x-card>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-1">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>SKPD</th>
                            <th>Complaint</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($maps as $i => $map)
                            <tr>
                                <td class="text-center">{{$i+1}}</td>
                                <td>{{$map['unit_kerja_nama']}}</td>
                                <td>
                                    <span class="total-skpd-{{$map['unit_kerja_kode']}}"></span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
