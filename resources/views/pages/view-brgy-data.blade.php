<x-guest-layout>
    <script async src="https://cse.google.com/cse.js?cx=a6beeb9ed21604882">
    </script>
    <div class="gcse-search"></div>
    {{-- hidden input --}}
    <x-input type="hidden"
        id="hidden-brgy-id"
        value="{{$brgyId}}"
        style="display: none;"/>

    {{-- card container --}}
    <x-card card-title="View Each Brgy Data">

        {{-- map container --}}
        <div class="w-100" id="map" style="height: 700px;"></div>

    </x-card>

    {{-- script --}}
    <script>
        document.addEventListener('DOMContentLoaded', ()=> {

            const id = document.getElementById('hidden-brgy-id').value;

            // init map
            get_map_data(id);
        });

        // get map data
        async function get_map_data(id){
            // error toaster
            const danger_container = document.getElementById('toast-danger');
            const danger = document.getElementById('toast-danger-message');

            try {
                // uri
                const uri = `/get-brgy-data/${id}`;
                // fetch data via fetch api
                const response = await fetch(uri);

                // if not okay
                if(!response.ok){

                    // toast danger
                    if(danger_container && danger){
                        danger.textContent = 'Unexptectd error, If the problem persist, Pls contact developer!';
                        danger_container.style.display = "flex";
                    }
                }

                else{
                    // parse json
                    const response_json = await response.json();

                    const data = response_json.data;

                    // make map
                    const map = L.map('map').setView([10.004, 125.22], 13);

                    // set as osm attribute
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors',
                        maxZoom: 19,
                    }).addTo(map);


                    // loop data for adding the marker
                    for (const element of data) {
                        const marker = L.marker([element.x_coordinate, element.y_coordinate]).addTo(map);

                        // get recommended plants and fertilizer
                        const recommended_plants = element.recommended.plants;
                        const recommended_fertilizer = element.recommended.fertilizers;

                        // add click event in the marker
                        marker.on('click', () => {

                            /**
                             * get card text details elements
                             */
                            const n = document.getElementById('n-value');
                            const p = document.getElementById('p-value');
                            const k = document.getElementById('k-value');
                            const more_npk_info = document.getElementById('more-npk-info');
                            const recommended_plant_list = document.getElementById('recommended-plants');
                            const recommended_fertilizer_list = document.getElementById('recommended-fertilizer');

                            // assign textcontent
                            n.textContent = element.n;
                            p.textContent = element.p;
                            k.textContent = element.k;

                            // loop recommended plant data
                            for (const plant of recommended_plants) {
                                recommended_plant_list.innerHTML += `<li>
                                                                        <a href="https://google.com/search?q=${encodeURIComponent(plant)}"
                                                                            target="_blank">
                                                                                ${plant}
                                                                        </a>
                                                                    </li>`;
                            }

                            // loop recommended fertilizer
                            for (const fertilizer of recommended_fertilizer) {
                                recommended_fertilizer_list.innerHTML += `<li>
                                                                            <a href="https://google.com/search?q=${encodeURIComponent(fertilizer)}"
                                                                                target="_blank">
                                                                                    ${fertilizer}
                                                                            </a>
                                                                        </li>`;
                            }

                            // show modal
                            const modal_details = new bootstrap.Modal(document.getElementById('modal-marker-details'));
                            modal_details.show();
                        });
                    }
                }
            } catch (error) {
                /**
                 * catch errors and display errors
                 */
                console.error(error.message);

                danger.textContent = 'Unexptectd error, If the problem persist, Pls contact developer!';
                danger_container.style.display = "flex";
            }
        }

    </script>
</x-guest-layout>