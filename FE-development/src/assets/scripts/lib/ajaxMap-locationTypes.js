import treeRenderer from './fancytree-renderer';
import places from './ajaxMap-places';
import $ from 'jquery';

const mapLocationTypes = {
    treeSelector: '#ajaxMapLocationTypesTree',
    ui: function(mapEntry) {

        const currLocationTypes = mapEntry.locationTypes,
            mapId = mapEntry.id;

        //remove empty option (since fluid doesn't build a select without option)
        for (var type in currLocationTypes) {

            $('<option/>').val(currLocationTypes[type].key)
                .text(currLocationTypes[type].title)
                .appendTo($(mapLocationTypes.treeSelector + mapId));
        }

        // set on change function for location types treeSelector
        $(mapLocationTypes.treeSelector + mapId).change(function() {

            places.updatePlaces(mapId);
        });
    },
    init: function(mapEntry) {

        if (mapEntry.locationTypes) {
            mapLocationTypes.ui(mapEntry);  //        @dirk ??
            /*here is a diff between mapEntry.locationtypes & mapEntry.settings.locationTypeTree */
            const $tree = treeRenderer.locationTypes(mapEntry);

            // console.log($tree)e
            // $tree.fancytree("option", "checkbox", true);
        }
    }
};

export default mapLocationTypes;
