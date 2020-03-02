<template>


  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-6">
        <div class="card card-default">
         <header class="modal-card-head">
                <p class="modal-card-title">Login</p>
            </header>
          <div class="card-body">
            <div class="alert alert-danger" v-if="has_error && !success">
              <p v-if="error == 'login_error'">Validation Errors.</p>
              <p v-else>Error, unable to connect with these credentials.</p>
            </div>
            <form autocomplete="off" @submit.prevent="login" method="post">
              <b-field label="Email">
                <b-input type="email" id="email" placeholder="user@example.com" v-model="email" required></b-input>
              </b-field>
              <b-field label="Password">
                <b-input type="password" id="password" v-model="password" required password-reveal></b-input>
              </b-field>
              <button type="submit" class="btn btn-primary">Signin</button>
              <b-button type="is-info" @click="demo()">Demo</b-button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

  export default {
    data() {
      return {
        email: null,
        password: null,
        success: true,
        has_error: true,
        error: '',
      }
    },
    mounted() {
      //
    },
    methods: {
      login() {
        // get the redirect object
        var redirect = this.$auth.redirect()
        var app = this
        this.$auth.login({
          data: {
            email: app.email,
            password: app.password,
          },
          success: function() {
            // handle redirection
            app.success = true

            const redirectTo = 'tanks'
            this.$router.push({name: redirectTo})

          },
          error: function() {
            app.has_error = true
            //app.error = err;
            app.$buefy.toast.open('Incorrect login or password');
            //console.log(app.res);
          },
          rememberMe: true,
          fetchUser: true

        })
      },
      //log in shrimpkeeper with test acount
      demo() {
                this.email = "test123@test";
                this.password = "test123";
                this.login();
            },
    }
  }

</script>
