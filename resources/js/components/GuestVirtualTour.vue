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
                                :icon="`/layer/icon/${location.layer_id}`"
                                :position="{ lat: location.latitude, lng: location.longitude }"
                            />

                            <!-- Panorama markers -->
                            <template v-if="virtual_tour_mode">
                                <GmapMarker
                                    @click="onPanoramaMarkerClick(panorama)"
                                    :icon="`/png/panorama.png`"
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
                                <h4>
                                    <i class="fa fa-filter"></i>
                                    Filter Layer
                                </h4>
                                <hr class="mt-0">

                                <div v-for="layer in m_layers" :key="layer.id" class="mb-1 custom-control custom-checkbox">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        v-model="layer.is_visible"
                                        :id="`layer_filter_check_${layer.id}`"
                                    >
                                    <label
                                        class="custom-control-label"
                                        :for="`layer_filter_check_${layer.id}`"
                                        >

                                        <img :src="`/layer/icon/${layer.id}`" :alt="layer.name">

                                        {{ layer.name }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-2" v-if="selected_location" style="width: 360px">
                            <div class="card-body">
                                <h2 class="h4">
                                    <i class="fa fa-map-marker"></i>
                                    {{ selected_location.name }}
                                </h2>
                                <hr class="mt-0">
                                {{ selected_location.description }}
                                <div class="text-right mt-4">
                                    <button
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

            <div v-if="virtual_tour_mode" class="col-lg-6 p-0 virtual-tour-display">
                <street-view
                    :location="selected_location"
                    :panorama="selected_location.panoramas[0]"
                    :map="map"
                    />
            </div>
        </div>
    </div>
</template>

<script>
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

            selected_panorama: null
        };
    },

    mounted() {
        this.$refs.mapRef.$mapPromise.then(map => {
            this.map = map;
        });
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
            if (this.selected_location.panoramas.length < 1) {
                alert("No panoramas available.");
                return;
            }

            this.virtual_tour_mode = true;

            this.map_center = {
                lat: this.selected_location.latitude,
                lng: this.selected_location.longitude
            };
        },

        hideVirtualTour() {
            this.virtual_tour_mode = false;
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
