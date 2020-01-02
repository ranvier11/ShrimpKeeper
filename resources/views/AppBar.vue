<template>
    <div>
        <h1>ShrimpKeeper</h1>

        <p>
            <router-link :to="{ name: 'home' }">Home</router-link> |
            <router-link :to="{ name: 'tanks' }">Tanks</router-link>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>

  export default {
    data() {
      return {
        //
      }
    },
    components: {

    }
  }
</script>
