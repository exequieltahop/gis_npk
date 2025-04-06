document.addEventListener('DOMContentLoaded', ()=>{
    // set toast
    const toastElList = document.querySelector('.toast')

    if(toastElList){
        const toastList = new bootstrap.Toast(toastElList);

        toastList.show();
    }

    // init data table for list of brgys
    const tableBrgyList = new DataTable('#table-brgy-list', {
        responsive : true
    });

    // init edit brgy
    edit_brgy_init(tableBrgyList);

    // init delete brgy
    delete_brgy_init(tableBrgyList);
});

// edit brgy init
function edit_brgy_init(tableBrgyList){
    // edit button click
    tableBrgyList.on('click', '.edit-barangay-button', function(e){
        e.stopImmediatePropagation();

        /**
         * id and name
         */
        const id = e.currentTarget.dataset.id.toString().trim();
        const name = e.currentTarget.dataset.name.toString().trim();

        /**
         * get inputs for edit brgy form
         */
        const hidden_id = document.getElementById('edit-brgy-hidden-id');
        const edit_name = document.getElementById('edit-brgy-name');

        // asign values
        hidden_id.value = id;
        edit_name.value = name;

    });
}

// delete brgy init
function delete_brgy_init(tableBrgyList){
    tableBrgyList.on('click', '.delete-barangay-button', function(e){
        e.stopImmediatePropagation();

        /**
         * id and name
         */
        const id = e.currentTarget.dataset.id;

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
            try {
                const response = await fetch(`delete-brgy/${id}`, {
                    method : 'DELETE',
                    headers : {
                        'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                /**
                 * if success then
                 * show success message
                 * then reload
                 */
                if(response.ok){
                    document.body.innerHTML += `<div class="toast-container position-fixed top-0 end-0 p-3">
                                                    <div class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
                                                        <div class="toast-body">
                                                            <div class="d-flex justify-content-between p-2">
                                                                <strong style="text-transform: uppercase;">
                                                                    Successfully delete brgy
                                                                </strong>
                                                                <button class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;

                    // show bootstrap toast
                    const toast_element = new bootstrap.Toast(document.querySelector('.toast'));
                    toast_element.show();

                    setTimeout(()=>{ window.location.reload() },1500);
                }else{ // else throw new error
                    throw new Error("");

                }
            } catch (error) {
                /**
                 * catch and show error message
                 */
                console.error(error.message);
                document.body.innerHTML += `<div class="toast-container position-fixed top-0 end-0 p-3">
                                                <div class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
                                                    <div class="toast-body">
                                                        <div class="d-flex justify-content-between p-2">
                                                            <strong style="text-transform: uppercase;">
                                                                Failed to Delete, If the problem persist, pls contact developer!, Thank you
                                                            </strong>
                                                            <button class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="close"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`;

                // show bootstrap toast
                const toast_element = new bootstrap.Toast(document.querySelector('.toast'));
                toast_element.show();
            }
        }
        });

    });
}