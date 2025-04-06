<x-auth-layout>

    {{-- card data input --}}
    <x-card card-title="Data Input"
        card-body-class="px-3 py-2 d-flex justify-content-center"
        class="shadow-lg mb-3">

        {{-- form --}}
        <x-form class="border-0 shadow-none"
            action="{{route('add-data-input')}}"
            method="POST">

            {{-- csrf --}}
            @csrf

            <div class="row">
                <div class="col-sm-6 mb-3">
                    {{-- brgy --}}
                    <x-select id="select_brgy"
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

    {{-- data input list --}}
    <x-card card-title="Data Input List"
        card-body-class=""
        class="shadow-lg ">

        {{-- table --}}
        <x-table id="table-data-inputs"
            class=""
            table-class="w-100 table-hover">

            <thead class="align-middle">
                <th>No.</th>
                <th>Brgy</th>
                <th>X</th>
                <th>Y</th>
                <th>N</th>
                <th>P</th>
                <th>K</th>
                <th>Date</th>
                <th>Action</th>
            </thead>

            <tbody>

                @foreach ($data_inputs_data as $item)
                    <tr class="align-middle">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->brgy->name}}</td>
                        <td>{{$item->x_coordinate}}</td>
                        <td>{{$item->y_coordinate}}</td>
                        <td>{{$item->n}}</td>
                        <td>{{$item->p}}</td>
                        <td>{{$item->k}}</td>
                        <td>{{$item->created_at->format('Y-m-d')}}</td>
                        <td class="text-center">

                            {{-- dropdown --}}
                            <div class="dropdown">

                                {{-- toggler --}}
                                <i class="bi bi-three-dots-vertical"
                                    data-bs-toggle="dropdown"
                                    style="cursor: pointer;"></i>

                                {{-- menu --}}
                                <ul class="dropdown-menu">

                                    {{-- edit --}}
                                    <li class="dropdown-item edit-data-input-btn"
                                        style="cursor: pointer;"

                                        data-id="{{$item->encrypted_id}}"
                                        data-brgy-name="{{$item->brgy->name}}"
                                        data-x="{{$item->x_coordinate}}"
                                        data-y="{{$item->y_coordinate}}"
                                        data-n="{{$item->n}}"
                                        data-p="{{$item->p}}"
                                        data-k="{{$item->k}}"

                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-data-input">
                                        <i class="bi bi-pencil-square text-success" style="font-style: normal;"> Edit</i>
                                    </li>

                                    {{-- delete --}}
                                    <li class="dropdown-item delete-data-input-btn"
                                        style="cursor: pointer;"
                                        data-id="{{$item->encrypted_id}}">
                                        <i class="bi bi-trash text-danger" style="font-style: normal;"> Delete</i>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-table>
    </x-card>

    {{-- script --}}
    <script>
        document.addEventListener('DOMContentLoaded', ()=>{

            // init table-data-inputs datatable
            const table_data_inputs = new DataTable('#table-data-inputs', {
                responsive : true
            });

            // delete init
            delete_data_input(table_data_inputs);

            // edit init
            edit_data_input(table_data_inputs);

        });

        // delete data input
        function delete_data_input(table_data_inputs){
            table_data_inputs.on('click', '.delete-data-input-btn', function(e){
                e.stopImmediatePropagation();

                const id = e.currentTarget.getAttribute('data-id');

                // prompt delete confirmation
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(async (result) => {
                    /**
                     * if confirm then delete via fetch api
                     */
                    if (result.isConfirmed) {
                        /**
                         * get all toast element
                         * for success and error
                         */
                        const error_container = document.getElementById('toast-danger');
                        const success_container = document.getElementById('toast-success');

                        const error_message = document.getElementById('toast-danger-message');
                        const success_message = document.getElementById('toast-success-message');

                        /**
                         * try and catch
                         *
                         * fetch api for delete perform
                         */
                        try {
                            const response = await fetch(`/delete-data-input/${id}`, {
                                method : 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content
                                }
                            });

                            /**
                             * if response was not 200
                             * then throw new Error
                             */
                            if(!response.ok){
                                throw new Error("Failed to delete");
                            }
                            /**
                             * else success
                             * then reload page
                             */
                            if(response.ok){

                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);

                            }
                        } catch (error) {
                            /**
                             * catch errors and manage them
                             */
                            console.error(error.message);
                            error_message.textContent = "Failed to delete data input!, Pls try again, If the problem persist, Pls contact developer"
                            error_container.style.display = 'flex';

                            // show bootstrap toast
                            const toast_element = new bootstrap.Toast(document.querySelector('.toast'));
                            toast_element.show();
                        }
                    }
                });
            });
        }

        // edit data input
        function edit_data_input(table_data_inputs){
            table_data_inputs.on('click', '.edit-data-input-btn', function(e){
                e.stopImmediatePropagation();

                const edit_id = document.getElementById('edit_data_input_id');
                const x = document.getElementById('edit_x_coordinate');
                const y = document.getElementById('edit_y_coordinate');
                const n = document.getElementById('edit_n');
                const p = document.getElementById('edit_p');
                const k = document.getElementById('edit_k');


                edit_id.value = e.currentTarget.getAttribute('data-id');

                x.value = e.currentTarget.getAttribute('data-x');
                y.value = e.currentTarget.getAttribute('data-y');
                n.value = e.currentTarget.getAttribute('data-n');
                p.value = e.currentTarget.getAttribute('data-p');
                k.value = e.currentTarget.getAttribute('data-k');
            });
        }
    </script>

</x-auth-layout>