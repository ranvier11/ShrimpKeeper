<template>
<section>
    <b-field grouped group-multiline>
            <div class="control twenty-left">
                <b-tooltip label="Change water conductivity units" multilined type="is-light" position="is-right">
                <b-checkbox v-model="isVisibleUs">µS</b-checkbox>
                </b-tooltip>
                <b-tooltip label="Show description column" multilined type="is-light" >
                <b-checkbox v-model="isVisibleDesc" class="twenty-left">Description</b-checkbox>
                </b-tooltip>
                <b-tooltip label="Change temperature units" multilined type="is-light" >
                <b-checkbox v-model="tempF" class="twenty-left">°F</b-checkbox>
                </b-tooltip>
            </div>
        </b-field>
    <b-table :data="measurements">
        <template slot-scope="props">
                <b-table-column field="tempC" label="°C" width="50" numeric :visible="!tempF">
                    {{ props.row.tempC }}
                </b-table-column>
                <b-table-column field="tempC" label="°F" width="60" numeric :visible="tempF">
                    {{ tempConvert(props.row.tempC, tempF) }}
                </b-table-column>

                <b-table-column field="ph" label="Ph" width="60" numeric>
                    {{ props.row.ph }}
                </b-table-column>

                <b-table-column field="kh" label="Kh" width="60" numeric>
                    {{ props.row.kh }}
                </b-table-column>
                <b-table-column field="gh" label="Gh" width="60" numeric>
                    {{ props.row.gh }}
                </b-table-column>
                <b-table-column field="no3" label="NO₃" width="60" numeric>
                    {{ props.row.no3 }}
                </b-table-column>
                <b-table-column field="ppm" label="Ppm" width="60" numeric :visible="!isVisibleUs">
                    {{ props.row.ppm }}
                </b-table-column>
                <b-table-column field="us" label="µS" width="60" numeric :visible="isVisibleUs">
                    {{ props.row.us }}
                </b-table-column>

                <b-table-column field="created_at" label="Date" centered>
                    <span class="tag is-disabled">
                        {{ new Date(props.row.created_at).toLocaleDateString() }}
                    </span>
                </b-table-column>

                <b-table-column field="description" label="Desc" width="100" :visible="isVisibleDesc">
                    {{ props.row.description }}
                </b-table-column>
                <b-table-column label="Actions">
                    <b-icon icon="delete" type="is-danger" @click.native="deleteMesDialog(props.row.id, props.row.tank_id)"></b-icon>
                </b-table-column>
            </template>
    </b-table>
    </section>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import MeasuresModal from './MeasuresModal.vue';

export default {
    data() {
        return {
        isEmpty: false,
        //dataStarted_at: new Date(Date.parse(this.row.started_at)),
        measurements: [],
        loading: false,
        error: null,
        isVisibleUs: false,
        isVisibleDesc: false,
        tempF: false,
        error: [],
        }
    },
    props: {
            tankId: {
                type: Number
            }
    },

    methods: {
        fetchMes(tankId) {
            this.error = null;
            this.loading = true;
                axios.get('auth/measurement/' + this.tankId)
                .then(response => {
                    console.log(response);
                    this.measurements = response.data.data;
                    this.loading = false;
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.message;
                    console.log(this.error);
                });
        },
        tempConvert(temp, tempF) {
            if(tempF) {
                temp = (temp * 1.8) + 32;
                return Math.round((temp + Number.EPSILON) * 100) / 100;
            } else {
                temp = (temp - 32) * 0.5556;
                return Math.floor(temp);
            }
        },
        deleteMes (id, tankId) {
            axios.delete('/auth/measurement/' + id)
            .then((response)=> {
                this.message = 'Deleted';
                this.$buefy.toast.open({
                    message: this.message,
                    type: 'is-danger'
                    });
                this.fetchMes(tankId);
                console.log(response);
            }).catch(error => {
                console.log(error)
            });
        },
        deleteMesDialog(id, tankId) {
            this.$buefy.dialog.confirm({
                title: 'Deleting measure',
                message: 'Are you sure you want to <b>delete</b> measure? This action cannot be undone.',
                confirmText: 'Delete',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteMes(id, tankId)
            })
        },
    },
    created() {
        this.fetchMes(this.tankId);
    },
    components: {
        MeasuresModal
    }

}
</script>
<style>
    #m-table {
        padding-left: 20px;
    }
    .twenty-left {
        padding-left: 20px;
        margin-top: 5px;
    }
</style>
