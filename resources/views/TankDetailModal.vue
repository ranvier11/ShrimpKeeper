<template>
    <div class="modal-card tank-modal">
            <header class="modal-card-head">
                <p class="modal-card-title">{{ row.name }}</p>
            </header>
            <section class="modal-card-body">
        <b-field grouped group-multiline>
            <b-field label="Name">
                <b-input type="text" field="name" v-model="row.name"></b-input>
            </b-field>
            <b-field label="Capacity">
                <b-numberinput v-model="row.capacity" controls-position="compact" min="0" max="1000" type="is-info">
                </b-numberinput>
            </b-field>
            <b-field label="Number of shrimps">
                <b-numberinput v-model="row.number" controls-position="compact" min="0" max="10000" type="is-info">
                </b-numberinput>
            </b-field>
            <b-field label="Tags">
                <div>
                <b-checkbox-button v-for="tag in tags" :key="tag.index"  v-model="tagsUpdate" :native-value="tag" size="is-small" type="is-primary">{{ tag }}</b-checkbox-button>
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



                    <div class="panel">
                    <p class="panel-heading">Shrimps </p>
                    <Shrimps :shrimpsTank="shrimpSplit(row.shrimps)" @update="addShrimps" @shrimps-count="showCounter"></Shrimps>
                    </div>


                    <div class="panel">
                    <p class="panel-heading">Measurement</p>
                    <Measures :tankId="row.id"></Measures>
                    </div>



            </section>
            <footer class="modal-card-foot">
                <b-button type="is-success" icon-left="check"  @click="updateTank(row.id, row); closeDetails()">Save</b-button>
                <b-button type="is-light" icon-left="chevron-up" @click="$parent.close()">Close</b-button>
            </footer>
    </div>

</template>
<script>
import axios from 'axios';
import moment from 'moment';
import Shrimps from './Shrimps.vue'
import Measures from './Measures.vue'
export default {

    props: {
            row: null,
            index: null,
            tankTags: {
            type: Array
            },
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
        closeDetails() {
            //close table row
            this.$emit('reload');
            this.$parent.close();
            //reload tanks
        },
        updateTank(/*number*/ tankId, /*Object*/ data) {
            var shrimps;
            if (this.shrimpsToUpdate.length == 0){
                if (this.row.shrimps.length == 0){
                shrimps = '';
                } else {
                    shrimps = this.row.shrimps;
                }
            } else {
                shrimps = this.shrimpsToUpdate.join(',');
            }
             axios.put('/auth/tank/' + tankId, {
                user_id: data.userId,
                name: data.name,
                capacity: data.capacity,
                number: data.number,
                description: data.description,
                started_at: moment(Date.parse(data.started_at)).format('YYYY-MM-DD'),
                tags: this.tagsUpdate.join(','),
                shrimps: shrimps
            }).then((response)=> {

                this.message = 'Tank ' + data.name + ' updated';
                this.$buefy.toast.open({
                    message: this.message,
                    type: 'is-success'
                    });
            }).catch(error => {
                this.$buefy.toast.open({
                    message: error,
                    type: 'is-danger'
                    });
            }).then(()=> this.$parent.$parent.fetchData());
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
            //console.log(this.shrimpsToUpdate);
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
                        //console.log(this.tags);
                    }
                });
            });
        },
        tagsClick(name) {
            if (this.tagsUpdate.includes(name)) {
                for (var i = 0; i < this.tagsUpdate.length; i++) {
                    if(this.tagsUpdate[i] == name) {
                        //console.log(this.tagsUpdate[i]);
                        this.tagsUpdate.splice(i, 1);
                    }
                }
                //console.log(this.tagsUpdate);
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
