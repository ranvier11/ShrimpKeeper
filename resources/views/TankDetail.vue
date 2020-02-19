<template>
    <div class="tank-detail">
        <b-field grouped group-multiline>
            <b-field label="Name">
                <b-input type="text" field="name" v-model="row.name"></b-input>
            </b-field>
            <b-field label="Capacity">
                <b-numberinput v-model="row.capacity" controls-position="compact" min="0" max="1000" type="is-warning">
                </b-numberinput>
            </b-field>
            <b-field label="Number of shrimps">
                <b-numberinput v-model="row.number" controls-position="compact" min="0" max="10000" type="is-warning">
                </b-numberinput>
            </b-field>
            <b-field label="Tags">
                <div>
                <b-checkbox-button v-for="tag in tags" :key="tag.index"  v-model="tagsUpdate" :native-value="tag" size="is-small" type="is-warning">{{ tag }}</b-checkbox-button>
                </div>
            </b-field>
            <b-field label="Started at">
                <b-datepicker size="is-samll" icon="calendar-today" v-model="dataStarted_at" editable>
                </b-datepicker>
            </b-field>
            <b-field label="Description" expanded>
                <b-input maxlength="200" type="textarea" v-model="row.description"></b-input>
            </b-field>
        </b-field>
        <div class="columns is-desktop">
                <div class="column is-half">
                    <div class="panel">
                    <p class="panel-heading">Shrimps </p>
                    <Shrimps :shrimpsTank="shrimpSplit(row.shrimps)" @update="addShrimps" @shrimps-count="showCounter"></Shrimps>
                    </div>
                </div>
                <div class="column is-half ">
                    <div class="panel">
                    <p class="panel-heading">Measurement</p>
                    <Measures :tankId="row.id"></Measures>
                    </div>
                </div>
            </div>
            <div class="columns is-desktop is-centered">
                <b-button type="is-success" icon-left="check"  @click="updateTank(row.id, row); closeDetails(row);">Save</b-button>
                <b-button type="is-light" icon-left="chevron-up" @click="closeDetails(row)">Close</b-button>
            </div>
    </div>
</template>
<script>
import axios from 'axios';
import moment from 'moment';
import Shrimps from './Shrimps.vue'
import Measures from './Measures.vue'
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
            tankTags: {
            type: Array
            },
            //shrimpsArr: [],

        },
    data() {
        return {
        isEmpty: false,
        dataStarted_at: new Date(Date.parse(this.row.started_at)),
        shrimpsToUpdate: [],
        shrimpsCounter: 0,
        tagsUpdate: [],
        tags: ['mix', 'hybrids', 'F1', 'F2', 'pure'],

        }

    },
    methods: {
        closeDetails(row) {
            console.log(this.shrimpsToUpdate);
            //close table row
            this.$parent.closeDetailRow(row);
            //reload tanks
            this.$parent.$parent.fetchData();
        },
        updateTank(/*number*/ tankId, /*Object*/ data) {
            //console.log(tags);
             axios.put('/auth/tank/' + tankId, {
                user_id: data.userId,
                name: data.name,
                capacity: data.capacity,
                number: data.number,
                description: data.description,
                started_at: moment(Date.parse(data.started_at)).format('YYYY-MM-DD'),
                tags: this.tagsUpdate.join(','),
                shrimps: this.shrimpsToUpdate.join(',')
            }).then(console.log).then((response)=> {

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
            var shrimpsArr = [];
            if (shrimps != null){
            shrimpsArr = shrimps.split(',').map(Number);
            if (isNaN(shrimpsArr[0]) || shrimpsArr[0] == 0) {
                shrimpsArr.splice(0, 1);
            }
            //this.shrimpsCounter = shrimpsArr.length;
            }
            return shrimpsArr;
        },
        addShrimps (shrimps) {
            this.shrimpsToUpdate = shrimps;
            console.log(this.shrimpsToUpdate);
        },
        showCounter(counter) {
            this.shrimpsCounter++;
            //console.log(this.shrimpsCounter);
        },
        tagsActiv(tagsInTank) {
            tagsInTank.forEach(element => {
                this.tags.forEach(tag => {
                    if(element == tag.name){
                        tag.type = 'is-info';
                        console.log(this.tags);
                    }
                });
            });
        },
        tagsClick(name) {
            // this.tagsUpdate = this.tankTags;
            // if (this.tagsUpdate.includes(name)) {
            //     for (let i = 0; i < this.tagsUpdate.length; i++) {
            //         if (this.tagsUpdate[i] === name) {
            //             this.tagsUpdate.splice(i, 1);
            //         }
            //     }
            // } else {
            //     this.tankTags.push(name);
            // }

            if (this.tagsUpdate.includes(name)) {
                for (var i = 0; i < this.tagsUpdate.length; i++) {
                    if(this.tagsUpdate[i] == name) {
                        console.log(this.tagsUpdate[i]);
                        this.tagsUpdate.splice(i, 1);
                    }
                }
                console.log(this.tagsUpdate);
            } else {
                this.tagsUpdate.push(name);
            }
        },
        tagActive(tag) {
            if (tag.type == 'is-light'){
                tag.type = 'is-info';
            } else {
                tag.type = 'is-light';
            }
        },
        displayTags(tags, tagsInTank){
            let str = '';
            tags.forEach(element => {
                if(tagsInTank.includes(element)) {
                    str += '<span class="tag is-info" @click.native="tagsClick('+element+'); tagActive(tag)"><span>' + element + '</span></span>';
                } else {
                    str +='<span class="tag is-light"><span>' + element + '</span></span>';
                }
            })
            return str;
        }
    },
    created() {
        this.$options.localRow = this.row;
        this.tagsActiv(this.tankTags);
        this.tagsUpdate = this.tankTags;
        //console.log(this.$options.localRow);
    },
    components: {
        Shrimps,
        Measures
    }


}

</script>
<style scoped>

.shrimp-component {
    border: 1px solid grey;
    border-radius: 5px;
    box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1);
    margin-right: 40px;
}
.measures-component {
    border: 1px solid grey;
    border-radius: 5px;
    box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1)
}
.panel-heading {
    background-color:dimgray;
    color: whitesmoke;
}
.button:focus, .button.is-focused {
    border-color: darkgoldenrod;
}
</style>
