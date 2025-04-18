document.addEventListener('DOMContentLoaded', async () => {
    // Function to return color based on density
    function getColor(d) {
        return d > 90 ? '#800026' :
            d > 75 ? '#BD0026' :
                d > 60 ? '#E31A1C' :
                    d > 45 ? '#FC4E2A' :
                        d > 30 ? '#FD8D3C' :
                            d > 20 ? '#FEB24C' :
                                d > 10 ? '#FED976' :
                                    '#FFEDA0';
    }

    // Style function
    function style(feature) {
        return {
            fillColor: getColor(feature.properties.density),
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7
        };
    }

    // Optional interactivity
    function onEachFeature(feature, layer) {
        layer.on({
            mouseover: function (e) {
                var layer = e.target;
                layer.setStyle({
                    weight: 5,
                    color: '#666',
                    dashArray: '',
                    fillOpacity: 0.9
                });
                // Show tooltip with brgy name
                const props = feature.properties;

                if (props && props.name) {
                    layer.bindTooltip(props.name, {
                        permanent: false,
                        direction: 'center',
                        className: 'leaflet-tooltip-brgy'
                    }).openTooltip();
                }
            },
            mouseout: function (e) {
                geojson.resetStyle(e.target);
            },
            click: function (e) {
                map.fitBounds(e.target.getBounds());
            }
        });

        // Popup with name and density
        if (feature.properties && feature.properties.name) {
            layer.bindPopup(`<strong>${feature.properties.name}</strong><br>Density: ${feature.properties.density}`);
        }
    }

    // get heatmap data
    const heatMapData = await getHeatMapData(document.getElementById('type').value);

    // Initialize the map
    var map = L.map('map').setView([10.004, 125.22], 13);

    // Add base layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    /**
     * if heatMapData was not empty
     * then display polygon
     * else not
     */
    if (heatMapData.length != 0) {
        // Add GeoJSON as choropleth
        var geojson = L.geoJson(heatMapData, {
            style: style,
            onEachFeature: onEachFeature
        }).addTo(map);

        // Fit map to polygon bounds
        map.fitBounds(geojson.getBounds());
    }

    // Create a FeatureGroup to store editable layers
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    // Add drawing controls
    var drawControl = new L.Control.Draw({
        edit: {
            featureGroup: drawnItems
        },
        draw: {
            polygon: true,
            marker: false,
            polyline: false,
            rectangle: false,
            circle: false,
            circlemarker: false
        }
    });

    map.addControl(drawControl);

    // custom legend
    var legend = L.control({ position: 'bottomright' });

    legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend'),
            grades = [0, 10, 20, 30, 45, 60, 75, 90],
            labels = [];

        // loop through our density intervals and generate a label with a colored square for each interval
        for (var i = 0; i < grades.length; i++) {
            div.innerHTML +=
                '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
                grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
        }

        return div;
    };

    legend.addTo(map);


    // Listen for created shapes
    map.on('draw:created', function (event) {
        var layer = event.layer;
        drawnItems.addLayer(layer);

        // If you want the coordinates
        var coordinates = layer.getLatLngs();

        const modal = new bootstrap.Modal(document.getElementById('modal-form-import-excel')); //get modal

        modal.show(); // show modal

        const form = document.getElementById('form-select-brgy'); // get form

        const json_coordinates = JSON.stringify(coordinates[0].map(latlng => [latlng.lat, latlng.lng])); //convert into json

        // on submit form select brgy
        form.onsubmit = async (e) => {
            e.preventDefault();

            const formData = new FormData(form); // new FormData

            formData.append('coordinates', json_coordinates); // append coordinates into form data

            // perform fetch api post method
            try {
                const url = `/add-polygon`;
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                // if response was ok or not reload page
                if (!response.ok || response.ok) {
                    window.location.reload(); // reload to see toastr
                }
            } catch (error) {
                console.error(error.message);
            }
        }
    });

    // filter map
    filter_map(map, geojson, style, onEachFeature);

    // new data table table brgy list of polygon
    const table_list_polygon = new DataTable('#table-brgy-list-heatmap', {
        responsive: true
    })

    // init delete polygon
    delete_polygon(table_list_polygon);
});

