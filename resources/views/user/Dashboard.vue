<template>
    <div class="container">
       <div class="card card-default">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                {{ $auth.user().name }} Dashboard
                <AppBar />
            </div>
        </div>
    </div>

</template>
<script>
import AppBar from '../AppBar.vue'
import Tanks from '../Tanks'

  export default {
    data() {
      return {
        //
      }
    },
    components: {
      //
      AppBar,
      Tanks
    },
    mounted() {

        //console.log(this.auth.user().id);

    }
  }


</script>
