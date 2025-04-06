{{-- modal authenticate user --}}
<x-modal modal-id="modal-login"
    modal-title="Authorized User Only"
    modal-body-class="p-0">
    <x-form id="form-login"
            method="POST"
            action="{{ route('sign-in') }}"
            class="p-4 m-0"
            style="max-width: 500px;">

        @csrf
        <x-input type="email"
                    id="email"
                    name="email"
                    label="Email"
                    class=""
                    input-class=""
                    :required="true"/>

        <x-input type="password"
                    id="password"
                    name="password"
                    label="Password"
                    class=""
                    input-class=""
                    :required="true"/>

        {{-- btn --}}
        <div class="d-flex justify-content-end align-items-center gap-2" >
            <x-button type="submit" class-type="dark">
                <i class="bi bi-box-arrow-in-right" style="font-style: normal;"> Sign In</i>
            </x-button>
        </div>
    </x-form>
</x-modal>

{{-- add new brgy --}}
<x-modal modal-id="modal-add-brgy"
        modal-title="Add New Brgy">

    {{-- form --}}
    <x-form id="form-add-brgy"
        action="{{ route('add-brgy') }}"
        method="POST"
        class="border-0 shadow-none">

        @csrf

        <x-input id="brgy"
            name="brgy"
            label="Barangay"/>


        <x-button id="submit-form-add-new-brgy"
            type="submit"
            class-type="success">
            Submit
        </x-button>
    </x-form>
</x-modal>

{{-- list of brgys --}}
<x-modal modal-title="List of Barangays"
    modal-id="modal-show-brgys"
    modal-dialog-style='max-width: 800px;'>
    {{-- table --}}
    <x-table table-class="table-hover"
        id="table-brgy-list">
        <thead>
            <th>No.</th>
            <th>Name</th>
            <th>Date Added</th>
            <th>Action</th>
        </thead>
        <tbody>

            {{-- loop the brgys in the database --}}
            @foreach (App\Models\Barangay::getAll() as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->created_at->format('Y-m-d')}}</td>
                    <td class="text-center">

                        {{-- dropdown --}}
                        <div class="dropdown">
                            <i class="bi bi-three-dots-vertical"
                                data-bs-toggle="dropdown"></i>
                            <ul class="dropdown-menu">

                                {{-- edit toggler --}}
                                <li class="dropdown-item edit-barangay-button"
                                    data-id="{{$item->encrypted_id}}"
                                    data-name="{{$item->name}}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-edit-brgy"
                                    style="cursor: pointer;">
                                    <i class="bi bi-pencil-square text-primary"
                                        style="font-style: normal;"> Edit</i>
                                </li>

                                {{-- delete toggler --}}
                                <li class="dropdown-item delete-barangay-button"
                                    data-id="{{$item->encrypted_id}}"
                                    style="cursor: pointer;">
                                    <i class="bi bi-trash text-danger"
                                        style="font-style: normal;"> Delete</i>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </x-table>
</x-modal>


{{-- edit modal form --}}
<x-modal modal-id="modal-edit-brgy"
    modal-title="Edit Barangay">

    {{-- form --}}
    <x-form action="{{route('edit-brgy')}}"
        method="POST"
        class="border-0 shadow-none">
        @method('PUT')
        @csrf

        {{-- hidden id --}}
        <x-input type="hidden"
            class="m-0"
            id="edit-brgy-hidden-id"
            name="id"
            style="display: none;"/>

        {{-- brgy name --}}
        <x-input
            label="Name"
            id="edit-brgy-name"
            name="name"/>

        {{-- btns --}}
        <div class="d-flex justify-content-end gap-2">

            {{-- cancel --}}
            <x-button type="button"
                class-type="danger"
                id="edit-brgy-cancel-btn"
                data-bs-dismiss="modal">
                <i class="bi bi-x"
                style="font-style: normal;"> Cancel</i>
            </x-button>

            {{-- submit --}}
            <x-button type="submit"
                class-type="primary"
                id="edit-brgy-submit-btn">
                <i class="bi bi-check"
                    style="font-style: normal;"> Submit</i>
            </x-button>
        </div>
    </x-form>
</x-modal>

{{-- modal show marker details --}}
<x-modal modal-id="modal-marker-details"
    modal-title="Location Details"
    modal-dialog-style="width: 95%; max-width: 800px;">

    <div class="row">

        {{-- npks --}}
        <div class="col-sm-6">
            <strong>
                <i class="bi bi-clipboard2-data text-info" style="font-style: normal;"> NPK VALUES</i>
            </strong>

            <ul>
                <li>
                    <strong>N :</strong>
                    <span id="n-value">0</span>
                </li>
                <li>
                    <strong>P :</strong>
                    <span id="p-value">0</span>
                </li>
                <li>
                    <strong>K :</strong>
                    <span id="k-value">0</span>
                </li>
            </ul>

        </div>

        {{-- recom plants --}}
        <div class="col-sm-6">
            <strong>
                <i class="bi bi-check-all text-success" style="font-style: normal;"> RECOMMENDED PLANTS</i>
            </strong>

            <ul id="recommended-plants">
            </ul>

        </div>

        <hr>

        {{-- recommend fertilizer --}}
        <div class="col-sm-12">
            <strong>
                <i class="bi bi-check-all text-warning" style="font-style: normal;"> RECOMMENDED FERTILIZER</i>
            </strong>

            <ul id="recommended-fertilizer">
            </ul>

        </div>
    </div>
    {{-- btn close --}}
    <div class="d-flex justify-content-end">
        <button class="btn btn-danger" data-bs-dismiss="modal">
            <i class="bi bi-x" style="font-style: normal;"> Close</i>
        </button>
    </div>
</x-modal>

{{-- show modal edit data input --}}
<x-modal modal-id="modal-edit-data-input"
    modal-title="Edit Data Input"
    modal-dialog-style="width: 95%; max-width: 800px;">

    {{-- form --}}
    <x-form class="border-0 shadow-none"
        action="{{route('edit-data-input')}}"
        method="POST">
        @method('PUT')
        {{-- csrf --}}
        @csrf

        <input type="hidden" name="edit_id" id="edit_data_input_id">

        <div class="row">

            {{-- x-coordinate --}}
            <div class="col-sm-6 mb-3">
                <x-input type="number"
                    step="any"
                    id="edit_x_coordinate"
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
                    id="edit_y_coordinate"
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
                    id="edit_n"
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
                    id="edit_p"
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
                    id="edit_k"
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
                style="font-style: normal;"> Update</i>

        </x-button>
    </x-form>
</x-modal>

