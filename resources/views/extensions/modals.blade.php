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

