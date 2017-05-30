$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.extend({
        getUrlVars: function(){
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        },
        getUrlVar: function(name){
            return $.getUrlVars()[name];
        }
    });

    var feature = new ol.Feature({
    });

    var style = new ol.style.Style({
        stroke: new ol.style.Stroke({
            color: [255,0,0,0.6],
            width: 2
        }),
        fill: new ol.style.Fill({
            color: [255,0,0,0.2]
        }),
        zIndex: 1,
        image: new ol.style.Circle({
            radius: 5,
            fill: new ol.style.Fill({
                color: 'rgba(255, 255, 255, 0.6)'
            }),
            stroke: new ol.style.Stroke({
                color: '#319FD3',
                width: 1
            })
        })
    });

    var source = new ol.source.Vector({
        features: [feature]
    });

    var vectorLayer = new ol.layer.Vector({
        source: source,
        style: style
    });

    var view = new ol.View({
        // Set default view focusing Australia
        center: ol.proj.transform([134.960577, -25.824145], 'EPSG:4326', 'EPSG:3857'),
        zoom: 5
    });
    var map = new ol.Map({
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            }),
            vectorLayer
        ],
        target: 'map',
        controls: ol.control.defaults({
            attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
                collapsible: false
            })
        }),
        view: view
    });



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
     * Function to add a new feature
     */
    function addFeature(coordinates) {
        source.clear();
        var polyCoords = [];
        var coords = coordinates.split(' ');
        for (var i in coords) {
            var c = coords[i].split(',');
            polyCoords.push(ol.proj.transform([parseFloat(c[1]), parseFloat(c[0])], 'EPSG:4326', 'EPSG:3857'));
        }

        var feature = new ol.Feature({
            geometry: new ol.geom.Polygon([polyCoords])
        });
        source.addFeature( feature );
        var polygon = (feature.getGeometry());
        view.fit(polygon, {padding: [170, 50, 30, 150]});
    }

    /**
     * Function to get boundary codes
     * @param callback: Callback to set boundary code if query string has boundary code
     */
    function getBoundaryCodes(callback) {
        var bType = $('#boundaryType').val();
        if(bType) {
            $('.boundary-loading').removeClass('display-none');
            $.ajax({
                url: '/boundaries/get_sam_names',
                data: {boundaryType: bType},
                success: function (data) {
                    $('#boundaryCode').empty();
                    $.each(data, function(i, value) {
                        $('#boundaryCode').append($('<option>').text(value).attr('value', value));
                    });
                    resetInputs();
                    if(callback) callback();
                },
                error: function () {
                    resetInputs();
                }
            })
        } else {
            resetInputs();
        }
    }

    /**
     * Handle change event for boundary type select.
     */
    $('#boundaryType').change(function () {
        getBoundaryCodes();
    });


    /**
     * Handle change event for boundary code select.
     */
    $('#boundaryCode').change(function () {
        var bCode = $(this).val();
        var bType = $('#boundaryType').val();
        if(bCode) {
            $.ajax({
                url: '/boundaries/get_coordinates',
                method:'POST',
                data: {selBoundaryName: bCode, selBoundaryType: bType},
                success: function (data) {
                    if(data && data[0]) {
                        addFeature(data[0].coordinates);
                    } else  {
                        source.clear();
                    }
                },
                error: function () {
                    resetInputs();
                }
            });
        }
    });

    $('#submit').click(function () {
        var bCode = $("#boundaryCode").val();
        var bType = $('#boundaryType').val();
        if (bCode && bType){
            $('#submit').attr("href", '/export/kml/'+bType+'/'+bCode);
        }  else {
            $('#submit').attr("href", '#');
            alert("Please select a Boundary Type and Boundary code");
        }
    });

    /**
     * Function to set boundary code from query string
     */
    function setBoundaryCode() {
        $('#boundaryCode').val($.getUrlVar('boundaryCode'));
        $('#boundaryCode').trigger('change');
    }

    if($.getUrlVar('boundaryType') && $.getUrlVar('boundaryCode')) {
        $('#boundaryType').val($.getUrlVar('boundaryType'));
        getBoundaryCodes(setBoundaryCode);
    }
});
