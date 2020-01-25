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

                <b-table-column field="started_at" label="Started at" sortable width="80" centered>
                    <span class="tag is-info">
                        {{ new Date(props.row.started_at).toLocaleDateString('pl-PL') }}
                    </span>
                </b-table-column>

                <b-table-column label="Actions">
                    <b-icon icon="pencil" type="is-primary" @click.native="openDetails(props.row)"></b-icon>
                    <b-icon icon="delete" type="is-primary"></b-icon>
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
                    </div>
                </section>
            </template>
            <template slot="detail" slot-scope="props">
                <div class="content">
                    <TankDetail :row = props.row
                                :index = props.index
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
            isOpen: false
        };
    },
    components: {
        TankModal,
        TankDetail
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

            axios
                .all([axios.get('/shrimps'), axios.get('auth/tanks/' + this.userId)])
                .then(response => {
                    this.shrimpsArr = response[0].data.data;
                    this.tanks = response[1].data.data;
                    this.loading = false;

                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message;
                });
        },
        showShrimps(/*string*/ shrimpsStr, /*array*/ shrimpsArr) {
            let str = '';
            let part = '';
            let i = shrimpsStr.length;
            while(i--) {
                if(shrimpsStr != '' && shrimpsStr.charAt(i) != ',') {
                    shrimpsArr.forEach(function(item) {
                        if(shrimpsStr.charAt(i) == item.id)
                        part = '<div class="img-tooltip"> <img src="../img/' + item.description + '.png" width="40px"><span>' + item.name + '</span></div>';
                    })
                str = str + part;
                }
            }
            return str;
        },
        openDetails (/*Object*/row) {
                this.$refs.table.openDetailRow(row);
        },
        deleteTank(/*number*/ tankId) {

        },



    },
    filters: {
        filterNull: function (value) {
            if (value == null) return ''
            return value;
        }
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
</style>
