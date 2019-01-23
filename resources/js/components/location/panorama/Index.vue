<template>
    <div class="mb-4">
        <div class="card mb-2">
            <div class="card-header">
                Tambah Panorama Baru
                <i class="fa fa-plus"></i>
            </div>

            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class='form-group'>
                        <label for='name'> Nama Panorama: </label>
                        <input
                            v-model='name'
                            class='form-control'
                            :class="{'is-invalid': get(this.error_data, 'errors.name[0]', false)}"
                            type='text' id='name' placeholder='Nama Panorama'>
                        <div class='invalid-feedback'>{{ get(this.error_data, 'errors.name[0]', false) }}</div>
                    </div>

                    <div class="form-group">
                        <label for="image"> Gambar: </label>
                        <input name="image" class="d-block" type="file" accept="image/*">
                    </div>

                    <div class="form-group text-right">
                        <button class="btn btn-primary">
                            Tambah Panorama
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

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

        })
    },

    data() {
        return {
            name: '',
            map: null,
            google: gmapApi,
            location: window.p_location,
            location_street_view: null,
            error_data: null,
        }
    },

    methods: {
        get: _.get,

        getPanoramaData(panorama_id) {

            let panoramas = this.location.panoramas 
            let panorama = panoramas.find(panorama => panorama.id == panorama_id)
            
            let nextId = null
            if (panorama_id == panoramas[0].id) {
                nextId = panoramas[1].id
            }
            else {
                nextId = panoramas[0].id
            }

            return {
                location: {
                    pano: panorama_id,  // The ID for this custom panorama.
                    description: 'Google Sydney - Reception',
                    latLng: new google.maps.LatLng(panorama.latitude, panorama.longitude)
                },
                links: [{
                    heading: 180,
                    description: 'Whatever',
                    pano: nextId
                }],
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
