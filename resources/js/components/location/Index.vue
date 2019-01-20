<template>
    <div class="card">
        <modal name="delete-location-modal">
            <div v-if="selected_location">
                <div class="card text-white bg-danger">
                    <div class="card-header">
                        <i class="fa fa-warning"></i>
                        Anda yakin Anda Ingin Menghapus Berkas Ini?
                    </div>
                    <div class="card-body">
                        <div class="card text-dark">
                            <div class="card-body">
                                <h4> {{ selected_location.name }} </h4>
                                <hr>
                                <p class="small">
                                    <span class="font-weight-bold"> {{ selected_location.latitude }}, {{ selected_location.longitude }} </span>
                                    <br>
                                    {{ selected_location.address }}
                                </p>
                                <p>
                                    {{ selected_location.description }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 text-right">
                            <button @click="onConfirmDeleteButtonClick(selected_location)" class="btn btn-warning">
                                Hapus
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </modal>

        <modal name="edit-location-modal" height="auto">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    Edit Lokasi
                </div>

                <div class="card-body">
                    <form @submit="onEditFormSubmit" v-if="edited_location">
                        <div class='form-group'>
                            <label for='name'> Nama: </label>
                            <input
                                v-model='edited_location.name'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.name[0]', false)}"
                                type='text' id='name' placeholder='Nama'>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.name[0]', false) }}</div>
                        </div>

                        <div class='form-group'>
                            <label for='description'> Deskripsi: </label>
                            <textarea
                                v-model='edited_location.description'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.description[0]', false)}"
                                type='text' id='description' placeholder='Deskripsi'></textarea>
                            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.description[0]', false) }}</div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <div class='form-group'>
                                    <label for='latitude'> Latitude: </label>
                                    <input
                                        v-model.number='edited_location.latitude'
                                        step="any"
                                        class='form-control'
                                        :class="{'is-invalid': get(this.error_data, 'errors.latitude[0]', false)}"
                                        type='number' id='latitude' placeholder='Latitude'>
                                    <div class='invalid-feedback'>{{ get(this.error_data, 'errors.latitude[0]', false) }}</div>
                                </div>
                            </div>
                            <div class="col">
                                <div class='form-group'>
                                    <label for='longitude'> Longitude: </label>
                                    <input
                                        v-model.number='edited_location.longitude'
                                        step="any"
                                        class='form-control'
                                        :class="{'is-invalid': get(this.error_data, 'errors.longitude[0]', false)}"
                                        type='number' id='longitude' placeholder='Longitude'>
                                    <div class='invalid-feedback'>{{ get(this.error_data, 'errors.longitude[0]', false) }}</div>
                                </div>
                            </div>
                        </div>

                        <GmapMap
                            @click="onEditMapClick"
                            :center="{lat: selected_location.latitude, lng: selected_location.longitude}"
                            map-type-id="terrain"
                            :zoom="14"
                            style="width: 100%; height: 300px">

                            <GmapMarker
                                :icon="`/layer/icon/${selected_location.layer_id}`"
                                :position="{lat: selected_location.latitude, lng: selected_location.longitude}"/>

                            <GmapMarker
                                :position="{lat: edited_location.latitude, lng: edited_location.longitude}"/>
                        </GmapMap>

                        <div class="form-group text-right mt-4">
                            <button class="btn btn-primary">
                                Perbarui Data
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </modal>
        
        <div class="card-header">
            <i class="fa fa-map"></i>
            Peta Persebaran Lokasi
        </div>

        <div class="card-body">

            <div class="card mb-4">
                <div class="card-body">
                    <div class="custom-control custom-checkbox d-inline-block mr-3"
                        v-for="layer in layers"
                        :key="layer.id">
                        <input v-model="layer.visible" type="checkbox" class="custom-control-input" :id="`layer_${layer.id}`">
                        <label class="custom-control-label" :for="`layer_${layer.id}`">
                            <img :src="`/layer/icon/${layer.id}`">
                            {{ layer.name }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-9">
                    <GmapMap
                        :center="{lat:-0.026330, lng:109.342504}"
                        :zoom="14"
                        map-type-id="terrain"
                        style="width: 100%; height: 640px">

                        <span v-for="layer in visible_layers" :key="layer.id">

                            <span
                                v-for="location in layer.locations"
                                :key="location.id">

                                <GmapMarker
                                    @click="location.infoWindowOpened=!location.infoWindowOpened"
                                    :icon="`/layer/icon/${layer.id}`"
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
                <div class="col-3">
                    <div class="list-group" style="height:640px; overflow-y: scroll">
                        <span v-for="layer in layers" :key="layer.id">
                            <div
                                class="list-group-item"
                                v-for="location in layer.locations"
                                :key="location.id"
                                >
                                <div> {{ location.name }} </div>

                                <hr class="my-2">

                                <div>
                                    <span>
                                        ({{ location.latitude.toFixed(4) }}, {{ location.longitude.toFixed(4) }})
                                    </span>
                                    <span class="badge badge-info">
                                        {{ layer.name }}
                                    </span>
                                </div>

                                <div class="text-right mt-3">
                                    <button @click="onEditButtonClick(location)" class="btn btn-dark btn-sm">
                                        Edit
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button @click="onDeleteButtonClick(location)" class="btn btn-danger btn-sm">
                                        Hapus
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {get} from 'lodash'

export default {
    data() {
        return {
            csrf_token: window.csrf_token,
            layers: window.layers.map(layer => {
                return {
                    ...layer,
                    visible: true,
                    locations: layer.locations.map(location => {
                        return { ...location, infoWindowOpened: false }
                    })
                }
            }),
            selected_location: null,
            edited_location: null,
            error_data: null
        }
    },

    methods: {
        get: get,

        onEditMapClick(e) {
            this.edited_location.latitude = e.latLng.lat()
            this.edited_location.longitude = e.latLng.lng()
        },

        onDeleteButtonClick(location) {
            this.selected_location = {...location}
            this.$modal.show('delete-location-modal')
        },

        onEditButtonClick(location) {
            this.selected_location = {...location}
            this.edited_location = {...location}
            this.$modal.show('edit-location-modal');
        },

        onConfirmDeleteButtonClick(location) {
            axios.post(`/location/delete/${location.id}`)
                .then(response => {
                    window.location.reload(true)
                })
                .catch(error => {})
        },

        onEditFormSubmit(e) {
            e.preventDefault()

            axios.post(`/location/update/${this.edited_location.id}`, this.edited_location)
                .then(response => { window.location.reload(true) })
                .catch(error => {})
        }
    },

    computed: {
        visible_layers() { 
            return this.layers.filter(layer => layer.visible)
        }
    }
}
</script>

<style>

</style>
