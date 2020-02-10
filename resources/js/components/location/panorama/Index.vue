<template>
    <div class="mb-4">
        <modal
                name="create-panorama-form"
                height="auto"
                @before-close="(e) => { is_submitting && e.stop(); upload_progress_percentage = 0; }"
        >
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-plus"></i>
                    Tambah Panorama Baru
                </div>
                <div class="card-body"
                     style="max-height: 30rem; overflow-y: auto">
                    <form @submit="onCreatePanoramaFormSubmit">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input
                                    v-model="new_panorama.name"
                                    class="form-control"
                                    :class="{'is-invalid': get(this.error_data, 'errors.name[0]', false)}"
                                    type="text"
                                    id="name"
                                    placeholder="Name"
                            >
                            <div
                                    class="invalid-feedback"
                            >{{ get(this.error_data, 'errors.name[0]', false) }}
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="latitude">Latitude:</label>
                                    <input
                                            v-model.number="new_panorama.latitude"
                                            class="form-control"
                                            :class="{'is-invalid': get(this.error_data, 'errors.latitude[0]', false)}"
                                            type="text"
                                            id="latitude"
                                            placeholder="Latitude"
                                    >
                                    <div
                                            class="invalid-feedback"
                                    >{{ get(this.error_data, 'errors.latitude[0]', false) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="longitude">Longitude:</label>
                                    <input
                                            v-model.number="new_panorama.longitude"
                                            class="form-control"
                                            :class="{'is-invalid': get(this.error_data, 'errors.longitude[0]', false)}"
                                            type="text"
                                            id="longitude"
                                            placeholder="Longitude"
                                    >
                                    <div
                                            class="invalid-feedback"
                                    >{{ get(this.error_data, 'errors.longitude[0]', false) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <GmapMap
                                @click="onCreatePanoramaMapClick"
                                class="my-3"
                                style="height: 300px; width: 100%"
                                :center="{lat: location.latitude, lng: location.longitude}"
                                :zoom="20"
                                map-type-id="terrain"
                        >
                            <GmapMarker
                                    :icon="{
                                    url: `/layer/icon/${location.layer_id}`,
                                    scaledSize: config.location_marker.icon.scaledSize
                                }"
                                    :position="{lat: location.latitude, lng: location.longitude}"
                            />

                            <GmapMarker
                                    :icon="{
                                    scaledSize: config.location_marker.icon.scaledSize
                                }"
                                    :position="{lat: new_panorama.latitude, lng: new_panorama.longitude}"
                            />
                        </GmapMap>

                        <div class="form-group">
                            <label for="image">Gambar:</label>
                            <input
                                    class="d-block"
                                    ref="createPanoramaImageInputRef"
                                    id="image"
                                    name="image"
                                    type="file"
                                    accept="images/*"
                            >
                            <small
                                    v-if="get(this.error_data, 'errors.image[0]', false)"
                                    class="text-danger text-xs mt-3"
                            >{{ get(this.error_data, 'errors.image[0]', false) }}
                            </small>
                        </div>

                        <div class="form-group d-flex align-items-center">
                            <div class="flex-grow-1 pr-3">
                                <div class="progress">
                                    <div class="progress-bar bg-primary"
                                         role="progressbar"
                                         :style="{ width: `${upload_progress_percentage}%`}">
                                        Progress Upload
                                    </div>
                                </div>
                            </div>

                            <div>
                                <button v-if="!is_submitting"
                                        class="btn btn-primary">
                                    Tambah Panorama
                                    <i class="fa fa-plus"></i>
                                </button>

                                <button v-if="is_submitting"
                                        class="btn btn-primary">
                                    Mengirim dan Memroses Data
                                    <i class="fa fa-spinner fa-spin fa-fw"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </modal>

        <modal
                height="auto"
                @before-close="(e) => { is_submitting && e.stop() }"
                name="delete-panorama-form"
        >
            <div v-if="selected_panorama"
                 class="card bg-danger text-white">
                <div class="card-header">
                    <i class="fa fa-warning"></i>
                    Anda Yakin Anda Hendak Menghapus Panorama Ini?
                </div>
                <div class="card-body">
                    <h5>{{ selected_panorama.name }}</h5>
                    ({{ selected_panorama.latitude }}, {{ selected_panorama.longitude }})
                    <hr>

                    <img
                            style="width: 100%; height: auto; object-fit: cover"
                            :src="`/location/panorama/${selected_panorama.location_id}/image/${selected_panorama.id}`"
                    >

                    <div class="mt-3 text-right">
                        <button
                                @click="onConfirmPanoramaDeleteButtonClick(selected_panorama)"
                                class="btn btn-primary"
                        >
                            Konfimasi Penghapusan
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </modal>

        <modal
                height="auto"
                name="edit-panorama-form"
                @before-close="(e) => { is_submitting && e.stop(); upload_progress_percentage = 0; }"
        >
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    Edit Panorama
                </div>

                <div class="card-body">
                    <form
                            @submit="onEditPanoramaFormSubmit"
                            v-if="selected_panorama && edited_panorama"
                    >
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input
                                    v-model="edited_panorama.name"
                                    class="form-control"
                                    :class="{'is-invalid': get(this.error_data, 'errors.name[0]', false)}"
                                    type="text"
                                    id="name"
                                    placeholder="Name"
                            >
                            <div
                                    class="invalid-feedback"
                            >{{ get(this.error_data, 'errors.name[0]', false) }}
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="latitude">Latitude:</label>
                                    <input
                                            v-model.number="edited_panorama.latitude"
                                            class="form-control"
                                            :class="{'is-invalid': get(this.error_data, 'errors.latitude[0]', false)}"
                                            type="text"
                                            id="latitude"
                                            placeholder="Latitude"
                                    >
                                    <div
                                            class="invalid-feedback"
                                    >{{ get(this.error_data, 'errors.latitude[0]', false) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="longitude">Longitude:</label>
                                    <input
                                            v-model.number="edited_panorama.longitude"
                                            class="form-control"
                                            :class="{'is-invalid': get(this.error_data, 'errors.longitude[0]', false)}"
                                            type="text"
                                            id="longitude"
                                            placeholder="Longitude"
                                    >
                                    <div
                                            class="invalid-feedback"
                                    >{{ get(this.error_data, 'errors.longitude[0]', false) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <GmapMap
                                @click="onEditPanoramaMapClick"
                                class="my-3"
                                style="height: 300px; width: 100%"
                                :center="{lat: selected_panorama.latitude, lng: selected_panorama.longitude}"
                                :zoom="18"
                                map-type-id="terrain"
                        >
                            <GmapMarker
                                    :icon="{
                                    url: `/layer/icon/${location.layer_id}`,
                                    scaledSize: config.location_marker.icon.scaledSize
                                }"

                                    :position="{lat: location.latitude, lng: location.longitude}"
                            />

                            <GmapMarker
                                    :icon="{
                                    scaledSize: config.location_marker.icon.scaledSize
                                }"
                                    :position="{lat: edited_panorama.latitude, lng: edited_panorama.longitude}"
                            />

                            <GmapMarker
                                    :icon="{
                                    url: '/png/panorama.png',
                                    scaledSize: config.location_marker.icon.scaledSize
                                }"
                                    :position="{lat: selected_panorama.latitude, lng: selected_panorama.longitude}"
                            />
                        </GmapMap>

                        <div class="form-group">
                            <label for="image">Gambar:</label>
                            <input
                                    class="d-block"
                                    ref="editPanoramaImageInputRef"
                                    id="image"
                                    name="image"
                                    type="file"
                                    accept="images/*"
                            >
                            <small
                                    v-if="get(this.error_data, 'errors.image[0]', false)"
                                    class="text-danger text-xs mt-3"
                            >{{ get(this.error_data, 'errors.image[0]', false) }}
                            </small>
                        </div>

                        <div class="form-group d-flex align-items-center">
                            <div class="flex-grow-1 pr-3">
                                <div class="progress">
                                    <div class="progress-bar bg-primary"
                                         role="progressbar"
                                         :style="{ width: `${upload_progress_percentage}%`}">
                                        Progress Upload
                                    </div>
                                </div>
                            </div>

                            <div>
                                <button v-if="!is_submitting"
                                        class="btn btn-primary">
                                    Perbarui Panorama
                                    <i class="fa fa-check"></i>
                                </button>

                                <button v-if="is_submitting"
                                        class="btn btn-primary">
                                    Mengirim Data
                                    <i class="fa fa-spinner fa-spin fa-fw"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </modal>

        <modal height="auto"
               name="manage-links-modal">
            <div class="card"
                 v-if="selected_panorama">
                <div class="card-header">
                    <i class="fa fa-link"></i>
                    Kelola Destination
                </div>
                <div class="card-body">
                    <h5>Daftar Destination:</h5>
                    <div class="alert alert-warning"
                         v-if="!selected_panorama.links.length">
                        <i class="fa fa-warning"></i>
                        Belum terdapat link pada panorama ini
                    </div>

                    <table
                            v-if="selected_panorama.links.length"
                            class="table table-bordered table-sm"
                    >
                        <thead class="thead thead-dark">
                        <tr>
                            <th>Panorama</th>
                            <th>Heading</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                                v-for="link in selected_pano_links"
                                :key="link.id"
                                :class="{ 'table-info': link.heading !== link.original_heading }"
                        >
                            <td>{{ link.destination.name }}</td>
                            <td>
                                <input
                                        class="form-control form-control-sm"
                                        type="number"
                                        v-model.number="link.heading"
                                >
                            </td>
                            <td class="text-center">
                                <button
                                        @click="onUpdateLinkHeadingButtonClick(link)"
                                        class="btn btn-dark btn-sm"
                                        :disabled="link.heading === link.original_heading"
                                >
                                    <i class="fa fa-check"></i>
                                </button>

                                <button
                                        @click="onDeleteLinkButtonClick(link)"
                                        v-if="!is_submitting"
                                        class="btn btn-danger btn-sm"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>

                                <button v-if="is_submitting"
                                        class="btn btn-danger btn-sm">
                                    Mengirim Data
                                    <i class="fa fa-spinner fa-spin fa-fw"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <hr>

                    <h5 class="mb-3">Tambah Destination dengan Panorama Lain:</h5>

                    <div>
                        <form v-if="possible_links.length > 0"
                              @submit="onCreateNewLinkFormSubmit">
                            <div class="form-group">
                                <label>Panorama Tujuan:</label>
                                <select
                                        v-model="destination_id"
                                        class="form-control"
                                        :class="{'is-invalid': get(this.error_data, 'errors.destination_id[0]', false)}"
                                >
                                    <option
                                            v-for="panorama in possible_links"
                                            :key="panorama.id"
                                            :value="panorama.id"
                                    >{{ panorama.name }}
                                    </option>
                                </select>
                                <div
                                        class="invalid-feedback"
                                >{{ get(this.error_data, 'errors.destination_id[0]', false) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="heading">Heading:</label>
                                <input
                                        v-model.number="heading"
                                        class="form-control"
                                        :class="{'is-invalid': get(this.error_data, 'errors.heading[0]', false)}"
                                        type="text"
                                        id="heading"
                                        placeholder="Heading"
                                >
                                <div
                                        class="invalid-feedback"
                                >{{ get(this.error_data, 'errors.heading[0]', false) }}
                                </div>
                            </div>

                            <div class="form-group text-right mt-2">
                                <button v-if="!is_submitting"
                                        class="btn btn-primary">
                                    Tambah Destination
                                    <i class="fa fa-check"></i>
                                </button>

                                <button v-if="is_submitting"
                                        class="btn btn-primary">
                                    Mengirim Data
                                    <i class="fa fa-spinner fa-spin fa-fw"></i>
                                </button>
                            </div>
                        </form>

                        <div class="alert alert-warning"
                             v-if="possible_links.length == 0">
                            <i class="fa fa-warning"></i>
                            Tidak terdapat destination yang dapat ditambahkan
                        </div>
                    </div>
                </div>
            </div>
        </modal>

        <div class="my-3 text-right">
            <button @click="onCreatePanoramaButtonClick"
                    class="btn btn-dark btn-sm">
                Tambah Panorama Baru
                <i class="fa fa-plus"></i>
            </button>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-map"></i>
                        Peta Lokasi Panorama
                    </div>
                    <div class="card-body p-0">
                        <GmapMap
                                :center="{lat: location.latitude, lng: location.longitude}"
                                :zoom="config.zoom"
                                map-type-id="terrain"
                                style="height: 600px; width: 100%"
                        >
                            <GmapMarker
                                    :position="{lat: location.latitude, lng: location.longitude}"
                                    :icon="{
                                    url: `/layer/icon/${location.layer_id}`,
                                    scaledSize: config.location_marker.icon.scaledSize
                                }"
                            />

                            <span v-for="panorama in location.panoramas"
                                  :key="panorama.id">
                                <GmapMarker
                                        :position="{lat: panorama.latitude, lng: panorama.longitude}"

                                        :icon="{
                                        url: '/png/panorama.png',
                                        scaledSize: config.location_marker.icon.scaledSize
                                    }"
                                />

                                <GmapPolyline
                                        v-for="link in panorama.links"
                                        :key="link.id"
                                        :path="[{lat: panorama.latitude, lng: panorama.longitude}, {lat: link.destination.latitude, lng: link.destination.longitude}]"
                                />
                            </span>
                        </GmapMap>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="list-group">
                    <div
                            class="list-group-item"
                            v-for="panorama in location.panoramas"
                            :key="panorama.id"
                    >
                        {{ panorama.name }}
                        <hr class="m-1">

                        ({{ panorama.latitude.toFixed(4) }}, {{ panorama.longitude.toFixed(4) }})
                        <div class="text-right mt-3">
                            <button
                                    @click="onManageLinksButtonClick(panorama)"
                                    class="btn btn-dark btn-sm"
                            >
                                Link to Destination
                                <i class="fa fa-link"></i>
                            </button>

                            <button
                                    @click="onEditPanoramaButtonClick(panorama)"
                                    class="btn btn-dark btn-sm"
                            >
                                Edit
                                <i class="fa fa-edit"></i>
                            </button>

                            <button
                                    @click="onDeletePanoramaButtonClick(panorama)"
                                    class="btn btn-danger btn-sm"
                            >
                                Hapus
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div v-if="location.panoramas.length == 0"
                     class="alert alert-warning">
                    <i class="fa fa-warning"></i>
                    Belum Terdapat Panorama Sama Sekali.
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {gmapApi} from "vue2-google-maps";

    export default {
        props: {
            config: Object,
        },

        data() {
            return {
                new_panorama: {
                    name: null,
                    latitude: null,
                    longitude: null
                },

                is_submitting: false,

                edited_panorama: null,
                selected_panorama: null,

                map: null,
                google: gmapApi,
                location: window.p_location,
                location_street_view: null,
                error_data: null,

                heading: 0,
                destination_id: null,

                upload_progress_percentage: 0,
            };
        },

        computed: {
            selected_pano_links() {
                if (this.selected_panorama == null) {
                    return [];
                }

                return this.selected_panorama.links.map(link => {
                    return {...link, original_heading: link.heading};
                });
            },

            possible_links() {
                return this.location.panoramas.filter(
                    panorama =>
                        panorama.id !== this.selected_panorama.id &&
                        this.selected_panorama.links.find(
                            link => link.destination_id === panorama.id
                        ) === undefined
                );
            }
        },

        watch: {
            destination_id(new_destination_id) {
                if (!new_destination_id) {
                    return
                }

                const destination_panorama = this.location.panoramas
                    .find(source_panorama => source_panorama.id === new_destination_id);

                const pointA = new google.maps.LatLng(this.selected_panorama.latitude, this.selected_panorama.longitude);
                const pointB = new google.maps.LatLng(destination_panorama.latitude, destination_panorama.longitude);
                this.heading = google.maps.geometry.spherical.computeHeading(pointA, pointB)
            }
        },

        methods: {
            get: _.get,

            onManageLinksButtonClick(panorama) {
                this.error_data = null;
                this.destination_id = null;
                this.heading = 0;
                this.selected_panorama = {...panorama};
                this.$modal.show("manage-links-modal");
            },

            onDeleteLinkButtonClick(link) {
                axios
                    .post(
                        this.route('location.panorama.destination.delete', [
                            this.location.id,
                            this.selected_panorama.id,
                            link.id
                        ]).url(),
                    )
                    .then(response => {
                        this.location.panoramas = this.location.panoramas.filter(
                            panorama => {
                                if (panorama.id == this.selected_panorama.id) {
                                    panorama.links = panorama.links.filter(
                                        l => l.id != link.id
                                    );
                                    return panorama;
                                }
                                return panorama;
                            }
                        );

                        this.selected_panorama.links = this.selected_panorama.links.filter(
                            l => l.id != link.id
                        );
                        this.error_data = null;
                        this.is_submitting = false;
                    })
                    .catch(error => {
                        this.is_submitting = false;
                        this.error_data = error.response.data;
                    });
            },

            onUpdateLinkHeadingButtonClick(link) {
                axios
                    .post(
                        this.route('location.panorama.destination.update', [
                            this.location.id,
                            this.selected_panorama.id,
                            link.id
                        ]).url(),
                        {heading: link.heading}
                    )
                    .then(response => {

                    })
                    .catch(error => {
                        this.error_data = error.response.data;
                    });
            },

            onCreatePanoramaFormSubmit(e) {
                e.preventDefault();

                let newPanoramaFormData = new FormData();
                Object.keys(this.new_panorama).forEach(key => {
                    this.new_panorama[key] &&
                    newPanoramaFormData.append(key, this.new_panorama[key]);
                });

                newPanoramaFormData.append(
                    "image",
                    this.$refs.createPanoramaImageInputRef.files[0]
                );

                this.is_submitting = true;
                axios
                    .post(
                        `/location/panorama/${this.location.id}/store`,
                        newPanoramaFormData,
                        {
                            headers: {"Content-Type": "multipart/form-data"},
                            onUploadProgress: progressEvent => {
                                this.upload_progress_percentage = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                            }
                        }
                    )
                    .then(response => {
                        window.location.reload(true);
                    })
                    .catch(error => {
                        this.upload_progress_percentage = 0;
                        this.is_submitting = false;
                        this.error_data = error.response.data;
                    });
            },

            onCreatePanoramaButtonClick() {
                (this.new_panorama.latitude = this.location.latitude),
                    (this.new_panorama.longitude = this.location.longitude),
                    this.$modal.show("create-panorama-form");
            },

            onCreatePanoramaMapClick(e) {
                this.error_data = null;
                this.new_panorama.latitude = e.latLng.lat();
                this.new_panorama.longitude = e.latLng.lng();
            },

            onDeletePanoramaButtonClick(panorama) {
                this.selected_panorama = {...panorama};
                this.$modal.show("delete-panorama-form");
            },

            onEditPanoramaButtonClick(panorama) {
                this.error_data = null;
                this.edited_panorama = {...panorama};
                this.selected_panorama = {...panorama};
                this.$modal.show("edit-panorama-form");
            },

            onEditPanoramaMapClick(e) {
                this.edited_panorama.latitude = e.latLng.lat();
                this.edited_panorama.longitude = e.latLng.lng();
            },

            updatePanoramas: function (response) {
                const destination = response.data[0];
                const reverseDestination = response.data[1];

                this.location.panoramas = this.location.panoramas.map(
                    panorama => {
                        if (panorama.id === destination.origin_id) {
                            const oldLink = panorama.links.find(link => link.origin_id === destination.origin_id);
                            if (!oldLink) {
                                panorama.links = [...panorama.links, destination];
                            }
                            else {
                                panorama.links = panorama.links.map(link => {
                                    if (link.origin_id === destination.origin_id) {
                                        return destination
                                    }
                                    return link
                                })
                            }
                            return panorama;
                        }
                        else if (panorama.id === destination.destination_id) {
                            const oldLink = panorama.links.find(link => link.origin_id === destination.destination_id);
                            if (!oldLink) {
                                panorama.links = [...panorama.links, reverseDestination];
                            } else {
                                panorama.links = panorama.links.map(link => {
                                    if (link.origin_id === destination.destination_id) {
                                        return reverseDestination
                                    }
                                    return link
                                })
                            }
                            return panorama;
                        }
                        return panorama;
                    }
                );
            },

            onCreateNewLinkFormSubmit(e) {
                e.preventDefault();

                this.is_submitting = true;
                axios
                    .post(
                        this.route('location.panorama.destination.create', [
                            this.location.id,
                            this.selected_panorama.id,
                        ]).url(),
                        {
                            destination_id: this.destination_id,
                            heading: this.heading
                        }
                    )
                    .then(response => {
                        this.updatePanoramas(response);
                        this.error_data = null;
                        this.is_submitting = false;
                    })
                    .catch(error => {
                        this.is_submitting = false;
                        this.error_data = error.response.data;
                    });
            },

            onEditPanoramaFormSubmit(e) {
                e.preventDefault();

                let editedPanoramaFormData = new FormData();

                Object.keys(this.edited_panorama).forEach(key => {
                    this.edited_panorama[key] &&
                    editedPanoramaFormData.append(
                        key,
                        this.edited_panorama[key]
                    );
                });

                this.$refs.editPanoramaImageInputRef.files[0] &&
                editedPanoramaFormData.append(
                    "image",
                    this.$refs.editPanoramaImageInputRef.files[0]
                );

                this.is_submitting = true;
                axios
                    .post(
                        `/location/panorama/${this.location.id}/update/${
                            this.edited_panorama.id
                        }`,
                        editedPanoramaFormData,
                        {
                            headers: {"Content-Type": "multipart/form-data"},
                            onUploadProgress: progressEvent => {
                                this.upload_progress_percentage = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                            }
                        }
                    )
                    .then(response => {
                        window.location.reload(true);
                    })
                    .catch(error => {
                        this.is_submitting = false;
                        this.error_data = error.response.data;
                    });
            },

            onConfirmPanoramaDeleteButtonClick(panorama) {
                axios
                    .post(
                        `/location/panorama/${this.location.id}/delete/${
                            panorama.id
                        }`
                    )
                    .then(response => {
                        window.location.reload(true);
                    });
            },

            getPanoramaData(panorama_id) {
                let panoramas = this.location.panoramas;
                let panorama = panoramas.find(
                    panorama => panorama.id == panorama_id
                );

                let nextId = null;
                if (panorama_id == panoramas[0].id) {
                    nextId = panoramas[1].id;
                } else {
                    nextId = panoramas[0].id;
                }

                return {
                    location: {
                        pano: panorama_id, // The ID for this custom panorama.
                        description: "Google Sydney - Reception",
                        latLng: new google.maps.LatLng(
                            panorama.latitude,
                            panorama.longitude
                        )
                    },
                    links: [
                        {
                            heading: 180,
                            description: "Whatever",
                            pano: nextId
                        }
                    ],
                    copyright: "Imagery (c) 2010 Google",
                    tiles: {
                        tileSize: new google.maps.Size(128, 64),
                        worldSize: new google.maps.Size(1024, 512),
                        centerHeading: 105,
                        getTileUrl: (pano, zoom, tileX, tileY) => {
                            return `/location/panorama/${
                                this.location.id
                            }/tile/${panorama_id}/${zoom}/${tileX}/${tileY}`;
                        }
                    }
                };
            },

            initPanorama() {
                let firstPanoramaId = this.location.panoramas[0].id;

                let panorama = new google.maps.StreetViewPanorama(this.$refs.pano, {
                    pano: `${firstPanoramaId}`
                });

                panorama.registerPanoProvider(pano => {
                    if (
                        this.location.panoramas.find(
                            panorama => panorama.id == pano
                        )
                    ) {
                        return this.getPanoramaData(pano);
                    }

                    return null;
                });

                this.map.setStreetView(panorama);
            }
        }
    };
</script>

<style>
</style>
