<template>
    <div id="main">
        <header id="header">
            <h1>ShrimpKeeper</h1>
            <Menu />
        </header>
        <div id="content">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
import Menu from '../js/components/Menu.vue'
  export default {
    data() {
      return {
        //
      }
    },
    components: {
        //
        Menu
    }
  }
</script>