// get heat map data
async function getHeatMapData(type) {
    const toast_element = new bootstrap.Toast(document.querySelector('.toast')); // Get the toast element
    try {
        // URL for fetching data
        const url = `/get-heatmap-data/${type}`;
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        // Check if response was successful
        if (!response.ok) {
            throw new Error("Failed to fetch data");
        }

        // Parse the response JSON
        const data = await response.json();

        // Log the fetched data for debugging
        if (data.length == 0) {
            return [];
        }
        // Prepare the heatmap data
        let counter = 1;
        let feature_data = [];

        for (const item of data) {
            // Log each item to verify structure

            // If polygon coordinates are already an array, don't parse them
            let coordinates = item.polygon_coordinate;
            if (typeof coordinates === 'string') {
                coordinates = JSON.parse(coordinates);  // Parse it if it's a string
            }

            // Reverse the coordinates (latitude, longitude) => (longitude, latitude)
            coordinates = coordinates.map(coord => [coord[1], coord[0]]);

            const obj = {
                "type": "Feature",
                "id": counter.toString().padStart(2, '0'),
                "properties": {
                    "name": item.name,
                    "density": item.avg
                },
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [coordinates] // Ensure coordinates are in an array
                }
            };

            feature_data.push(obj);
            counter++;
        }

        // Prepare the final state data for the heatmap
        let stateData = {
            "type": "FeatureCollection",
            "features": feature_data
        };

        return stateData; // Return the formatted state data

    } catch (error) {
        // Log the error for debugging
        console.error(error);

        // Show a toast message for failure
        const error_toastr = document.getElementById('toast-danger');
        const message = document.getElementById("toast-danger-message");

        message.textContent = "Failed to get heatmap data";
        error_toastr.style.display = 'block';

        toast_element.show();
    }
}

// submit filter
function filter_map(map, geojson, style, onEachFeature) {
    const form_filter = document.getElementById('heat-map-type-filter');


    form_filter.onsubmit = async (e) => {
        e.preventDefault();
        e.stopImmediatePropagation();

        try {
            const form_data = new FormData(e.target);
            const type = form_data.get('type');
            // URL for fetching data
            const url = `/get-heatmap-data/${type}`;
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            // Check if response was successful
            if (!response.ok) {
                throw new Error("Failed to fetch data");
            }

            // Parse the response JSON
            const data = await response.json();

            // Log the fetched data for debugging

            // Prepare the heatmap data
            let counter = 1;
            let feature_data = [];

            for (const item of data) {
                // Log each item to verify structure

                // If polygon coordinates are already an array, don't parse them
                let coordinates = item.polygon_coordinate;
                if (typeof coordinates === 'string') {
                    coordinates = JSON.parse(coordinates);  // Parse it if it's a string
                }

                // Reverse the coordinates (latitude, longitude) => (longitude, latitude)
                coordinates = coordinates.map(coord => [coord[1], coord[0]]);

                const obj = {
                    "type": "Feature",
                    "id": counter.toString().padStart(2, '0'),
                    "properties": {
                        "name": item.name,
                        "density": item.avg
                    },
                    "geometry": {
                        "type": "Polygon",
                        "coordinates": [coordinates] // Ensure coordinates are in an array
                    }
                };

                feature_data.push(obj);
                counter++;
            }

            // Prepare the final state data for the heatmap
            let stateData = {
                "type": "FeatureCollection",
                "features": feature_data
            };

            // if data was ready then reset map and update it
            if (stateData) {
                if (geojson) {
                    map.removeLayer(geojson);

                    // Add GeoJSON as choropleth
                    geojson = L.geoJson(stateData, {
                        style: style,
                        onEachFeature: onEachFeature
                    }).addTo(map);
                }


            }

        } catch (error) {
            // Log the error for debugging
            console.error(error);

            // Show a toast message for failure
            const error_toastr = document.getElementById('toast-danger');
            const message = document.getElementById("toast-danger-message");

            message.textContent = "Failed to get heatmap data";
            error_toastr.style.display = 'block';

            toast_element.show();
        }
    };

}

// delete polygon
function delete_polygon(table) {
    // onclick delete btn
    table.on('click', '.polygon-delete-btn', async function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        const id = e.currentTarget.dataset.id; //get encrypted id

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
            if (result.isConfirmed) { //if delete confirm delete data
                try {
                    /**
                     * url
                     * delete request fetch api
                     */
                    const url = `/delete-polygon/${id}`;
                    const response = await fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    // if not ok then error thrown else reload page
                    if (!response.ok) {
                        throw new Error("");
                    } else {
                        window.location.reload();
                    }
                } catch (error) {
                    // Log the error for debugging
                    console.error(error);

                    // Show a toast message for failure
                    const error_toastr = document.getElementById('toast-danger');
                    const message = document.getElementById("toast-danger-message");

                    message.textContent = "Failed to delete heatmap polygon";
                    error_toastr.style.display = 'block';

                    toast_element.show();
                }
            }
        });


    });
}
