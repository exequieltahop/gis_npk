<x-guest-layout>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    {{-- custom style for legend --}}
    <style>
        .legend {
            line-height: 18px;
            color: #555;
        }

        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }
    </style>

    {{-- heat map container --}}
    <x-form id="heat-map-type-filter" class="mb-3">
        <x-select id="type" label="Select Element To Filter" :required="false" style="margin: 0 !important;">
            <option value="n" selected>Nitrogen</option>
            <option value="p">Phosphorus</option>
            <option value="k">Potassium</option>
        </x-select>

        <x-button type="submit" class-type="success" class="mt-3">
            <i class="bi bi-check fw-bold" style="font-style: normal;"> Submit</i>
        </x-button>
    </x-form>

    {{-- card heat map --}}
    <x-card class="shadow-lg" card-title="View All Brgy Polygon">
        {{-- map container --}}
        <div class="w-100" id="map" style="height: 500px;"></div>
    </x-card>

    @if (auth()->user())

    {{-- brgy list heat map --}}
    <x-card card-title="Brgy List" class="shadow-lg mt-3">
        <x-table id="table-brgy-list-heatmap">
            <thead>
                <th>No</th>
                <th>Barangay</th>
                <th>Polygon Status</th>
                <th>Polygon</th>
                <th>Action</th>
            </thead>
            <tbody>
                {{-- loop data --}}
                @forelse ($brgys as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->name}}</td>
                    <td>
                        {{ $item->polygon_coordinate == null ? 'None' : 'Has Polygon'}}
                    </td>
                    <td>
                        {{-- view map with polygon --}}
                        <x-button type="button" class-type="" class="text-info fw-bold"
                            data-id="{{$item->encrypted_id}}">
                            <i class="bi bi-eye" style="font-style: normal;"> View Polygon</i>
                        </x-button>
                    </td>
                    <td>
                        <div class="dropdown">
                            <i class="bi bi-three-dots-vertical" data-bs-toggle="dropdown"></i>
                            <ul class="dropdown-menu">

                                {{-- delete polygon --}}
                                <li class="dropdown-item py-2" style="cursor: pointer;"
                                    data-id="{{$item->encrypted_id}}">
                                    <i class="bi bi-trash-fill text-danger fw-bold" style="font-style: normal;"> Delete
                                        Polygon</i>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No Data</td>
                </tr>
                @endforelse
            </tbody>
        </x-table>
    </x-card>


    {{-- modals --}}
    <x-modal modal-id="modal-form-import-excel" modal-title="Select Barangay"> {{-- modal add polygon --}}

        {{-- form --}}
        <x-form class="border-0 shadow-none" id="form-select-brgy">
            {{-- brgy --}}
            <x-select id="select_brgy" label="Barangay" :required="false" style="margin: 0 !important;">

                <option value="" selected>--SELECT BRGY--</option>

                {{-- loop the brgys in the database --}}
                @foreach (App\Models\Barangay::getAll() as $item)
                <option value="{{$item->encrypted_id}}">{{$item->name}}</option>
                @endforeach

            </x-select>

            {{-- btns --}}
            <x-button type="submit" class-type="success" class="mt-3">

                <i class="bi bi-check-lg" style="font-style: normal;"> Add</i>

            </x-button>
        </x-form>
    </x-modal>

    {{-- script --}}
    <script src="{{asset('assets/js/heatmap.js')}}"></script>
    @else
    <script src="{{asset('assets/js/heatmap-user.js')}}"></script>
    @endif

</x-guest-layout>