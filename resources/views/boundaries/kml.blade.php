<?php
header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="kml_name.kml"');
?>
<kml xmlns="http://www.opengis.net/kml/2.2">
    <Document id="root_doc">
        <Schema name="{{$root_tag_name}}" id="{{$root_tag_name}}">
            <?php for ($i = 0; $i < count($attr_list); $i++){ ?>
                <SimpleField name="{{$attr_list[$i]}}" type="string"></SimpleField>
            <?php } ?>
        </Schema>
        <Folder><name>{{$root_tag_name}}</name>
            <?php foreach ($r as $key => $value) { ?>
                <Placemark>
                    <Style>
                        <LineStyle>
                            <color>ff0000ff</color>
                        </LineStyle>
                        <PolyStyle><fill>0</fill></PolyStyle>
                    </Style>
                    <ExtendedData>
                        <SchemaData schemaUrl="#{{$root_tag_name}}">
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
