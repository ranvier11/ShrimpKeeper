<template>
    <div class="tanks">
        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            {{ error }}
            <p>
                <button @click.prevent="fetchData">
                    Try Again
                </button>
            </p>
        </div>

        <ul v-if="tanks">
            <li v-for="tank in tanks" v-bind:key="tank.id">
                <strong>Name:</strong> {{ tank.name }},
                <strong>Capacity:</strong> {{ tank.capacity }}
            </li>
        </ul>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            loading: false,
            tanks: this.tanks,
            error: null,
            userId: null
        };
    },
    created() {
        axios.get('auth/user').then(res => {
            this.userId = res.data.data.id;
            this.fetchData();
        });


    },
    methods: {
        fetchData() {
            this.error = this.tanks = null;
            this.loading = true;
            axios
                .get('auth/tanks/' + this.userId)
                .then(response => {
                    this.loading = false;
                    this.tanks = response.data.data;
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message;
                });
        }
    }
}

</script>
