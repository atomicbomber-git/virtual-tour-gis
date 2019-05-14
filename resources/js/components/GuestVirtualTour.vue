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

                                

                            </div>
                        </div>

                        <div class="card mt-2" v-if="selected_location" style="width: 360px">
                            <div class="card-body">
                                <h2 class="h4">{{ selected_location.name }}</h2>
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
                                    >Keluar dari Model Virtual Tour</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="virtual_tour_mode" class="col-lg-6 p-0 virtual-tour-display">
                <street-view :location="selected_location" :map="map"/>
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
            map_zoom: 14,
            virtual_tour_mode: false,
            selected_location: null,

            locations: this.layers.reduce((curr, next) => {
                return [...curr, ...next.locations];
            }, [])
        };
    },

    mounted() {
        this.$refs.mapRef.$mapPromise.then(map => {
            this.map = map;
        });
    },

    methods: {
        onLocationMarkerClick(location) {
            this.selected_location = location;
        },

        showVirtualTour() {
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

            return this.locations;
        }
    }
};
</script>

<style>
.virtual-tour-display {
    height: 640px;
}
</style>