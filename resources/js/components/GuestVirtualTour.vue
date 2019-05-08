<template>
    <div>
        <div class="row">
            <div class="col-lg-8">
                <GmapMap
                    class="mr-3"
                    ref="mapRef"
                    :center="{ lat: config.center.latitude, lng: config.center.longitude }"
                    map-type-id="terrain"
                    :zoom="14"
                    style="width: 100%; height: 640px">

                    <span
                        v-for="location in locations"
                        :key="'location_' + location.id"
                        >

                        <!-- Location markers -->
                        <GmapMarker
                            @click="onLocationMarkerClick(location)"
                            :icon="`/layer/icon/${location.layer_id}`"
                            :position="{ lat: location.latitude, lng: location.longitude }"
                            />

                        <!-- Panorama markers -->
                        <GmapMarker
                            :icon="`/png/panorama.png`"
                            v-for="panorama in location.panoramas"
                            :key="'panorama_' + panorama.id"
                            :position="{ lat: panorama.latitude, lng: panorama.longitude }"
                            />

                    </span>
                </GmapMap>
            </div>

            <div class="col-lg-4">
                <div ref="pano" style="width: 100%; border: thin solid black; height: 640px"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        "config", "layers",
    ],
    
    mounted() {
        this.$refs.mapRef.$mapPromise.then((map) => {
            this.map = map

            if (this.locations.length > 0 && this.locations[0].panoramas.length > 0) {
                this.initPanorama(this.locations[0].panoramas[0])
            }
        })
    },

    methods: {
        onLocationMarkerClick(location) {
            if (location.panoramas.length < 1) {
                alert("This location does not have any panorama.")
            }

            this.initPanorama(location.panoramas[0])
        },

        initPanorama(panorama) {
            
            let gmap_panorama = new google.maps.StreetViewPanorama(
                this.$refs.pano,
                { pano: `${panorama.id}` }
            );

            /* Register panorama provider */
            gmap_panorama.registerPanoProvider(gmap_panorama => {
                if (this.panoramas.find(panorama => panorama.id == gmap_panorama)) {
                    return this.getPanoramaData(gmap_panorama);
                }
                return null;
            });
            this.map.setStreetView(gmap_panorama);
        },

        getPanoramaData(panorama_id) {
            let panorama = this.panoramas.find(panorama => panorama.id == panorama_id)

            return {
                location: {
                    pano: panorama_id,  // The ID for this custom panorama.
                    description: 'Panorama Descriptions',
                    latLng: new google.maps.LatLng(panorama.latitude, panorama.longitude)
                },
                links: panorama.links.map(link => {
                    return {
                        heading: link.heading,
                        description: '',
                        pano: link.destination_id,
                    }
                }),

                copyright: 'Imagery (c) 2010 Bobby Donald MacNamara',
                tiles: {
                    tileSize: new google.maps.Size(128, 64),
                    worldSize: new google.maps.Size(1024, 512),
                    centerHeading: 105,
                    getTileUrl: (pano, zoom, tileX, tileY) => {
                        return `/location/panorama/${panorama.location_id}/tile/${panorama_id}/${zoom}/${tileX}/${tileY}`;
                    }
                }
            };
        },
    },

    computed: {
        locations() {
            return this.layers.reduce((curr, next) => {
                return [...curr, ...next.locations]
            }, [])
        },

        panoramas() {
            return this.locations.reduce((curr, next) => {
                return [...curr, ...next.panoramas]
            }, [])
        }
    }
}
</script>

<style>

</style>
