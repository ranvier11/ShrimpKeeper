<template>
    <div>
        <b-field grouped group-multiline>
            <b-field  label="Name" expanded>
                <b-input type="text" field="name" v-model="row.name"></b-input>
            </b-field>
            <b-field  label="Capacity" >
                <b-numberinput v-model="row.capacity" controls-position="compact" min="0" max="1000"  type="is-dark"></b-numberinput>
            </b-field>
            <b-field  label="Number of shrimps" >
                <b-numberinput v-model="row.number"  controls-position="compact" min="0" max="10000"  type="is-dark" ></b-numberinput>
            </b-field>
            <b-field label="Started at" >
                <b-datepicker size="is-samll"
                        icon="calendar-today"
                        v-model="dataStarted_at"
                        editable>
                </b-datepicker>
            </b-field>
            <b-field label="Description" expanded>
                <b-input maxlength="200" type="textarea" v-model="row.description"></b-input>
            </b-field>
            <Shrimps :shrimpsTank="shrimpSplit(row.shrimps)" class="is-centered"></Shrimps>
        </b-field>
            <div class="columns is-mobile is-centered">
                <b-button type="is-success" icon-left="check"  @click="updateTank(row.id, row); closeDetails(row);">Save</b-button>
                <b-button type="is-light" icon-left="chevron-up" @click="closeDetails(row)">Close</b-button>
            </div>
    </div>
</template>
<script>
import axios from 'axios';
import moment from 'moment';
import Shrimps from './Shrimps.vue'
export default {

    props: {
            // name: String,
            // tankId: Number,
            // capacity: Number,
            // number: Number,
            // shrimps: String,
            // description: String,
            // started_at: String,
            row: null,
            index: null,
            //shrimpsArr: [],

        },
    data() {
        return {
        isEmpty: false,
        dataStarted_at: new Date(Date.parse(this.row.started_at))
        }
    },
    methods: {
        closeDetails(row) {
            //close table row
            this.$parent.closeDetailRow(row);
            //reload tanks
            this.$parent.$parent.fetchData();
        },
        updateTank(/*number*/ tankId, /*Object*/ data) {
             axios.put('/auth/tank/' + tankId, {
                user_id: data.userId,
                name: data.name,
                capacity: data.capacity,
                number: data.number,
                description: data.description,
                started_at: moment(Date.parse(data.started_at)).format('YYYY-MM-DD'),
                //started_at: dataStarted_at,
                status: data.status,
                shrimps: data.shrimps
            }).then((response)=> {

                this.message = 'Tank ' + data.name + ' updated';
                this.$buefy.toast.open({
                    message: this.message,
                    type: 'is-success'
                    });
            }).catch(error => {
                console.log(error)
            });
        },
        shrimpSplit(/*String*/ shrimps) {
            var shrimpsArr = shrimps.split(',').map(Number);
            return shrimpsArr;
        }
    },
    created() {
        this.$options.localRow = this.row;
        //console.log(this.$options.localRow);
    },
    components: {
        Shrimps
    }


}

</script>
