<template>
    <b-tabs :size="size">
        <b-tab-item label="Caridina">
            <div class="shrimp-grid">
                <div class="shrimp" v-for="shrimp in cariShrimps" :key="shrimp.id"  :class="{active:shrimp.selected}">

                    <img :src="'../img/' + shrimp.description + '.png'" width=80px

                        v-on:click="addShrimp(shrimp.id, shrimpsTank, count); addActiveClass(shrimp); ">
                    <p class="shrimp-tag"> {{ shrimp.name }} </p>
                </div>
            </div>
        </b-tab-item>
        <b-tab-item label="Neocaridina">
            <div class="shrimp-grid">
                <div class="shrimp" v-for="shrimp in neoShrimps" :key="shrimp.id"  :class="{active:shrimp.selected}">

                    <img :src="'../img/' + shrimp.description + '.png'" width=80px

                        v-on:click="addShrimp(shrimp.id, shrimpsTank, count); addActiveClass(shrimp); ">
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
            selected: false,
            error: null,
            loading: false,
            cariShrimps: [],
            neoShrimps: [],
            otherShrimps: [],
            shrimps:[],
            count: 0,
            activeCount: 0,
        }
    },
    props: {

        shrimpsTank: {
            type: Array,
            default:[]
        },

    },
    methods: {
        //select shrimps to array, limit 10.
        addShrimp(id, /*array*/ shrimps, count) {
            if (count < 10) {
                //check if shrimp id is already in array
                if (!shrimps.includes(id)) {
                    shrimps.push(id);
                } else {
                    for (let i = 0; i < shrimps.length; i++) {
                        if (shrimps[i] === id) {
                            shrimps.splice(i, 1);
                        }
                    }
                }
            } else if (count == 10) {
                for (let i = 0; i < shrimps.length; i++) {
                        if (shrimps[i] === id) {
                            shrimps.splice(i, 1);
                        }
                    }
            }
            this.count = shrimps.length;
            this.$emit('update', shrimps);
        },
        fetchData() {
            this.error = null;
            this.loading = true;
            axios.get('/shrimps')
                .then(response => {
                    this.shrimps = response.data.data;
                    this.loading = false;
                    this.shrimpSort(this.shrimps);

                    this.setActive(this.shrimps, this.shrimpsTank)
                }).catch(error => {
                    this.loading = false;
                    //console.log(error);
                });
        },
        //sort shrimps by species
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
        //set class 'selected' shrimps
        setActive (shrimps, shrimpsTank) {
            let app = this;
            shrimpsTank.forEach(function(el) {
                shrimps.forEach(function(it){
                    if(el == it.id) {
                        app.$set(it, 'selected', true);

                    }
                })
            })
        },
        addActiveClass (shrimp) {
            this.count = this.shrimpsTank.length;

            if (this.count < 10) {
                if (shrimp.selected != true) {
                    this.$set(shrimp, 'selected', true);
                } else {
                    shrimp.selected = false;
                }
                this.activeCount = this.count;
            } else if (this.count == 10 && this.activeCount < 11) {
                this.$buefy.toast.open('You can select only 10 shrimps for Your tank');
                if (shrimp.selected != true) {
                    this.$set(shrimp, 'selected', true);
                    this.activeCount+=2;
                    //console.log(this.activeCount);
                } else {
                    shrimp.selected = false;
                }

            } else if (this.activeCount == 11) {
                this.$buefy.toast.open('You can select only 10 shrimps for Your tank');
            }
            },
    },
    created() {
        this.fetchData();

    },
    mounted() {

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
    @media (max-width: 700px) {
        .shrimp-grid {
            grid-template-columns: 80px 80px 80px;
        }
    }
</style>
