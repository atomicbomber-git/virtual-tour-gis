<template>
    <div ref="pano" style="width: 100%; border: thin solid black; height: 640px"></div>
</template>

<script>
export default {
    props: [
        "location", "map"
    ],

    mounted() {
        if (this.location.panoramas.length < 1) {
            alert("This location does not have any panorama.")
        }

        this.initPanorama(this.location.panoramas[0])
    },

    watch: {
        location() {
            this.initPanorama(this.location.panoramas[0])
        }
    },

    methods: {
        initPanorama(panorama) {
            
            let gmap_panorama = new google.maps.StreetViewPanorama(
                this.$refs.pano,
                { pano: `${panorama.id}` }
            );

            /* Register panorama provider */
            gmap_panorama.registerPanoProvider(gmap_panorama => {
                if (this.location.panoramas.find(panorama => panorama.id == gmap_panorama)) {
                    return this.getPanoramaData(gmap_panorama);
                }
                return null;
            });
            this.map.setStreetView(gmap_panorama);
        },

        getPanoramaData(panorama_id) {
            let panorama = this.location.panoramas.find(panorama => panorama.id == panorama_id)

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
    }
}
</script>

<style>

</style>
