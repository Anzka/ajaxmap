import {getLocationType} from './map-helpers';
import mapHelpers from './map-helpers';
import infoWindow from './map-marker-info-window';
import $ from 'jquery';
function addMarkerClickFunction(mapEntry, place, marker) {
    return function() {

        if (/*window.ajaxMapConfig && the error is your friend */window.ajaxMapConfig.onMarkerClick) {
            window.ajaxMapConfig.onMarkerClick(mapEntry, place);
        }

        marker.setActive();

        /** for debug info win
        mapEntry.activeMarker && mapEntry.activeMarker.setNormal();
        infoWindow.createOnClick();

         **/
    };
}

function create(mapEntry, place) {
    var map = mapEntry.googleMap,
        currType = place.locationType && place.locationType.key,
        currLatlng = mapHelpers.getLatLong(place.geoCoordinates);

    if (currType) {
        var mapMarker = new google.maps.Marker({
            position: currLatlng,
            map: map,
            title: place.title
        });

        const locationTyp = getLocationType(mapEntry, currType);

        mapMarker.icons = {
            icon: locationTyp.icon,
            iconActive: locationTyp.iconActive
        };

        mapMarker.setActive = function() {
            mapEntry.activeMarker = mapMarker;
            mapMarker.setIcon(mapMarker.icons.iconActive);
            // console.log('setActive')
        };

        mapMarker.setNormal = function() {
            mapEntry.activeMarker = null;
            mapMarker.setIcon(mapMarker.icons.icon);

            // console.log('++++++++++','setNormal')
        };

        mapMarker.setNormal();
    }

    mapMarker.mapNumber = mapEntry.id;
    mapMarker.place = place;

    // add click function
    const clickFunction = addMarkerClickFunction(mapEntry, place, mapMarker);
    google.maps.event.addListener(mapMarker, 'click', clickFunction);

    // add dbl-click
    google.maps.event.addListener(marker, 'dblclick', function(e) {
        window.open(place.placeData.address.profileLink, '_blank');
    });

    return mapMarker;
}

/*object to handle old PLaces not in new one includet*/
function TurnOfOnBuffer(mapEntry) {
    this.buffer = mapEntry.places.reduce((prev, oldPlace) => {
        prev[oldPlace.key] = oldPlace.placeInstance;
        return prev;
    }, {});

    this.evaluate = function() {
        for (var i in  this.buffer) {
            if (this.buffer[i]) {
                this.buffer[i].setActive(false);
            }
        }
    };
}

const marker = {
    create,
    TurnOfOnBuffer
};

export default marker;
