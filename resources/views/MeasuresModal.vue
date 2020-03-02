<template>
    <form>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">New measure</p>
            </header>
            <section class="modal-card-body">
                <b-field grouped group-multiline>
                    <div class="control">
                        <b-switch size="is-small" v-model="isPpm">Ppm/Us</b-switch>
                        <b-switch size="is-small" v-model="isF">°C/°F</b-switch>
                    </div>
                </b-field>
                <b-field grouped group-multiline>
                    <b-field label="°C" v-bind:class="{ hide: isF }">
                        <b-numberinput v-model="tempC" controls-position="compact" min="15" max="35" type="is-dark"
                            size="is-small"></b-numberinput>
                    </b-field>
                    <b-field label="°F" v-bind:class="{ hide: !isF }">
                        <b-numberinput v-model="tempF" controls-position="compact" min="50" max="95" type="is-dark"
                            size="is-small"></b-numberinput>
                    </b-field>
                    <b-field label="Ph">
                        <b-numberinput v-model="ph" controls-position="compact" min="3" max="9" type="is-dark"
                            size="is-small" step="0.1"></b-numberinput>
                    </b-field>
                    <b-field label="Kh">
                        <b-numberinput v-model="kh" controls-position="compact" min="0" max="25" type="is-dark"
                            size="is-small"></b-numberinput>
                    </b-field>
                    <b-field label="Gh">
                        <b-numberinput v-model="gh" controls-position="compact" min="0" max="25" type="is-dark"
                            size="is-small"></b-numberinput>
                    </b-field>
                    <b-field label="NO₃">
                        <b-numberinput v-model="no3" controls-position="compact" min="0" max="25" type="is-dark"
                            size="is-small"></b-numberinput>
                    </b-field>
                    <ValidationProvider v-slot="{ errors }" rules="required">
                        <b-field label="Ppm" v-bind:class="{ hide: isPpm }" :type="{ 'is-danger': errors[0]}"
                            :message="errors">

                            <b-numberinput v-model="ppm" controls-position="compact" min="0" max="1000" type="is-dark"
                                size="is-small"></b-numberinput>
                        </b-field>
                    </ValidationProvider>
                    <b-field label="µS" v-bind:class="{ hide: !isPpm }">
                        <b-numberinput v-model="us" controls-position="compact" min="0" max="1000" type="is-dark"
                            size="is-small"></b-numberinput>
                    </b-field>
                    <b-field label="Started at">
                        <b-datepicker size="is-samll" v-model="created_at" placeholder="DD-MM-YYYY"
                            icon="calendar-today" editable>
                        </b-datepicker>
                    </b-field>
                </b-field>
            </section>
            <footer class="modal-card-foot">

                <button class="button" type="button" @click="$parent.close()">Close</button>
                <button class="button is-primary" @click="addMes()">Save</button>

            </footer>

        </div>
    </form>
</template>
<script>
import axios from 'axios'
import moment from 'moment'
import { ValidationProvider } from 'vee-validate';
import { extend } from 'vee-validate';
import { required } from "vee-validate/dist/rules";

extend("required", {
  ...required,
  message: "This field is required"
});

export default {
    data() {
        return {
                tempC: 20,
                tempF: 68,
                ph: 6.0,
                kh: 0,
                gh: 6,
                no3: 10,
                ppm: 120,
                date: null,
                desc: null,
                us: 240,
                isPpm: false,
                isF: false,
                created_at: new Date(),
        }
    },
    props: {
            tankId: {
                type: Number
            }
    },
    methods: {
        addMes() {
            this.axios.post('auth/measurement', {
                tank_id: this.tankId,
                tempC: this.isF ? this.tempF : this.tempC,
                ph: this.ph,
                kh: this.kh,
                gh: this.gh,
                no3: this.no3,
                ppm: this.ppm,
                us: this.us,
                created_at: moment(Date.parse(this.created_at)).format('YYYY-MM-DD'),
                description: this.desc,
            }).then(function (response) {
                this.result = response;
                //console.log(this.result);
                this.$buefy.toast.open({
                    message: 'Measure successfully added',
                    type: 'is-success'
                    });
            }).catch(error => {
                //console.log(error.response)
            });
        },
        deleteMes(id) {

        }
    },
    components: {
        ValidationProvider
    }

}
</script>
<style>
 .hide {
     display: none;
 }
</style>
