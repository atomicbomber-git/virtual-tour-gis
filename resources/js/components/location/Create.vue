<template>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-map"></i>
            Peta Persebaran Lokasi
        </div>

        <div class="card-body">

            <div class="card mb-4">
                <div class="card-body">
                    <div class="custom-control custom-checkbox d-inline-block mr-3"
                        v-for="layer in layers"
                        :key="layer.layer_id">
                        <input v-model="layer.visible" type="checkbox" class="custom-control-input" :id="`layer_${layer.layer_id}`">
                        <label class="custom-control-label" :for="`layer_${layer.layer_id}`">
                            {{ layer.name }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    <GmapMap
                        :center="{lat:-0.026330, lng:109.342504}"
                        :zoom="14"
                        map-type-id="terrain"
                        style="width: 100%; height: 640px"
                        @click="onMapClick">

                        <GmapMarker
                            :position="{lat: this.pointer_marker.lat, lng: this.pointer_marker.lng}"/>

                        <span v-for="layer in visible_layers" :key="layer.layer_id">

                            <span
                                v-for="location in layer.locations"
                                :key="location.id">

                                <GmapMarker
                                    @click="location.infoWindowOpened=!location.infoWindowOpened"
                                    :position="{lat: location.latitude, lng: location.longitude}"/>

                                <GmapInfoWindow
                                    :position="{lat: location.latitude, lng: location.longitude}"
                                    :opened="location.infoWindowOpened"
                                    @closeclick="location.infoWindowOpened=false">
                                    <div>
                                        <div class="card" style="width: 20rem">
                                            <div class="card-body">
                                                <h4> {{ location.name }} </h4>
                                                <hr>
                                                <p class="small">
                                                    <span class="font-weight-bold"> {{ location.latitude }}, {{ location.longitude }} </span>
                                                    <br>
                                                    {{ location.address }}
                                                </p>
                                                <p>
                                                    {{ location.description }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </GmapInfoWindow>
                            </span>
                        </span>
                    </GmapMap>
                </div>
                <div class="col-4">
                    <h4> Data Lokasi Baru </h4>
                    <hr>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="latitude"> Latitude: </label>
                            <input v-model.number="pointer_marker.lat" type="number" step="any" class="form-control" id="latitude" placeholder="Latitude">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="longitude"> Longitude: </label>
                            <input v-model.number="pointer_marker.lng" type="number" step="any" class="form-control" id="longitude" placeholder="Longitude">
                        </div>
                    </div>

                    <div class='form-group'>
                        <label for='name'> Nama: </label>
                        <input
                            v-model='name'
                            class='form-control'
                            :class="{'is-invalid': get(this.error_data, 'errors.name[0]', false)}"
                            type='text' id='name' placeholder='Nama'>
                        <div class='invalid-feedback'>{{ get(this.error_data, 'errors.name[0]', false) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            pointer_marker: {
                lat: -0.026330,
                lng: 109.342504
            },

            layers: window.layers.map(layer => {
                return {
                    ...layer,
                    visible: true,
                    locations: layer.locations.map(location => {
                        return { ...location, infoWindowOpened: false }
                    })
                }
            })
        }
    },

    computed: {
        visible_layers() {
            return this.layers.filter(layer => layer.visible)
        }
    },

    methods: {
        onMapClick(e) {
            this.pointer_marker = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            }
        }
    }
}
</script>

<style>

</style>
