<x-guest-layout>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

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
        window.onload = () => {
            const id = document.getElementById('hidden-brgy-id').value;
            // init map
            get_map_data(id);
        };

        // get map data
        async function get_map_data(id){
            try {
                // uri
                const uri = `/get-brgy-data/${id}`;
                // fetch data via fetch api
                const response = await fetch(uri);

                // if not okay
                if(!response.ok){
                    const danger_container = document.getElementById('toast-danger');
                    const danger = document.getElementById('toast-danger-message');

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
                    const map = L.map('map').setView([data[0].x_coordinate, data[0].y_coordinate], 13);

                    // set as osm attribute
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors',
                        maxZoom: 19,
                    }).addTo(map);

                    // loop data for adding the marker
                    for (const element of data) {
                        const marker = L.marker([element.x_coordinate, element.y_coordinate]).addTo(map);

                        // add click event in the marker
                        marker.on('click', () => {
                            const x_coordinate_input = document.getElementById('x_coordinate');

                            x_coordinate_input.value = element.x_coordinate;

                            // show modal
                            const modal_details = new bootstrap.Modal(document.getElementById('modal-marker-details'));
                            modal_details.show();
                        });
                    }
                }
            } catch (error) {

            }
        }

    </script>
</x-guest-layout>