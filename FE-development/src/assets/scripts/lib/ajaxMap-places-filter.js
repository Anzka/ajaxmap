import treeRenderer  from './fancytree-renderer'
import layers from './map-layers'

import {getSelectedKeys} from './map-helpers'
import {fancytreeSelector} from './fancytree-renderer'
import $ from 'jquery';
/**
 * Updates all filter (trees)
 * Determines for all nodes in all filter trees whether
 * they should be shown.
 * A node in a filter tree should be visible if at least
 * one node in the result tree (placesTree) has the
 * according option (for instance if it belongs to a region)
 *
 * @param placesTree The places tree
 * @return void
 *
 * formals :updateFilter
 */

const _ = {
    setActive: (placInstance, activeState) => {

        if (placInstance.active === activeState) {
            placInstance.updateMarker = false;

        } else {
            placInstance.updateMarker = true;
        }

        placInstance.active = activeState;
    },
    updateMarkers: (mapEntry) => {
        var placeCnt = 0,
            toUpdate = 0,
            active = 0;
        for (var key in  mapEntry.placeInstances) {
            const placInstance = mapEntry.placeInstances[key],
                marker = placInstance.marker;

            placeCnt++

            if (placInstance.updateMarker) {
                toUpdate++

                if (placInstance.active) {
                    marker.setMap(mapEntry.googleMap);

                    active++
                } else {
                    marker.setMap(null)
                }
            }
        }

        console.log('placeCnt', placeCnt,'toUpdate', toUpdate,'active', active);
    }

};

function update($rootNode, mapEntry) {
    const filters = mapEntry.settings.placesTree.updateFilters;

    $.each(filters, function(filterName, filter) {
        const treeSelector = '#' + filter.treeName + mapEntry.id;

        try {
            const tree = $(treeSelector).fancytree('getTree');
            const children = $rootNode.children
            const placeKeys = getKeysByAttribute(children, filterName);

            filterTree(tree, placeKeys);

            if (filterName === 'regions' && filter.updateLayers) {

                var selectedKeys = getSelectedKeys(treeSelector);
                layers.update(mapEntry, selectedKeys);
            }
        } catch (err) {
            //todo filter not initalised eg location typd:88??@dirk--everytime locationTypes
            console.log('treeSelector---->', treeSelector)
            console.error(err)
        }
    });
}

/**
 * Searches all children for an attribute in their data property
 * and returns a unique array of keys for this attribute
 *
 * @param children
 * @param name
 * @return Array
 */
function getKeysByAttribute(children, name) {
    var keys = [];
    $.each(children, function(index, child) {
        if (child.data.hasOwnProperty(name)) {
            var attribute = child.data[name];
            if (attribute !== undefined &&
                attribute !== null &&
                attribute.hasOwnProperty('key') && !keys[attribute.key]) {
                keys.push(attribute.key);
            } else {
                if (attribute instanceof Array) {
                    for (var i = 0, k = attribute.length; i < k; i++) {
                        if (attribute[i].hasOwnProperty('key') && keys.indexOf(attribute[i].key) < 0) {
                            keys.push(attribute[i].key);
                        }
                    }
                }
            }
        }
    });

    return keys;
}

/**
 * Filters a tree by a unique array of keys
 * A node will be visible if its key is in the this array
 *
 * @param tree Fancy tree
 * @param keys Unique array of keys
 */
function filterTree(tree, keys) {
    const options = {autoExpand: true};

    tree.filterNodes(function(node) {
        return (keys.indexOf(parseInt(node.key)) != -1);
    }, options);
}

/**
 * Shows places which match all constraints
 * defined by region, place group, location type or category selector
 *
 * @param mapEntry
 */
