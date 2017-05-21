<?php
//
?>
<kml>
    <Document id="root_doc">
        <Schema name="{{$response['root_tag_name']}}" id="{{$response['root_tag_name']}}">
            <?php for ($i = 0; $i < count($response['attr_list']); $i++){ ?>
                <SimpleField name="{{$response['attr_list'][$i]}}" type="string"></SimpleField>
            <?php } ?>
        </Schema>
        <Folder><name>{{$response['root_tag_name']}}</name>
            <?php foreach ($response['boundary_details'] as $key => $value) { ?>
                <Placemark>
                    <Style>
                        <LineStyle>
                            <color>ff0000ff</color>
                        </LineStyle>
                        <PolyStyle><fill>0</fill></PolyStyle>
                    </Style>
                    <ExtendedData>
                        <SchemaData schemaUrl="#{{$response['root_tag_name']}}">
                        <?php foreach ($value as $k => $v) { ?>
                            <?php if ($k !== 'coordinates') {?>
                            <SimpleData name="{{$k}}">{{$v}}</SimpleData>
                            <?php } ?>
                        <?php } ?>
                        </SchemaData>
                    </ExtendedData>
                    <Polygon><outerBoundaryIs><LinearRing><coordinates>{{$value['coordinates']}}</coordinates></LinearRing></outerBoundaryIs></Polygon>
                </Placemark>
            <?php } ?>
        </Folder>
    </Document>
</kml>
