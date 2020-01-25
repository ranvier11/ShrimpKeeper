<template>
    <b-tabs :size="size">
        <b-tab-item label="Caridina">
            <div class="shrimp-grid">
                <div class="shrimp" v-for="shrimp in cariShrimps" :key="shrimp.id"  :class="{active:shrimp.selected}">

                    <img :src="'../img/' + shrimp.description + '.png'" width=80px
                        v-on:click="addShrimp(shrimp.id, shrimpsTank); $set(shrimp, 'selected', !shrimp.selected)">
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
    </b-tabs>
</template>
<script>
export default {
    data() {

        return {
            size: "is-small",
            selected: undefined,
            error: null,
            loading: false,
            cariShrimps: [],
            neoShrimps: [],
            otherShrimps: [],
            shrimps:[]
        }
    },
    props: {

        shrimpsTank: {
            type: Array,
            default:[]
        }
    },
    methods: {
        addShrimp(id, /*array*/ shrimps) {
            if (!shrimps.includes(id)) {
                shrimps.push(id);
            } else {
                for (var i = 0; i < shrimps.length; i++) {
                    if (shrimps[i] === id) {
                        shrimps.splice(i, 1);
                    }
                }
            }
            console.log(shrimps);
        },
        fetchData() {
            this.error = null;
            this.loading = true;
            axios.get('/shrimps')
                .then(response => {
                    this.shrimps = response.data.data;
                    this.loading = false;
                    this.shrimpSort(this.shrimps);
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message;
                });
        },
        shrimpSort(/*array*/shrimps) {
            shrimps.forEach(element => {
                if(element.type == 'caridina'){
                    this.cariShrimps.push(element);
                } else if (element.type == 'neocaridina'){
                    this.neoShrimps.push(element);
                } else {
                    this.otherShrimps.push(element);
                }
            });
        },
    },
    created() {
        this.fetchData();
    }
}
</script>
<style>
    .active {
        background: rgba(220, 220, 220, 0.85);
        border-radius: 5px;
        border: 2px solid #167DF0;
        margin: -2px;
    }

    .shrimp-grid {
        display: grid;
        grid-gap: 20px;
        grid-template-columns: 80px 80px 80px 80px 80px;
    }

    .shrimp-tag {
        font-size: 0.7em;
        text-align: center;
    }
    .shrimp {
        margin: 2px;
        overflow: hidden;
    }
</style>
