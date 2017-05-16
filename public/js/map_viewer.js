$(document).ready(function () {

    // Initializing map properties
    var raster = new ol.layer.Tile({
        source: new ol.source.OSM()
    });

    var source = new ol.source.Vector({wrapX: false});

    var vector = new ol.layer.Vector({
        source: source
    });

    var map = new ol.Map({
        layers: [raster, vector],
        target: 'map',
        view: new ol.View({
            center: ol.proj.fromLonLat([131.070325, -23.826219]),
            zoom: 4
        })
    });
    // Initializing map properties ends here

    var typeSelect = document.getElementById('geometryType');

    /**
     * Clear existing features before drawing new feature
     */
    function drawStart() {
        source.clear();
    }

    var draw; // global so we can remove it later

    /**
     * Function for binding draw event on map
     */
    function addInteraction() {
        var value = typeSelect.value;
        if (value !== 'None') {
            draw = new ol.interaction.Draw({
                source: source,
                type: /** @type {ol.geom.GeometryType} */ (typeSelect.value)
            });
            map.addInteraction(draw);
            draw.on('drawstart', drawStart);
        }
    }


    /**
     * Handle change event for map drawing.
     */
    $('#geometryType').change(function () {
        if($(this).val()) {
            map.removeInteraction(draw);
            addInteraction();
        } else {
            map.removeInteraction(draw);
            source.clear();
        }
    });

    /**
     * Reset form inputs.
     */
    function resetInputs() {
        $('#boundaryCode').removeAttr('disabled');
        $('.boundary-loading').addClass('display-none');
    }


    /**
     * Handle change event for boundary type select.
     */
    $('#boundaryType').change(function () {
        var bType = $(this).val();
        if(bType) {
            $('.boundary-loading').removeClass('display-none');
            $.ajax({
                url: '',
                data: {boundaryType: bType},
                success: function () {
                    resetInputs();
                },
                error: function () {
                    resetInputs();
                }
            })
        } else {
            resetInputs();
        }
    });

    /**
     * Handle change event for boundary code select.
     */
    $('#boundaryCode').change(function () {
        var bCode = $(this).val();
        if(bCode) {
            $('.goemetry-type-selection').removeClass('display-none');
        }

    });


    /**
     * Export boundary submit action.
     */
    $('#exportBoundary').submit(function (event) {
        event.preventDefault();

    })
});

