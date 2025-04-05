<x-auth-layout>

    {{-- card --}}
    <x-card card-title="Data Input"
        card-body-class="px-3 py-2 d-flex justify-content-center"
        class="shadow-lg">

        {{-- form --}}
        <x-form class="border-0 shadow-none"
            action="{{route('add-data-input')}}"
            method="POST">

            {{-- csrf --}}
            @csrf

            <div class="row">
                <div class="col-sm-6 mb-3">
                    {{-- brgy --}}
                    <x-select id="brgy"
                        label="Barangay"
                        :required="false"
                        style="margin: 0 !important;">

                        <option value="" selected>--SELECT BRGY--</option>

                        {{-- loop the brgys in the database --}}
                        @foreach (App\Models\Barangay::getAll() as $item)
                            <option value="{{$item->encrypted_id}}">{{$item->name}}</option>
                        @endforeach
                    </x-select>
                    @error('brgy')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>


                {{-- x-coordinate --}}
                <div class="col-sm-6 mb-3">
                    <x-input type="number"
                        step="any"
                        id="x_coordinate"
                        name="x_coordinate"
                        label="X-Coordinate"
                        :required="true"
                        style="margin: 0 !important;"/>
                    @error('x_coordinate')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                {{-- y coordinate --}}
                <div class="col-sm-6 mb-3">
                    <x-input type="number"
                        step="any"
                        id="y_coordinate"
                        name="y_coordinate"
                        label="Y-Coordinate"
                        :required="true"
                        style="margin: 0 !important;"/>
                    @error('y_coordinate')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                {{-- Nitrogen --}}
                <div class="col-sm-6 mb-3">
                    <x-input type="number"
                        step="any"
                        id="n"
                        name="n"
                        label="N"
                        :required="true"
                        style="margin: 0 !important;"/>
                    @error('n')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                {{-- Nitrogen --}}
                <div class="col-sm-6 mb-3">
                    <x-input type="number"
                        step="any"
                        id="p"
                        name="p"
                        label="P"
                        :required="true"
                        style="margin: 0 !important;"/>
                    @error('p')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>

                {{-- Nitrogen --}}
                <div class="col-sm-6 mb-3">
                    <x-input type="number"
                        step="any"
                        id="k"
                        name="k"
                        label="K"
                        :required="true"
                        style="margin: 0 !important;"/>
                    @error('k')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>

            {{-- btns --}}
            <x-button
                type="submit"
                class-type="success">

                <i class="bi bi-check-lg"
                    style="font-style: normal;"> submit</i>

            </x-button>
        </x-form>

    </x-card>

    {{-- script --}}
    <script>
        window.onload = ()=>{

        };

    </script>
</x-auth-layout>