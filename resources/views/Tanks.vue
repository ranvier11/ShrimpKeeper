<template>
<div class="container">
    <div class="tanks">
        <!-- <div class="loading" v-if="loading">
            Loading...
        </div> -->
         <b-loading :is-full-page="false" :active.sync="isLoading" :can-cancel="true"></b-loading>

        <div v-if="error" class="error">
            {{ error }}
            <p>
                <b-button @click.prevent="fetchData">
                    Try Again
                </b-button>
            </p>
        </div>
        <TankModal :userId="this.userId"/>
        <b-table
            :loading="isLoading"
            :data="isEmpty ? [] : tanks"
            :sort-icon="sortIcon"
            :sort-icon-size="sortIconSize"
            ref="table"
            default-sort="id"
            detailed
            :show-detail-icon="false"

        >

            <template slot-scope="props">
                <b-table-column label="ID" width="20" sortable numeric>
                    {{ props.index + 1 }}
                </b-table-column>

                <b-table-column  field="name" label="Name" sortable>
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column  field="capacity" label="Capacity" sortable>
                    {{ props.row.capacity }}
                </b-table-column>

                <b-table-column  field="shrimps" label="Shrimps" >
                   <div v-html="showShrimps(props.row.shrimps, shrimpsArr)"></div>
                </b-table-column>

                <b-table-column  field="number" label="Number" sortable>
                    {{ props.row.number | filterNull }}
                </b-table-column>

                <b-table-column  field="tags" label="Tags">
                    <span v-html="fixTags(props.row.tags)"> </span>

                </b-table-column>

                <b-table-column field="started_at" label="Started at" sortable width="80" centered>
                    <span class="tag is-grey">
                        {{ new Date(props.row.started_at).toLocaleDateString('pl-PL') }}
                    </span>
                </b-table-column>

                <b-table-column label="Actions">
                    <b-tooltip label="Edit & details" type="is-light">
                    <b-icon icon="pencil" type="is-success" class="icon-border" @click.native="openDetailsModal(props.row, props.index, tags, )"></b-icon>
                    </b-tooltip>
                    <b-tooltip label="Delete tank" type="is-light">
                    <b-icon icon="delete" :disabled="saving" type="is-danger" class="icon-border" @click.native="deleteTankDialog(props.row.name, props.row.id)"></b-icon>
                    </b-tooltip>
                     <b-tooltip label="Add measure" type="is-light">
                    <b-icon icon="plus" type="is-info" class="icon-border" @click.native="openModal(props.row.id)"></b-icon>
                     </b-tooltip>
                      <b-tooltip label="Display chart" type="is-light">
                    <b-icon icon="chart-bar" type="is-info" class="icon-border" @click.native="openChart(props.row.id)"></b-icon>
                      </b-tooltip>
                </b-table-column>

            </template>
            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>
                            <b-icon
                                icon="emoticon-sad"
                                size="is-large">
                            </b-icon>
                        </p>
                        <p>Nothing here.</p>
                        <p v-if="noTanks">Add Your first tank.</p>
                    </div>
                </section>
            </template>
            <template slot="detail" slot-scope="props" class="has-background-white-ter">
                <div class="content ">
                    <TankDetail :row = props.row
                                :index = props.index
                                :tankTags = tags
                    />
                </div>
            </template>
        </b-table>
    </div>
    </div>
</template>
<script>
import axios from 'axios';
import TankModal from './TankModal.vue';
import TankDetail from './TankDetail.vue';
import TankDetailModal from './TankDetailModal.vue';
import MeasuresModal from './MeasuresModal.vue';
import TankChart from './TankChart.vue';

function indexData(tanks) {
    var i = 1;
    tanks.forEach(element => {
        tanksIndex.push(i);
        ++i;
    });
    return tanksIndex;
}

