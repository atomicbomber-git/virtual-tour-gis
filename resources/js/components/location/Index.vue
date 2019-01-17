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
                        :key="layer.id">
                        <input v-model="layer.visible" type="checkbox" class="custom-control-input" :id="`layer_${layer.id}`">
                        <label class="custom-control-label" :for="`layer_${layer.id}`">
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
                            <GmapMarker
                                v-for="location in layer.locations"
                                :key="location.id"
                                :position="{lat: location.latitude, lng: location.longitude}"/>
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
                                {{ location.name }}
                                
                                <hr>
                                <div class="text-right">
                                    <button class="btn btn-sm btn-danger">
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
export default {
    data() {
        return {
            layers: window.layers.map(layer => {
                return {...layer, visible: true}
            })
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
