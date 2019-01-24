<template>
    <div class="mb-4">
        <modal
            name="create-panorama-form"
            height="auto"
            @before-close="beforeCreatePanoramaModalClose">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-plus"></i>
                    Tambah Panorama Baru
                </div>
                <div class="card-body" style="max-height: 30rem; overflow-y: auto">
                    <form @submit="onCreatePanoramaFormSubmit">
                        <div class='form-group'>
                            <label for='name'> Name: </label>
                            <input
                                v-model='new_panorama.name'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.name[0]', false)}"
                                type='text' id='name' placeholder='Name'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.name[0]', false) }}</div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <div class='form-group'>
                                    <label for='latitude'> Latitude: </label>
                                    <input
                                        v-model.number='new_panorama.latitude'
                                        class='form-control'
                                        :class="{'is-invalid': get(this.error_data, 'errors.latitude[0]', false)}"
                                        type='text' id='latitude' placeholder='Latitude'>
                                    <div class='invalid-feedback'>{{ get(this.error_data, 'errors.latitude[0]', false) }}</div>
                                </div>
                            </div>
                            <div class="col">
                                <div class='form-group'>
                                    <label for='longitude'> Longitude: </label>
                                    <input
                                        v-model.number='new_panorama.longitude'
                                        class='form-control'
                                        :class="{'is-invalid': get(this.error_data, 'errors.longitude[0]', false)}"
                                        type='text' id='longitude' placeholder='Longitude'>
                                    <div class='invalid-feedback'>{{ get(this.error_data, 'errors.longitude[0]', false) }}</div>
                                </div>
                            </div>
                        </div>

                        <GmapMap
                            @click="onCreatePanoramaMapClick"
                            class="my-3"
                            style="height: 300px; width: 100%"
                            :center="{lat: location.latitude, lng: location.longitude}"
                            :zoom="18"
                            map-type-id="terrain">

                            <GmapMarker
                                :icon="`/layer/icon/${location.layer_id}`"
                                :position="{lat: location.latitude, lng: location.longitude}"/>

                            <GmapMarker
                                :position="{lat: new_panorama.latitude, lng: new_panorama.longitude}"/>

                        </GmapMap>

                        <div class="form-group">
                            <label for="image"> Gambar: </label>
                            <input class="d-block" ref="createPanoramaImageInputRef" id="image" name="image" type="file" accept="images/*">
                            <small v-if="get(this.error_data, 'errors.image[0]', false)" class='text-danger text-xs mt-3'>
                                {{ get(this.error_data, 'errors.image[0]', false) }}
                            </small>
                        </div>

                        <div class="form-group text-right">
                            <button v-if="!is_submitting" class="btn btn-primary">
                                Tambah Panorama
                                <i class="fa fa-plus"></i>
                            </button>

                            <button v-if="is_submitting" class="btn btn-primary">
                                Mengirim Data
                                <i class="fa fa-spinner fa-spin fa-fw"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </modal>

        <div class="my-3 text-right">
            <button
                @click="onCreatePanoramaButtonClick"
                class="btn btn-dark btn-sm">
                Tambah Panorama Baru
                <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fa fa-image"></i>
                Panorama
            </div>

            <div class="card-body">

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
            new_panorama: {
                name: null,
                latitude: null,
                longitude: null
            },
            is_submitting: false,

            map: null,
            google: gmapApi,
            location: window.p_location,
            location_street_view: null,
            error_data: null,
        }
    },

    methods: {
        get: _.get,

        onCreatePanoramaFormSubmit(e) {
            e.preventDefault()

            let newPanoramaFormData = new FormData()
            Object.keys(this.new_panorama).forEach(key => {
                this.new_panorama[key] && newPanoramaFormData.append(key, this.new_panorama[key])
            })

            newPanoramaFormData.append('image', this.$refs.createPanoramaImageInputRef.files[0])

            this.is_submitting = true
            axios.post(`/location/panorama/${this.location.id}/store`, newPanoramaFormData, { headers: { 'Content-Type': 'multipart/form-data' } })
               .then(response => {
                   window.location.reload(true)
               })
               .catch(error => {
                   this.error_data = error.response.data
               })
        },

        beforeCreatePanoramaModalClose(e) {
            if (!this.is_submitting) {
                return
            }
            e.stop();
        },

        onCreatePanoramaButtonClick() {
            this.new_panorama.latitude = this.location.latitude,
            this.new_panorama.longitude = this.location.longitude,
            this.$modal.show('create-panorama-form')
        },

        onCreatePanoramaMapClick(e) {
            this.new_panorama.latitude = e.latLng.lat()
            this.new_panorama.longitude = e.latLng.lng()
        },

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
