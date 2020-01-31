<template>
    <div class="form-group">
        <label for="create_layer_id"> Layer:</label>
        <select class="form-control"
                :class="{'is-invalid': get}"
                v-model="created_location.layer_id"
                name="layer_id"
                id="create_layer_id">
            <option v-for="layer in layers"
                    :value="layer.layer_id"
                    :key="layer.id">
                {{ layer.name }}
            </option>
        </select>
        <div class='invalid-feedback'>{{ get }}</div>
    </div>
</template>
<script>
    export default {
        name: 'LayerSelect',
        props: {
            error_data: {},
            created_location: {},
            get: {},
            layers: {}
        }
    }
</script>
