<template>
    <div id="main">
        <header id="header">

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
