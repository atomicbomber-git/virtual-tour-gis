<template>
    <div class="mb-4">
        <div class="row">
            <div class="col p-0">
                <GmapMap
                    ref="mapRef"
                    :center="{lat: location.latitude, lng: location.longitude}"
                    map-type-id="terrain"
                    :zoom="24"
                    style="width: 100%; height: 600px">

                    <GmapMarker
                        :icon="`/layer/icon/${location.layer_id}`"
                        :position="{lat: location.latitude, lng: location.longitude}"/>

                    <GmapMarker v-for="panorama in location.panoramas" :key="panorama.id"
                        :position="{lat: panorama.latitude, lng: panorama.longitude}"/>
                </GmapMap>
            </div>
            <div class="col">
                <div ref="pano" style="width: 100%; border: thin solid black; height: 600px"></div>
            </div>
        </div>
        
    </div>
</template>

<script>

import {gmapApi} from 'vue2-google-maps'

export default {
    mounted() {
        this.$refs.mapRef.$mapPromise.then((map) => {
            this.map = map

            var streetviewService = new google.maps.StreetViewService;
            this.initPanorama()

            // streetviewService.getPanorama(
            //     { location: {lat: this.location.latitude, lng: this.location.longitude} },
            //     (result, status) => {
            //         if (status === 'OK') {
            //             this.location_street_view = result
            //             console.log("TETS TETSTS TSTSTTS")
                        
            //         }
            //         console.log(status)
            //     }
            // );
        })
    },

    data() {
        return {
            map: null,
            google: gmapApi,
            location: window.p_location,
            location_street_view: null,
        }
    },

    methods: {
        getPanoramaData(panorama_id) {
            return {
                location: {
                    pano: panorama_id,  // The ID for this custom panorama.
                    description: 'Google Sydney - Reception',
                    latLng: new google.maps.LatLng(-33.86684, 151.19583)
                },
                copyright: 'Imagery (c) 2010 Google',
                tiles: {
                    tileSize: new google.maps.Size(128, 64),
                    worldSize: new google.maps.Size(1024, 512),
                    centerHeading: 105,
                    getTileUrl: (pano, zoom, tileX, tileY) => {
                        return `/location/panorama/${this.location.id}/tile/${panorama_id}/${zoom}/${tileX}/${tileY}`;
                    }
                }
            };
        },

        initPanorama() {
            let firstPanoramaId = this.location.panoramas[0].id

            let panorama = new google.maps.StreetViewPanorama(
                this.$refs.pano,
                { pano: `${firstPanoramaId}` }
            );

            panorama.registerPanoProvider(pano => {
                
                if (this.location.panoramas.find(panorama => panorama.id == pano)) {
                    return this.getPanoramaData(pano);
                }

                return null;
            });

            this.map.setStreetView(panorama);
        }
    }
}
</script>

<style>

</style>
