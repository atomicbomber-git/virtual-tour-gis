<template>
    <div class="mx-1">
        <div class="row">
            <div class="col-lg p-0">
                <div style="position: relative">
                    <GmapMap
                        class="virtual-tour-display"
                        ref="mapRef"
                        :center="map_center"
                        map-type-id="terrain"
                        :zoom="map_zoom"
                        style="width: 100%"
                    >
                        <span
                            v-for="location in visible_locations"
                            :key="'location_' + location.id"
                        >
                            <!-- Location markers -->
                            <GmapMarker
                                @click="onLocationMarkerClick(location)"
                                :icon="{
                                    url: `/layer/icon/${location.layer_id}`,
                                    scaledSize: config.location_marker.icon.scaledSize
                                }"
                                :position="{ lat: location.latitude, lng: location.longitude }"
                            />

                            <!-- Panorama markers -->
                            <template v-if="virtual_tour_mode">
                                <GmapMarker
                                    @click="onPanoramaMarkerClick(panorama)"
                                    :icon="{
                                        url: `/png/panorama.png`,
                                        scaledSize: config.location_marker.icon.scaledSize
                                    }"
                                    v-for="panorama in location.panoramas"
                                    :key="'panorama_' + panorama.id"
                                    :position="{ lat: panorama.latitude, lng: panorama.longitude }"
                                />
                            </template>
                        </span>
                    </GmapMap>

                    <div style="position: absolute; bottom: 2rem; left: 2rem;">





                        <div class="card" style="width: 240px">
                            <div class="card-body">
                                <button
                                    style="position:absolute; right: 4px; top: 4px"
                                    @click="layer_filter_collapsed = !layer_filter_collapsed"
                                    class="btn btn-light btn-sm">
                                    <i
                                        :class="{
                                            'fa-window-minimize': !layer_filter_collapsed,
                                            'fa-window-restore': layer_filter_collapsed,
                                        }"
                                        class="fa ">
                                    </i>
                                </button>

                                <div>
                                    <h5>
                                        <i class="fa fa-filter"></i>
                                        Filter Layer
                                    </h5>
                                </div>

                                <div v-show="!layer_filter_collapsed">
                                    <hr class="mt-0">

                                    <div
                                        v-for="layer in m_layers" :key="layer.layer_id" class="mb-1 custom-control custom-checkbox">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            v-model="layer.is_visible"
                                            :id="`layer_filter_check_${layer.layer_id}`"
                                        >
                                        <label
                                            class="custom-control-label"
                                            :for="`layer_filter_check_${layer.layer_id}`"
                                            >

                                            <img
                                                :style="{
                                                    height: `${config.location_marker.icon.scaledSize.height}${config.location_marker.icon.scaledSize.f}`,
                                                    width: `${config.location_marker.icon.scaledSize.width}${config.location_marker.icon.scaledSize.b}`,
                                                }"
                                                :src="`/layer/icon/${layer.layer_id}`"
                                                :alt="layer.name">

                                            {{ layer.name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-2" v-if="selected_location" style="width: 360px">
                            <div class="card-body">
                                <button
                                    style="position:absolute; right: 4px; top: 4px"
                                    @click="location_info_collapsed = !location_info_collapsed"
                                    class="btn btn-light btn-sm">
                                    <i
                                        :class="{
                                            'fa-window-minimize': !location_info_collapsed,
                                            'fa-window-restore': location_info_collapsed,
                                        }"
                                        class="fa ">
                                    </i>
                                </button>

                                <h5>
                                    <i class="fa fa-map-marker"></i>
                                    {{ selected_location.name }}
                                </h5>

                                <div v-show="!location_info_collapsed">

                                    <hr class="mt-0">
                                    {{ selected_location.description }}
                                    <div class="text-right mt-4">
                                        <button
                                            v-show="selected_location.has_virtual_tour === 1"
                                            v-if="!virtual_tour_mode"
                                            @click="showVirtualTour"
                                            class="btn btn-primary"
                                        >Mode Virtual Tour</button>

                                        <button
                                            v-else
                                            @click="hideVirtualTour"
                                            class="btn btn-danger"
                                        >Keluar dari Mode Virtual Tour</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="virtual_tour_mode" class="col-lg-6 p-0 virtual-tour-display">
                <street-view
                    :location="selected_location"
                    :panorama="selected_panorama"
                    :map="map"
                    />
            </div>
        </div>
    </div>
</template>

<script>

import { gmapApi } from 'vue2-google-maps'

export default {
    props: ["config", "layers"],

    data() {
        return {
            map_center: {
                lat: this.config.center.latitude,
                lng: this.config.center.longitude
            },
            map_zoom: this.config.zoom,
            virtual_tour_mode: false,
            selected_location: null,

            m_layers: this.layers.map(layer => ({ ...layer, is_visible: true })),

            selected_panorama: null,
            google: null,

            layer_filter_collapsed: false,
            location_info_collapsed: false,
        };
    },

    mounted() {
        this.$refs.mapRef.$mapPromise.then(map => {
            this.map = map;
        })
    },

    methods: {
        onPanoramaMarkerClick(panorama) {
            this.selected_panorama = panorama
        },

        onLocationMarkerClick(location) {
            this.selected_location = location
            this.selected_panorama = location.panoramas[0]
        },

        showVirtualTour() {
            this.map_zoom = this.config.virtual_tour_zoom
            this.virtual_tour_mode = true;

            this.map_center = {
                lat: this.selected_location.latitude,
                lng: this.selected_location.longitude
            };
        },

        hideVirtualTour() {
            this.virtual_tour_mode = false
            this.map_zoom = this.config.zoom
        }
    },

    computed: {
        visible_locations() {
            if (this.selected_location && this.virtual_tour_mode) {
                return [this.selected_location];
            }

            return this.m_layers
                .filter(layer => layer.is_visible)
                .reduce((curr, next) => {
                    return [...curr, ...next.locations];
                }, []);
        }
    }
};
</script>

<style>
.virtual-tour-display {
    height: 740px;
}
</style>
