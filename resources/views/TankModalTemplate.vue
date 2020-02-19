<template>
<ValidationObserver v-slot="{ handleSubmit }">
    <form>
        <div class="modal-card tank-modal">
            <header class="modal-card-head">
                <p class="modal-card-title">{{ name ? name : "New Tank" }}</p>
            </header>
            <section class="modal-card-body">
                <b-tabs>
                    <b-tab-item label="Tank" icon="cube">
                        <ValidationProvider v-slot="{ errors }" rules="required">
                            <b-field horizontal label="Name" :type="{ 'is-danger': errors[0]}" :message="errors"
                                class="ten-down">

                                <b-input type="text" v-model="name">
                                </b-input>
                            </b-field>
                        </ValidationProvider>
                        <ValidationProvider v-slot="{ errors }" rules="required">
                            <b-field horizontal :type="{ 'is-danger': errors[0]}" :message="errors">
                                <template slot="label">
                                    Capacity
                                    <b-tooltip type="is-dark" label="Capacity of Your tank">
                                        <b-icon size="is-small" icon="help-circle-outline"></b-icon>
                                    </b-tooltip>
                                </template>
                                <b-numberinput v-model="capacity" controls-position="compact" min="0" max="1000"
                                    size="is-small" type="is-info"></b-numberinput>

                            </b-field>
                        </ValidationProvider>
                        <b-field horizontal >
                            <template slot="label">
                                    Number of shrimps
                                    <b-tooltip type="is-dark" label="Enter the number of shrimps to select shrimp types" multilined>
                                        <b-icon size="is-small" icon="help-circle-outline"></b-icon>
                                    </b-tooltip>
                                </template>
                            <b-numberinput v-model="number" class="tendown" controls-position="compact" min="0"
                                max="10000" size="is-small" type="is-info" @input="anyShrimpsSwitch()"></b-numberinput>
                        </b-field>
                        <b-field horizontal label="Started at">
                            <b-datepicker size="is-samll" v-model="started_at" placeholder="DD-MM-YYYY"
                                icon="calendar-today" editable>
                            </b-datepicker>
                        </b-field>
                        <b-field horizontal label="Description">
                            <b-input maxlength="200" type="textarea"></b-input>
                        </b-field>
                    </b-tab-item>
                    <b-tab-item label="Shrimps" icon="bug" :disabled="anyShrimps">
                        <Shrimps :shrimpsTank="shrimpsTank"></Shrimps>
                    </b-tab-item>
                </b-tabs>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$parent.close()">Close</button>
                <button class="button is-info" @click.prevent="handleSubmit(tankSubmit)">Save</button>
            </footer>
        </div>
    </form>
</ValidationObserver>
</template>

<script>
import axios from 'axios'
import moment from 'moment'
import Measures from './Measures.vue'
import Shrimps from './Shrimps.vue'
import { ValidationObserver, ValidationProvider } from 'vee-validate';
import { extend } from 'vee-validate';
import { required } from "vee-validate/dist/rules";

extend("required", {
  ...required,
  message: "This field is required"
});

//var dateoptions = { year: 'numeric', month: 'numeric', day: 'numeric' };

export default {
    props: {
        userId: {
            type: Number
        },
    },
    data() {
        return {
            tankId: null,
            name: null,
            capacity: null,
            number: 0,
            started_at: new Date(),
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
            childShrimps:[],
            error: null,
            anyShrimps: true
        }
    },
    created() {

    },

    methods: {
        tankSubmit() {
            let currentObj = this;
            let data = {
                user_id: this.userId,
                name: this.name,
                capacity: this.capacity,
                number: this.number,
                description: this.description,
                started_at: moment(Date.parse(this.started_at)).format('YYYY-MM-DD'),
                shrimps: this.shrimpsTank.join(',')};
            this.axios.post('auth/tank', data

            ).then(function (response) {
                    currentObj.result = response;
                    console.log(response);
                    currentObj.$parent.close();
                    currentObj.$router.go();
                    currentObj.$buefy.toast.open({
                    message: 'Tank created',
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
        },
        // enable shrimps tab
        anyShrimpsSwitch() {
            if (this.number > 0) {
                this.anyShrimps = false;
            } else {
                this.anyShrimps = true;
            }
        },
        validate() {

        }


    },
    components: {
        Measures,
        Shrimps,
        ValidationProvider,
        ValidationObserver
    }
}
</script>
<style scoped>

.tank-modal {
    width: 640px;
    height: 500px;
}
.ten-down {
    margin-bottom: 10px;
}
.modal-card-head {
    background-color: dimgrey;

}
.modal-card-title {
color: whitesmoke;
}


</style>