export default {
    props: {
        tanksIndex: {
            type: Array
        },

    },
    data() {
        return {
            isLoading: false,
            tanks: [],
            error: null,
            userId: null,
            sortIcon: 'arrow-up',
            sortIconSize: 'is-small',
            isEmpty: false,
            shrimpsArr: [],
            isOpen: false,
            saving: false,
            noTanks: true,
            tags: [],
        };
    },
    components: {
        TankModal,
        TankDetail,
        MeasuresModal,
        TankChart,
        TankDetailModal
    },
    created() {
        axios.get('auth/user').then(res => {
            this.userId = res.data.data.id;
            this.fetchData();
        });




    },
    methods: {
        fetchData() {
            this.error = null;
            this.loading = true;
            let vue = this;
            axios
                .all([axios.get('/shrimps'), axios.get('auth/tanks/' + this.userId)])
                .then(response => {

                    this.shrimpsArr = response[0].data.data;
                    this.tanks = response[1].data.data;
                    if (this.tanks.length > 0){this.noTanks = false;}
                    vue.isLoading = false;
                    console.log(this.tanks);

                }).catch(function (error) {
                    console.log( error);
                    vue.isLoading = false;

                });
        },
        showShrimps( /*string*/ shrimpsStr, /*array*/ shrimpsArr) {
                let str = '';
                let part = '';
                //console.log(shrimpsStr);
                if (shrimpsStr != null) {
                    let i = shrimpsStr.length;
                    while (i--) {
                        if (shrimpsStr != '' && shrimpsStr.charAt(i) != ',') {
                            shrimpsArr.forEach(function (item) {
                                if (shrimpsStr.charAt(i) == item.id && shrimpsStr.charAt(i) != 0)
                                    part = '<div class="img-tooltip"> <img src="../img/' + item.description + '.png" width="40px"><span>' + item.name + '</span></div>';
                            })
                            str = str + part;
                        }
                    }
                }
                return str;
        },
        openDetails (/*Object*/row) {
                this.$refs.table.openDetailRow(row);
        },
        openDetailsModal (/*Object*/ row, index, tags ) {
            this.$buefy.modal.open({
                parent: this,
                component: TankDetailModal,
                hasModalCard: true,
                trapFocus: true,
                props: {
                    row: row,
                    index: index,
                    tankTags: tags
                }
            })
        },
        deleteTank(/*number*/ tankId) {
            this.saving = true;
            axios.delete('/auth/tank/' + tankId)
            .then((response)=> {
                this.message = 'Tank deleted';
                this.$buefy.toast.open({
                    message: this.message,
                    type: 'is-danger'
                    });
                this.fetchData();
            }).catch(error => {
                console.log(error)
            });
        },
        deleteTankDialog(name, id) {
            this.$buefy.dialog.confirm({
                title: 'Deleting tank',
                message: 'Are you sure you want to <b>delete</b> tank ' + name +'? This action cannot be undone.',
                confirmText: 'Delete tank',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.deleteTank(id)
            })
        },
        openModal(tankId) {
            this.$buefy.modal.open({
                parent: this,
                component: MeasuresModal,
                hasModalCard: true,
                trapFocus: true,
                props: {
                    tankId: tankId,
                }
            })
        },
        openChart(tankId) {
            this.$buefy.modal.open({
                parent: this,
                component: TankChart,
                hasModalCard: true,
                trapFocus: true,
                props: {
                    tankId: tankId
                }
            })
        },
        fixTags( /*String*/ tags) {
            let string = '';
            if (tags != null) {
                let array = tags.split(',');
                this.tags = array;
                array.forEach(function(el){

                    string += '<span class="tag">' + el + '</span>';
                });
            }
            return string;
        }



    },
    filters: {
        filterNull: function (value) {
            if (value == null) return ''
            return value;
        },
    }
}
</script>
<style>
.table-mobile-sort {
    visibility: hidden;
}
div.img-tooltip {
    float: left;
    position: relative;
}
.img-tooltip span {
    visibility: hidden;
    padding: 10px;
	position: absolute;
	width: auto;
	white-space: nowrap;
	word-wrap: no-wrap;
	box-shadow: 1px 1px 20px #aaa;
	border-radius: 5px;
	background-color: #fff;
    top: -40px;
	transform: translate(-50%);
	transform-style: preserve-3d;
	z-index: 200;
	font-size: 0.9em;



     }
.img-tooltip:hover span {
    visibility: visible; }

.icon-border {
    text-shadow: 0 0 1px #000;
}
</style>
