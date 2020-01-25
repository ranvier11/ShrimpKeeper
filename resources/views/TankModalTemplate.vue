<template>
    <form @submit="tankSubmit">
                <div class="modal-card tank-modal">
                    <header class="modal-card-head" >
                        <p class="modal-card-title">{{ name ? name : "New Tank" }}</p>

                    </header>
                    <section class="modal-card-body">
                        <b-tabs>
                            <b-tab-item label="Tank" icon="google-photos">
                                <b-field horizontal label="Name" >
                                    <b-input type="text">
                                    </b-input>
                                </b-field>

                                <b-field horizontal label="Capacity" >
                                    <b-numberinput v-model="capacity" controls-position="compact" min="0" max="1000" size="is-small" ></b-numberinput>
                                </b-field>

                                <b-field horizontal label="Number of shrimps" >
                                    <b-numberinput v-model="number" class="tendown" controls-position="compact" min="0" max="10000" size="is-small" ></b-numberinput>
                                </b-field>

                                <b-field horizontal label="Started at" >
                                    <b-datepicker size="is-samll" v-model="started_at"
                                        placeholder="DD-MM-YYYY"
                                        icon="calendar-today"
                                        editable>
                                    </b-datepicker>
                                </b-field>
                                <b-field horizontal label="Description" >
                                    <b-input maxlength="200" type="textarea"></b-input>
                                </b-field>
                            </b-tab-item>
                            <b-tab-item label="Shrimps">
                                <!-- <b-tabs :size="size">
                                    <b-tab-item label="Caridina">
                                        <div class="shrimp-grid">
                                            <div class="shrimp" v-for="shrimp in cariShrimps" :key="shrimp.id">

                                                <img :src="'../img/' + shrimp.description + '.png'" width=80px v-on:click="addShrimp(shrimp.id, shrimpsTank)">
                                                <p class="shrimp-tag"> {{ shrimp.name }} </p>
                                            </div>
                                        </div>
                                    </b-tab-item>
                                    <b-tab-item label="Neocaridina">
                                        <div class="shrimp-grid">
                                            <div class="shrimp" v-for="shrimp in neoShrimps" :key="shrimp.id">

                                                <img :src="'../img/' + shrimp.description + '.png'" width=80px>
                                                <p class="shrimp-tag"> {{ shrimp.name }} </p>
                                            </div>
                                        </div>
                                    </b-tab-item>
                                    <b-tab-item label="Other" disabled>
                                        <div class="shrimp-grid">
                                            <div class="shrimp" v-for="shrimp in otherShrimps" :key="shrimp.id">

                                                <img :src="'../img/' + shrimp.description + '.png'" width=80px>
                                                <p class="shrimp-tag"> {{ shrimp.name }} </p>
                                            </div>
                                        </div>
                                    </b-tab-item>
                                </b-tabs> -->
                                <Shrimps :shrimpsTank="shrimpsTank"
                                 ></Shrimps>
                            </b-tab-item>
                        </b-tabs>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button" type="button" @click="$parent.close()">Close</button>
                        <button class="button is-primary">Save</button>
                    </footer>
                </div>
            </form>
</template>

<script>
import axios from 'axios'
import moment from 'moment'
import Measures from './Measures.vue'
import Shrimps from './Shrimps.vue'

var dateoptions = { year: 'numeric', month: 'numeric', day: 'numeric' };

export default {
    props: {
        userId: {
            type: Number
        },

        // shrimpsTank: {
        //     type: Array,
        //     default: function () {
        //         return
        //     }
        // }
    },
    data() {
        return {
            tankId: null,
            name: null,
            capacity: null,
            number: null,
            started_at: null,
            description: '',
            loading: false,
            shrimps: [],
            //cariShrimps: [],
            //neoShrimps: [],
            //otherShrimps: [],
            shrimpsTank: [],
            measures: [],
            edit: false,
            isDisabled: true,
            result: [],
            size: "is-small",
            childShrimps:[]
        }
    },
    created() {
        //this.fetchData();
    },
    methods: {
        // fetchData() {
        //     this.error = null;
        //     this.loading = true;

        //     axios
        //         .all([axios.get('/shrimps'), axios.get('/measurements/' + this.tankId)])
        //         .then(responseArr => {
        //             this.shrimps = responseArr[0].data.data;
        //             this.measures = responseArr[1].data.data;
        //             this.loading = false;
        //             this.shrimpSort(this.shrimps);

        //         }).catch(error => {
        //             this.loading = false;
        //             this.error = error.response.data.message;
        //         });
        // },

        // shrimpSort(/*array*/shrimps) {
        //     shrimps.forEach(element => {
        //         if(element.type == 'caridina'){
        //             this.cariShrimps.push(element);
        //         } else if (element.type == 'neocaridina'){
        //             this.neoShrimps.push(element);
        //         } else {
        //             this.otherShrimps.push(element);
        //         }
        //     });
        // },
        tankSubmit(e) {
            e.preventDefault;
            let currentObj = this;
            this.axios.post('auth/tank', {
                user_id: this.userId,
                name: this.name,
                capacity: this.capacity,
                number: this.number,
                description: this.description,
                started_at: moment(Date.parse(this.started_at)).format('YYYY-MM-DD'),
                shrimps: this.shrimpsTank.join(',')
            }).then(function (response) {

                    this.result = response.data;
                    this.$buefy.toast.open({
                    message: 'Tank ' + this.name + 'created',
                    type: 'is-success'
                    });
                })
                .catch(function (error) {
                    console.log(error);
        });
        },
        // populate tank's shrimps array
        addShrimp(id, /*array*/ shrimps) {
            shrimps.push(id);
            return shrimps;
        }


    },
    components: {
        Measures,
        Shrimps
    }
}
</script>
<style>

.tank-modal {
    width: 640px;
    height: 500px;
}


</style>