function showMatchingPlaces(mapEntry) {

    var mapId = mapEntry.id,
        mapPlaces = mapEntry.places,
        selectedPlaces,
        clusterer = mapEntry.markerClusterer;

    let selectedLocationTypeKeys = getSelectedKeys(fancytreeSelector.locationType + mapId),
        selectedCategoryKeys = getSelectedKeys(fancytreeSelector.category + mapId),
        selectedRegionKeys = getSelectedKeys(fancytreeSelector.regions + mapId),
        selectedPlaceGroupKeys = getSelectedKeys(fancytreeSelector.placeGroup + mapId),

        selectedLocationType = 0;

    // get selected location type. This should be one or none
    if (selectedLocationTypeKeys.length) {
        selectedLocationType = selectedLocationTypeKeys[0];
    }

    clusterer.removeMarkers(mapPlaces.map(item => item.placeInstance.marker));

    selectedPlaces = mapPlaces.filter((place) => {
        const placeInstance = place.placeInstance
        console.log('---------------->', placeInstance)
        /* if (!mapMarkers[i]) {
         // marker does not exist, create it
         mapMarkers[i] = markers.create(mapEntry, place);
         } else {*/
        var hasAnActiveCategory = 0,
            hasAnActiveRegion = 0,
            hasAnActivePlaceGroup = 0;

        /*-->  if(marker.place === place){
         alert('same')
         }
         */

        if (selectedCategoryKeys && place.categories) {
            $.each(place.categories, function() {
                hasAnActiveCategory = ($.inArray(parseInt(this.key), selectedCategoryKeys) > -1);
                return (!hasAnActiveCategory);
            });
        }

        if (selectedRegionKeys.length && place.regions) {
            $.each(place.regions, function() {
                hasAnActiveRegion = ($.inArray(parseInt(this.key), selectedRegionKeys) > -1);
                return (!hasAnActiveRegion);
            });
        }

        if (selectedPlaceGroupKeys.length && place.placeGroups) {

            $.each(place.placeGroups, function() {
                hasAnActivePlaceGroup = ($.inArray(parseInt(this.key), selectedPlaceGroupKeys) > -1);

                return (!hasAnActivePlaceGroup);
            });
        }

        //----
        if (
            (place.locationType.key === selectedLocationType || !selectedLocationTypeKeys.length)
            && (hasAnActiveCategory || !selectedCategoryKeys.length)
            && (hasAnActiveRegion || !selectedRegionKeys.length)
            && (hasAnActivePlaceGroup || !selectedPlaceGroupKeys.length)
        ) {
            _.setActive(placeInstance, true)
            return true;
        }

        _.setActive(placeInstance, false)
        return false;
    });

    //   clusterer.addMarkers(mapMarkers);

    // update only if mapEntry is already initialized
    // if (typeof mapEntry.markers !== 'undefined') {

    //   console.log(selectedPlaces)
    //return;

    //-->    marker.setMap(map);

    _.updateMarkers(mapEntry);
    treeRenderer.update.places(mapEntry, selectedPlaces);
    // }
    //mapEntry.markers = mapMarkers;
}

/**
 * Shows places from a list of selected places
 *
 * @param mapEntry
 * @param selectedPlaceKeys
 * @returns {*}
 */
function showSelectedPlaces(mapEntry, selectedPlaceKeys) {

    var map = mapEntry.googleMap,
        mapPlaces = mapEntry.places,
        clusterer = mapEntry.markerClusterer;
    //,
    //  mapMarkers = mapEntry.markers || [];

    const mapMarkers = mapPlaces.map((place, i) => {
        /*  mapMarkers[i] = mapMarkers[i] ?
         mapMarkers[i] : markers.create(mapEntry, place);

         mapMarkers[i].setMap(null);*/

        const marker = place.placeInstance.marker;
        clusterer.removeMarker(marker);
        return marker;
    });

    clusterer.addMarkers(mapMarkers);
    mapMarkers.forEach((marker) => {

            const isSelectedPlace =
                selectedPlaceKeys.some(key => marker.place.key === key);

            if (isSelectedPlace) {
                marker.setMap(map);
            }
        }
    );
}
const filterPlaces = {
    update,
    showMatchingPlaces,
    showSelectedPlaces
};

export default filterPlaces;